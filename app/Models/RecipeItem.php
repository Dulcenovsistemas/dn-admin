<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeItem extends Model
{
    protected $fillable = [
        'recipe_id',
        'item_type',
        'item_id',
        'quantity',
        'unit'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}