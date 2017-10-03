<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'id';
    public function item_price()
    {
        return $this->hasOne('App\Http\Models\ItemPrice', 'id', 'item_price_id');
    }
}
