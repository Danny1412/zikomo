<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'costo_total'];

    public function inputs()
    {
        return $this->belongsToMany(Input::class, 'input_recipe')
                    ->withPivot('cantidad_usada')
                    ->withTimestamps();
    }

    public function dressings()
    {
        return $this->belongsToMany(Dressing::class, 'dressing_recipe')
                    ->withPivot('cantidad_gramos')
                    ->withTimestamps();
    }

}
