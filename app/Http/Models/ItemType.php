<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    public $incrementing = false;
    protected $fillable = [
    ];
    protected $table = 'item_types';
    protected $primaryKey = 'id';
}
