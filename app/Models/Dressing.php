<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dressing extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'unidad',
        'cantidad',
        'costo',
    ];

    public function calcularCantidadGramos($param)
    {
        return $this->cantidad  / $param;
    }

    public function calcularCantidadGramosPorTotal($param1, $param)
    {
        $porcentajeKilos = $this->cantidad / $param1;

        return $porcentajeKilos * $param;
    }

    public function getCostoPorGramoAttribute()
    {
        return $this->costo / 1000; // Asumiendo que el costo está en pesos por kilo
    }


    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'dressing_recipe')
                    ->withPivot('porciones_usadas')
                    ->withTimestamps();
    }
}
