<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $table = 'sale_items';
    protected $primaryKey = 'id';
    public function subitems()
    {
        return $this->hasMany('App\Http\Models\SaleSubitem', 'sale_item_id', 'id');
    }
    public function itemprice()
    {
        return $this->hasOne('App\Http\Models\ItemPrice', 'id', 'item_price_id');
    }
}
