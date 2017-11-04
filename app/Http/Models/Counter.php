<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    public $incrementing = false;
    protected $table = 'counters';
    protected $primaryKey = 'id';
}
