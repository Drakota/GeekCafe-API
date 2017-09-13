<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class ItemSize extends Model
{
    public $incrementing = false;
    protected $fillable = [
    ];
    protected $table = 'item_subitems';
    protected $primaryKey = 'id';
}
