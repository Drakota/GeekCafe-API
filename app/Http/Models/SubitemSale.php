<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class SubitemSale extends Model
{
    protected $fillable = [
      'subitem_id', 'sale_id', 'sale_item_id'
    ];
    protected $table = 'sale_subitems';
    protected $primaryKey = 'id';
}
