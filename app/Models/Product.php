<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'proveedor',
        'precio',
        'unidades',
        'tipo',
        'tienda',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity')->withTimestamps();
    }

   // Relación muchos a muchos con comandas
   public function commands()
   {
       return $this->belongsToMany(Command::class, 'command_product')->withPivot('quantity')->withTimestamps();
   }
}
