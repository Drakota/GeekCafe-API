<?php
namespace App\Http\Transformers;
use App\Http\Models\Item;
use League\Fractal\TransformerAbstract;

class ItemPromotionTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Item $item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'type' => $item->type,
            'image' => env('IMG_URL') . $item->image_id
        ];
    }

}
