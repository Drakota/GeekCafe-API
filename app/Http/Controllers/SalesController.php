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
use App\Http\Models\ItemPrice;
use App\Http\Models\Subitem;
use App\Http\Models\Sale;
use App\Http\Models\ItemSale;
use App\Http\Models\SubitemSale;

class SalesController extends BaseController
{
    public function checkprice(SaleCreatePost $request)
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
        return response()->json(['order' => [
          'subtotal' => round($price, 2),
          'total' => round($price, 2)
        ]], 200);
    }

    public function create(SaleCreatePost $request)
    {
        $user = $request->user();
        $sale = Sale::create([
          'user_id' => $user->id,
        ]);
        foreach ($request->input()['items'] as $key => $value) {
            $item = ItemPrice::find($value['price_id']);
            $itemsale = ItemSale::create([
              'item_id' => $item->id,
              'sale_id' => $sale->id,
            ]);
            if (isset($value['subitems'])) {
              foreach ($value['subitems'] as $subitemkey => $subitemvalue) {
                SubitemSale::create([
                  'sale_item_id' => $itemsale->id,
                  'subitem_id' => $subitemvalue['id'],
                  'sale_id' => $sale->id,
                ]);
              }
            }
        }
    }
}
