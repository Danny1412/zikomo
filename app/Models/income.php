<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class income extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'monto',
        'fecha'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
