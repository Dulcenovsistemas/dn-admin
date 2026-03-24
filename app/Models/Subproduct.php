<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subproduct extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'cost_per_portion'
    ];
}
