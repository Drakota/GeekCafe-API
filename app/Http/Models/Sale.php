<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
      'user_id', 'payed', 'amount'
    ];
    protected $table = 'sales';
    protected $primaryKey = 'id';
}
