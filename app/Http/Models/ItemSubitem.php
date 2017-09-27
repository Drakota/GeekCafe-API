<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class ItemSubItem extends Model
{
    public $incrementing = false;
    protected $fillable = [
    ];
    protected $table = 'item_subitems';
    protected $primaryKey = 'id';
    public function subitem()
    {
        return $this->hasOne('App\Http\Models\Subitem', 'id', 'subitem_id');
    }
}
