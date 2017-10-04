<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Http\Requests\Sales\SaleCreatePost;
use App\Http\Requests\Sales\CheckPricePost;
use App\Http\Models\ItemPrice;
use App\Http\Models\Subitem;
use App\Http\Models\Sale;
use App\Http\Models\ItemSale;
use App\Http\Models\SubitemSale;

class SalesController extends BaseController
{
    function __construct()
    {
      \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
    }

    public function checkprice(CheckPricePost $request)
    {
        $order = $this->getprice($request);
        return $order;
    }

    private function getprice($request)
    {
        $price = 0;
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
        return ['order' => [
          'subtotal' => round($price, 2),
          'total' => round($price, 2)
        ]];
    }

    public function create(SaleCreatePost $request)
    {
        $user = $request->user();

        if (isset($request->input()['card_token'])) {
          $charge = \Stripe\Charge::create(array(
            "amount" => $this->getprice($request)['order']['total'] * 100,
            "currency" => "cad",
            "description" => "Order Geek Cafe",
            "source" => $request->input()['card_token'],
          ));
          $sale = Sale::create([
            'user_id' => $user->id,
            'amount' => $this->getprice($request)['order']['total'],
            'payed' => 1,
          ]);
        }
        else if ($request->input()['card_pay'] == true) {
          $charge = \Stripe\Charge::create(array(
            "amount" => $this->getprice($request)['order']['total'] * 100,
            "currency" => "cad",
            "description" => "Order Geek Cafe",
            "customer" => $user->stripe_cus,
          ));
          $sale = Sale::create([
            'user_id' => $user->id,
            'amount' => $this->getprice($request)['order']['total'],
            'payed' => 1,
          ]);
        }
        else {
          $sale = Sale::create([
            'user_id' => $user->id,
            'amount' => $this->getprice($request)['order']['total'],
          ]);
        }
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
        return response()->json(['status' => 'Order proceeded successfully!'], 200);
    }
}
