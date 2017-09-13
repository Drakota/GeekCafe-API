<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $incrementing = false;
    protected $fillable = [
      'image', 'id'
    ];
    protected $table = 'images';
    protected $primaryKey = 'id';
}
