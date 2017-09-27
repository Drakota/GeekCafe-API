<?php
namespace App\Http\Transformers;
use App\Http\Models\ItemPrice;
use League\Fractal\TransformerAbstract;

class ItemPriceTransformer extends TransformerAbstract
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
          'price' => $itemprice->price,
          'size' => isset($itemprice->size->name) ? $itemprice->size->name : null,
        ];
    }

}
