<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class command extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'is_active'];

    // Relación con las mesas
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Relación muchos a muchos con productos
    public function products()
    {
        return $this->belongsToMany(Product::class, 'command_product')->withPivot('quantity')->withTimestamps();
    }
}
