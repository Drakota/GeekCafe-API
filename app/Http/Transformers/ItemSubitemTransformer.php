<?php
namespace App\Http\Transformers;
use App\Http\Models\ItemSubitem;
use League\Fractal\TransformerAbstract;

class ItemSubitemTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(ItemSubitem $itemsubitem)
    {
        return [
          'id' => $itemsubitem->subitem->id,
          'name' => $itemsubitem->subitem->name,
          'price' => $itemsubitem->subitem->price,
          'image' => env('IMG_URL') . $itemsubitem->subitem->image_id,
        ];
    }

}
