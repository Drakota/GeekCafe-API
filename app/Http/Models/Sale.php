<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
      'user_id', 'payed', 'amount', 'branch_id', 'counter_id', 'discount_off', 'is_active'
    ];
    protected $table = 'sales';
    protected $primaryKey = 'id';
    public function items()
    {
        return $this->hasMany('App\Http\Models\SaleItem', 'sale_id', 'id');
    }
}
