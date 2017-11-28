<?php

namespace App\Http\Requests\Sales;

use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SaleCreatePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
          'items' => ['required'],
          'card_token' => ['required_without:card_pay', 'empty_when:card_pay'],
          'card_pay' => ['required_without:card_token', 'empty_when:card_token', 'boolean'],
          'points' => ['nullable', 'integer'],
          'promotion_id' => ['nullable', 'integer', 'exists:promotions,id'],
          'branch_id' => ['required', 'exists:branches,id'],
          'counter_id' => ['nullable', 'exists:counters,id', 'validCounter:branch_id'],
        ];
        foreach($this->request->get('items') as $key => $val)
        {
          $rules['items.'.$key.'.price_id'] = ['required', 'exists:item_prices,id'];
          if (isset($val['subitems'])) {
            foreach($val['subitems'] as $subitemkey => $subitemval)
            {
              $rules['items.'.$key.'.subitems.'.$subitemkey.'.id'] = ['required', 'exists:subitems,id', 'validSubitem:' . $val['price_id']];
            }
          }
        }
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        throw new StoreResourceFailedException('Could not validate new order.', $validator->errors());
    }

}
