<?php
namespace App\Http\Transformers;
use App\Http\Models\Promotion;
use League\Fractal\TransformerAbstract;

class PromotionIndexTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Promotion $promotion)
    {
        return [
          'id' => $promotion->id,
          'description' => $promotion->description,
          'available_per_user' => $promotion->available_per_user,
          'reduction' => $promotion->reduction,
          'start_date' => $promotion->start_date,
          'end_date' => $promotion->end_date,
        ];
    }

    protected $defaultIncludes = [
        'item_price',
    ];

    public function includeItemPrice(Promotion $promotion)
    {
      return $this->item($promotion->item_price, new ItemPricePromotionTransformer);
    }
}
