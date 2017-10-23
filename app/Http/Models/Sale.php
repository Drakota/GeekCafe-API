<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
      'user_id', 'payed', 'amount'
    ];
    protected $table = 'sales';
    protected $primaryKey = 'id';
    public function items()
    {
        return $this->hasMany('App\Http\Models\SaleItem', 'sale_id', 'id');
    }
}
