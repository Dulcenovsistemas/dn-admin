<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id'
    ];

    // 🔁 Padre (categoría superior)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // 🔁 Hijos (subcategorías)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // 🔗 Items dentro de esta categoría
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}