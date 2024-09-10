<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Product;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index()
    {
        $commands = Command::with(['products','table'])->get();
        
        return view('commands.index', compact('commands'));
    }

    // Mostrar la comanda activa
    public function show($id)
    {
        $command = Command::with(['products', 'table'])->findOrFail($id);
        $products = Product::all(); // Productos disponibles para añadir a la comanda
        
        return view('commands.show', compact('command', 'products'));
    }


    // Agregar un pedido a la comanda
    public function addItem(Request $request, Command $command)
    {
        // Validar los datos entrantes
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Buscar el producto
        $product = Product::findOrFail($request->product_id);

        // Verificar si hay suficiente inventario
        if ($product->unidades < $request->quantity) {
            return redirect()->back()->withErrors(['error' => 'No hay suficiente inventario disponible.']);
        }

        // Restar las unidades del producto
        $product->unidades -= $request->quantity;
        $product->save();

        // Añadir el producto a la comanda usando la tabla pivot
        $command->products()->attach($request->product_id, ['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Producto agregado a la comanda y unidades descontadas.');
    }


}
