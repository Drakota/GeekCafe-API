<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
      'user_id'
    ];
    protected $table = 'sales';
    protected $primaryKey = 'id';
}
