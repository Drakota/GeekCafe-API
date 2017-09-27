<?php
namespace App\Http\Transformers;
use App\Http\Models\Item;
use League\Fractal\TransformerAbstract;

class ItemTransformer extends TransformerAbstract
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
          'type' => $item->type->name,
          'image' => env('IMG_URL') . $item->image_id,
        ];
    }

    protected $defaultIncludes = [
        'prices',
        'subitems'
    ];

    public function includePrices(Item $item)
    {
      return $this->collection($item->prices, new ItemPriceTransformer);
    }

    public function includeSubitems(Item $item)
    {
        return $this->collection($item->subitems, new ItemSubitemTransformer);
    }
}
