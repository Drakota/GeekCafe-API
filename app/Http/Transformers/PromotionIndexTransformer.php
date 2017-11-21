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
          'reduction' => $promotion->discount,
          'start_date' => $promotion->start_date,
          'end_date' => $promotion->end_date,
        ];
    }

    protected $defaultIncludes = [
        'item',
    ];

    public function includeItem(Promotion $promotion)
    {
      return $this->item($promotion->item, new ItemPromotionTransformer);
    }
}
