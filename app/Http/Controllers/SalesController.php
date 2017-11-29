<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Http\Transformers\SaleTransformer;
use App\Http\Transformers\SaleHistoryTransformer;
use App\Http\Requests\Sales\SaleCreatePost;
use App\Http\Requests\Sales\CheckPricePost;
use App\Http\Models\ItemPrice;
use App\Http\Models\Subitem;
use App\Http\Models\Sale;
use App\Http\Models\ItemSale;
use App\Http\Models\SubitemSale;
use App\Http\Models\UserPromotion;
use App\Http\Traits\PromotionTrait;

class SalesController extends BaseController
{
    use PromotionTrait;

    function __construct()
    {
      \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
    }

    public function checkprice(CheckPricePost $request)
    {
        $order = $this->getprice($request);
        return $order;
    }

    public function view(Request $request, Sale $sale)
    {
       $user = $request->user();
       if ($user->id != $sale->user_id) {
         return response()->json(['status' => 'You are not authorized to see this order!'], 401);
       }
       return $this->response->item($sale, new SaleTransformer);
    }

    public function modify(Request $request, Sale $sale)
    {
       $user = $request->user();
       if ($user->is_employee) {
         $payload = $request->only('is_active', 'payed');
         $this->validation($payload, [
           'is_active' => ['nullable', 'boolean'],
           'payed' => ['nullable', 'boolean'],
         ]);
         $sale->is_active = $payload['is_active'];
         $sale->payed = $payload['payed'];
         $sale->save();
         return $this->response->item($sale, new SaleTransformer);
       }
       else return response()->json(['status' => 'You are unauthorized!'], 401);
    }

    private function getprice($request)
    {
        $user = $request->user();
        $price = 0;
        $reduced = 0;
        $pointsused = 0;

        foreach ($request->input()['items'] as $key => $value) {
            $item = ItemPrice::find($value['price_id']);
            $price += $item->price;
            if (isset($value['subitems'])) {
              foreach ($value['subitems'] as $subitemkey => $subitemvalue) {
                  $subitem = Subitem::find($subitemvalue['id']);
                  $price += $subitem->price != null ? $subitem->price : 0;
              }
            }
        }

        $reduced += $price * ($user->subscription->discount / 100);
        if (isset($request->input()['promotion_id']))
        {
          $wasreduced = $this->usePromotion($request, $reduced);
          if(!$wasreduced) return ['error' => "Promotion Code not applicable for this order!"];
        }
        if (isset($request->input()['points'])) {
          if($request->input()['points'] <= $user->points)
          {
              $pointsused = $request->input()['points'];
              if (($price - $reduced) < $request->input()['points'])
              {
                 $pointsused = ($price - $reduced);
              }
              $reduced += $pointsused;
          }
          else return response()->json(['error' => "Not enough points in your account!"], 403);
        }
        $subtotal = $price;
        $price -= $reduced;
        return ['order' => [
          'points_used' => $pointsused,
          'reduced' => round($reduced, 2),
          'subtotal' => round($subtotal, 2),
          'total' => round($price, 2)
        ]];
    }

    public function create(SaleCreatePost $request)
    {
        $user = $request->user();

        $order = $this->getprice($request);

        if (isset($order['error'])) {
           return response()->json($this->getprice($request), 403);
        }
        $total = $order['order']['total'];
        $reduced = $order['order']['reduced'];

        if (isset($request->input()['promotion_id']))
        {
          UserPromotion::create([
              'promotion_id' => $request->input()['promotion_id'],
              'user_id' => $user->id,
          ]);
        }

        if (isset($request->input()['points']))
        {
          $user->points -= $order['order']['points_used'];
          $user->save();
        }

        if (isset($request->input()['card_token'])) {
          if ($total != 0) {
            $charge = \Stripe\Charge::create(array(
              "amount" => $total * 100,
              "currency" => "cad",
              "description" => "Order Geek Cafe",
              "source" => $request->input()['card_token'],
            ));
          }
          $sale = Sale::create([
            'user_id' => $user->id,
            'branch_id' => $request['branch_id'],
            'counter_id' => $request['counter_id'],
            'discount_off' => $reduced,
            'amount' => $total,
            'payed' => 1,
          ]);
        }
        else if ($request->input()['card_pay'] == true) {
          if ($total != 0) {
            $charge = \Stripe\Charge::create(array(
              "amount" => $total * 100,
              "currency" => "cad",
              "description" => "Order Geek Cafe",
              "customer" => $user->stripe_cus,
            ));
          }
          $sale = Sale::create([
            'user_id' => $user->id,
            'amount' => $total,
            'branch_id' => $request['branch_id'],
            'counter_id' => $request['counter_id'],
            'discount_off' => $reduced,
            'payed' => 1,
          ]);
        }
        else {
          $sale = Sale::create([
            'user_id' => $user->id,
            'amount' => $total,
            'branch_id' => $request['branch_id'],
            'discount_off' => $reduced,
            'counter_id' => $request['counter_id'],
          ]);
        }
        $user->points += round($total * 0.2, 2); // TODO CHANGE THIS GAIN POINTS EVEN WHEN NOT PAYED
        $user->save();
        foreach ($request->input()['items'] as $key => $value) {
            $item = ItemPrice::find($value['price_id']);
            $itemsale = ItemSale::create([
              'item_price_id' => $item->id,
              'sale_id' => $sale->id,
            ]);
            if (isset($value['subitems'])) {
              foreach ($value['subitems'] as $subitemkey => $subitemvalue) {
                SubitemSale::create([
                  'sale_item_id' => $itemsale->id,
                  'subitem_id' => $subitemvalue['id'],
                ]);
              }
            }
        }
        return response()->json(['status' => 'Order proceeded successfully!',
        'point_balance' => $user->points], 200);
    }

    public function history(Request $request)
    {
        $user = $request->user();
        $paginator = $user->sales()->where('is_active', 0)->orderBy('created_at', 'desc')->paginate(is_numeric($request->input('limit')) ? $request->input('limit') : 10);
        return $this->paginate($paginator, new SaleHistoryTransformer);
    }

    public function currentorders(Request $request)
    {
        $user = $request->user();
        if ($user->is_employee) {
          $paginator = Sale::where('is_active', 1)->paginate(is_numeric($request->input('limit')) ? $request->input('limit') : 10);
          return $this->paginate($paginator, new SaleTransformer);
        }
        else return response()->json(['status' => 'You are unauthorized!'], 401);
    }
}
