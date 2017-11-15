<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'id';
    public function item()
    {
        return $this->hasOne('App\Http\Models\Item', 'id', 'item_id');
    }
}
