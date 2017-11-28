<?php
namespace App\Http\Traits;

use App\Http\Models\Promotion;
use App\Http\Models\UserPromotion;
use App\Http\Models\ItemPrice;
use Carbon\Carbon;

trait PromotionTrait {
    public function usePromotion($request, &$reduced) {
        $applicable = false;
        $user = $request->user();
        $promotion = Promotion::find($request->input()['promotion_id']);
        if($promotion->start_date > Carbon::today() || $promotion->end_date < Carbon::today())
          return $applicable;
        if(count($user->used_promotions->where('promotion_id', $promotion->id)) >= $promotion->available_per_user)
          return $applicable;

        $itemprices = array_map(function($element) {
            return ItemPrice::find($element['price_id']);
        }, $request->input()['items']);
        foreach ($itemprices as $itemprice) {
          if ($itemprice->item->id == $promotion->item_id) {
              $applicable = true;
              $targetitem = $itemprice->price;
          }
        }
        if($applicable)
        {
          if (strpos($promotion->discount, '%') !== false) {
            $discount = str_replace('%', '', $promotion->discount);
            $reduced += ($targetitem  * floatval($discount) / 100);
          }
          else $reduced += floatval($promotion->discount);
        }
        return $applicable;
    }
}
