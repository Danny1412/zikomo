<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Product;

class CheckLowStock
{
    public function handle(Request $request, Closure $next)
    {
        // Obtener productos con bajo stock
        $lowStockProducts = Product::where('unidades', '<=', 5)->get();

        // Crear mensajes de alerta
        $lowStockMessages = [];
        foreach ($lowStockProducts as $product) {
            $lowStockMessages[] = 'El producto ' . $product->nombre . ' tiene pocas unidades (' . $product->unidades . ').';
        }

        // Almacenar los mensajes de alerta en la sesión
        if (!empty($lowStockMessages)) {
            session()->flash('lowStockMessages', $lowStockMessages);
        }


        return $next($request);
    }
}
