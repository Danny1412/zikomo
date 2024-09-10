<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'unidad',
        'medida',
        'costo',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'input_recipe')
                    ->withPivot('cantidad_usada')
                    ->withTimestamps();
    }
}
