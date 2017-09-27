<?php
namespace App\Http\Transformers;
use App\Http\Models\ItemType;
use League\Fractal\TransformerAbstract;

class ItemTypeTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(ItemType $itemtype)
    {
        return [
          'id' => $itemtype->id,
          'name' => $itemtype->name,
          'image' => env('IMG_URL') . $itemtype->image_id,
        ];
    }

}
