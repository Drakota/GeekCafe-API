<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class ItemSale extends Model
{
    protected $fillable = [
      'item_price_id', 'sale_id'
    ];
    protected $table = 'sale_items';
    protected $primaryKey = 'id';
}
