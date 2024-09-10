<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
        'zona'
    ];
    
    // Relación con las comandas
    public function commands()
    {
        return $this->hasMany(Command::class);
    }

    // Obtener la comanda activa de una mesa
    public function activeCommand()
    {
        return $this->hasOne(Command::class)->where('is_active', true);
    }
}
