<?php

    namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'type',
        'category_id',
        'parent_id',
        'unit'
    ];

    // 🔁 Padre
    public function parent()
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    // 🔁 Hijos
    public function children()
    {
        return $this->hasMany(Item::class, 'parent_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function costs()
    {
        return $this->hasMany(ItemCost::class);
    }
}