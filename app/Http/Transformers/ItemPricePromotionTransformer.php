<?php
namespace App\Http\Transformers;
use App\Http\Models\ItemPrice;
use League\Fractal\TransformerAbstract;

class ItemPricePromotionTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(ItemPrice $itemprice)
    {
        return [
          'id' => $itemprice->id,
          'item' => [
            'id' => $itemprice->item->id,
            'name' => $itemprice->item->name,
            'description' => $itemprice->item->description,
            'type' => $itemprice->item->type,
            'image' => env('IMG_URL') . $itemprice->item->image,
          ],
          'price' => $itemprice->price,
          'size' => isset($itemprice->size->name) ? $itemprice->size->name : null,
        ];
    }

}
