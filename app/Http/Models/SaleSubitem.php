<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class SaleSubitem extends Model
{
    protected $table = 'sale_subitems';
    protected $primaryKey = 'id';
    public function subitem()
    {
        return $this->hasOne('App\Http\Models\Subitem', 'id', 'subitem_id');
    }
}
