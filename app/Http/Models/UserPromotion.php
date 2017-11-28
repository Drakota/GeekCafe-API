<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class UserPromotion extends Model
{
    protected $fillable = [
        'promotion_id', 'user_id'
    ];
    protected $table = 'user_promotions';
    protected $primaryKey = 'id';
}
