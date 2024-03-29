<?php
namespace App\Http\Transformers;
use App\Http\Models\Sale;
use League\Fractal\TransformerAbstract;

class SaleHistoryTransformer extends TransformerAbstract
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
          'amount' => $sale->amount,
          'created_at' => $sale->created_at,
        ];
    }
}
