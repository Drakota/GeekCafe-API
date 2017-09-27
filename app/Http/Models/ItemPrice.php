<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    protected $fillable = [
    ];
    protected $table = 'item_prices';
    protected $primaryKey = 'id';
    public function size()
    {
        return $this->hasOne('App\Http\Models\ItemSize', 'id', 'size_id');
    }
    public function item()
    {
        return $this->hasOne('App\Http\Models\Item', 'id', 'item_id');
    }
}
