<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCost extends Model
{
    protected $fillable = [
        'item_id',
        'cost_type',
        'cost'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}