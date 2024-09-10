<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['empleado_id', 'monto', 'fecha_pago', 'periodo'];

    // Relación inversa con el modelo Empleado
    public function empleado()
    {
        return $this->belongsTo(Employed::class);
    }
}
