<?php
namespace App\Http\Transformers;
use App\Http\Models\Sale;
use League\Fractal\TransformerAbstract;

class SaleTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Sale $sale)
    {
        return [
          'id' => $sale->id,
          'payed' => (boolean)$sale->payed,
          'amount' => $sale->amount,
          'is_active' => (boolean)$sale->is_active,
          'created_at' => $sale->created_at,
        ];
    }

    protected $defaultIncludes = [
        'items',
    ];

    public function includeItems(Sale $sale)
    {
      return $this->collection($sale->items, new SaleItemTransformer);
    }
}
