<?php
namespace App\Http\Transformers;
use App\Http\Models\SaleItem;
use League\Fractal\TransformerAbstract;

class SaleItemTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(SaleItem $saleitem)
    {
        return [
          'id' => $saleitem->id,
          'item_id' => $saleitem->itemprice->item->id,
          'name' => $saleitem->itemprice->item->name,
          'price' => $saleitem->itemprice->price,
          'size' => $saleitem->itemprice->size->name,
          'type' => $saleitem->itemprice->item->type->name,
          'image' => env('IMG_URL') . $saleitem->itemprice->item->image_id,
        ];
    }

    protected $defaultIncludes = [
        'subitems',
    ];

    public function includeSubitems(SaleItem $saleitem)
    {
      return $this->collection($saleitem->subitems, new SaleSubitemTransformer);
    }
}
