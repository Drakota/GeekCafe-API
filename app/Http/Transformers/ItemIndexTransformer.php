<?php
namespace App\Http\Transformers;
use App\Http\Models\Item;
use League\Fractal\TransformerAbstract;

class ItemIndexTransformer extends TransformerAbstract
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
          'image' => env('IMG_URL') . $item->image_id,
        ];
    }

}
