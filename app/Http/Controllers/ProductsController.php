<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(35);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $valdiarProducto = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'proveedor' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'unidades' => 'required|integer',
            'tipo' => 'required|string|max:255',
            'tienda' => 'required|string|max:255',

        ]);
        
        Product::create($valdiarProducto);

        notify()->success('Producto creado correctamente');

        return to_route('products.index');
    }
    public function edit(Product $product)
    {
       return view('products.edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validarProducto = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'proveedor' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'unidades' => 'required|integer',
            'tipo' => 'required|string|max:255',
            'tienda' => 'required|string|max:255',
        ]);

       $product->update($validarProducto);

        return to_route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return to_route('products.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function lowStockProducts()
    {
        $lowStockProducts = Product::where('unidades', '<=', 5)->get();
        return response()->json($lowStockProducts);
    }

}
