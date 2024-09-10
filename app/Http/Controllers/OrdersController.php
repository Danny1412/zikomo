<?php

namespace App\Http\Controllers;

use App\Models\income;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Add this line
use Carbon\Carbon;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('products')->paginate(35);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('unidades', '>', 0)->get();
        return view('orders.create', compact('products'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $products = Product::all();
        return view('orders.edit', compact('order', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'tipo' => 'required|string|in:Para llevar,Para comer aquí',
            'estatus' => 'required',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:products,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $order = new Order();
            $order->cliente = $request->cliente;
            $order->cedula = $request->cedula;
            $order->tipo = $request->tipo;
            $order->estatus = $request->estatus;
            $order->fecha_entrega = Carbon::now();
            $order->save();

            foreach ($request->productos as $producto) {
                $order->products()->attach($producto['producto_id'], ['quantity' => $producto['cantidad']]);
                $product = Product::find($producto['producto_id']);
                if ($product->unidades < $producto['cantidad']) {
                    throw new \Exception('La cantidad solicitada excede el stock disponible.');
                }
                $product->unidades -= $producto['cantidad'];
                $product->save();
            }

            DB::commit();

            notify()->success('Orden creada exitosamente.');

            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la orden: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al crear la orden: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'tipo' => 'required|string|in:Para llevar,Para comer aquí',
            'estatus' => 'required',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|integer|exists:products,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $id) {
            $order = Order::findOrFail($id);
            $order->update([
                'cliente' => $request->input('cliente'),
                'cedula' => $request->input('cedula'),
                'tipo' => $request->input('tipo'),
                'estatus' => $request->input('estatus'),
                'fecha_entrega' => Carbon::now(),
            ]);

            // Restore previous inventory
            foreach ($order->products as $product) {
                $product->unidades += $product->pivot->quantity;
                $product->save();
            }

            $order->products()->detach();

            foreach ($request->input('productos') as $producto) {
                $product = Product::findOrFail($producto['producto_id']);
                if ($product->unidades < $producto['cantidad']) {
                    throw new \Exception('La cantidad solicitada excede el stock disponible.');
                }

                $order->products()->attach($producto['producto_id'], ['quantity' => $producto['cantidad']]);
                $product->unidades -= $producto['cantidad'];
                $product->save();
            }
        });

        notify()->success('Orden actualizada correctamente.');

        return to_route('orders.index');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $order = Order::findOrFail($id);

            // Restore inventory before deleting the order
            foreach ($order->products as $product) {
                $product->unidades += $product->pivot->quantity;
                $product->save();
            }

            // Detach products and delete the order
            $order->products()->detach();
            $order->delete();

            // Temporarily disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Reorder the IDs
            $orders = Order::orderBy('id')->get();
            $startId = 1;

            foreach ($orders as $order) {
                $currentId = $order->id;
                DB::table('orders')->where('id', $currentId)->update(['id' => $startId]);

                // Update the foreign key in the order_product table
                DB::table('order_product')->where('order_id', $currentId)->update(['order_id' => $startId]);

                $startId++;
            }

            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // Reset the auto-increment value
            $maxId = Order::max('id') + 1;
            DB::statement("ALTER TABLE orders AUTO_INCREMENT = $maxId");

            DB::commit();

            notify()->success('Orden eliminada y IDs reordenados correctamente.');

            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al eliminar la orden: ' . $e->getMessage()]);
        }
    }

    public function generarRecibo(Order $order)
    {
        $customer = new Buyer([
            'name'          => $order->cliente,
            'custom_fields' => [
                'cedula' => $order->cedula,
            ],
        ]);
        
        $seller = new Buyer([
            'name'          => auth()->user()->name,
            'custom_fields' => [
                'cedula' => auth()->user()->email,
            ],
        ]);
        
        foreach ($order->products as $product) {
            $items[] = InvoiceItem::make($product->nombre)->pricePerUnit($product->precio)->quantity($product->pivot->quantity);
        }

        
        $invoice = Invoice::make()
            ->buyer($customer)
            ->seller($seller)
            ->currencySymbol('Bs')
            ->currencyCode('VES')
            ->taxRate(15)
            ->dateFormat('d/m/Y')
            ->logo('img/zikomo.png')
            ->addItems($items);
        
        return $invoice->stream();
    }

    public function ordenCancelada($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::findOrFail($id);

            // Cambiar el estado de la orden
            $isCurrentlyPaid = $order->estatus === 'Pagado';
            $order->estatus = $isCurrentlyPaid ? 'Pendiente' : 'Pagado';
            $order->save();

            // Si la orden se marca como "Pagada" y no estaba registrada previamente
            if (!$isCurrentlyPaid && $order->estatus === 'Pagado') {
                // Calcular el monto total de la orden
                $total = $order->products->sum(function($product) {
                    return $product->pivot->quantity * $product->precio;
                });

                // Registrar el income
                income::create([
                    'order_id' => $order->id,
                    'monto' => $total,
                    'fecha' => Carbon::now(),
                ]);
            } elseif ($isCurrentlyPaid && $order->estatus === 'Pendiente') {
                // Eliminar el registro de income si la orden cambia de "Pagado" a "Pendiente"
                income::where('order_id', $order->id)->delete();
            }

            DB::commit();

            notify()->success('Estado de la orden actualizado exitosamente.');
            return to_route('orders.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar el estado de la orden: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al actualizar el estado de la orden: ' . $e->getMessage()]);
        }
    }

}
