<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $incrementing = false;
    protected $fillable = [
    ];
    protected $table = 'items';
    protected $primaryKey = 'id';
    public function type()
    {
        return $this->hasOne('App\Http\Models\ItemType', 'id', 'type_id');
    }
    public function prices()
    {
        return $this->hasMany('App\Http\Models\ItemPrice', 'item_id', 'id');
    }
    public function subitems()
    {
        return $this->hasMany('App\Http\Models\ItemSubitem', 'item_id', 'id');
    }
}
