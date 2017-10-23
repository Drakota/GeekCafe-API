<?php
namespace App\Http\Transformers;
use App\Http\Models\SaleSubitem;
use League\Fractal\TransformerAbstract;

class SaleSubitemTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(SaleSubitem $salesubitem)
    {
        return [
          'id' => $salesubitem->id,
          'subitem_id' => $salesubitem->subitem->id,
          'name' => $salesubitem->subitem->name,
          'price' => $salesubitem->subitem->price,
          'image' => env('IMG_URL') . $salesubitem->subitem->image_id,
        ];
    }
}
