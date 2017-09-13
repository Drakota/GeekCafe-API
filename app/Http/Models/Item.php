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
}
