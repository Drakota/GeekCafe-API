<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public $incrementing = false;
    protected $fillable = [
    ];
    protected $table = 'branches';
    protected $primaryKey = 'id';
    public function counters()
    {
        return $this->hasMany('App\Http\Models\Counter', 'branch_id', 'id');
    }
}
