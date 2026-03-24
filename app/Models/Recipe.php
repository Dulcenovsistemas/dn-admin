<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Ingredient;
use App\Models\RecipeItem;

/**
 * @property float $labor_cost
 * @property float $yield
 * @property \Illuminate\Database\Eloquent\Collection $items
 */

class Recipe extends Model
{
    protected $fillable = [
        'name',
        'type',
        'image',
        'labor_cost',
        'yield'
    ];

    public function items()
    {
        return $this->hasMany(RecipeItem::class);
    }

    public function calculateCost()
    {
        $total = 0;

        foreach ($this->items as $item) {

            if ($item->item_type == 'ingredient') {

                $ingredient = Ingredient::find($item->item_id);

                if($ingredient){
                    $total += $item->quantity * $ingredient->cost_per_unit;
                }

            }

            if ($item->item_type == 'recipe') {

                $recipe = Recipe::find($item->item_id);

                if($recipe){
                    $total += $item->quantity * $recipe->calculateCost();
                }

            }

        }

        $total += $this->labor_cost ?? 0;

        return $total;
    }

    public function unitCost()
    {
        if(!$this->yield || $this->yield == 0){
            return 0;
        }

        return $this->calculateCost() / $this->yield;
    }
}
