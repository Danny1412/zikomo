<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();

        return view('tables.index', compact('tables'));
    }

    public function Tables()
    {
        $tables = Table::all();

        return view('tables.indexTable', compact('tables'));
    }

    // Cambiar el estado de una mesa (Ocupar/Desocupar)
    public function estado(Request $request, Table $table)
    {
        $table->estado = !$table->estado; // Cambia el estado de la mesa

        // Si la mesa se está ocupando, crea una nueva comanda
        if ($table->estado) {
            $table->commands()->create(); // Crea la comanda activa
        } else {
            // Si la mesa se está desocupando, cierra la comanda activa
            $table->activeCommand()->update(['is_active' => false]);
        }

        $table->save();

        return response()->json(['success' => true, 'estado' => $table->estado]);
    }


    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
    {
        $validateTable = $request->validate([
            'nombre' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);
        
        Table::create($validateTable);

        notify()->success('Mesa creada correctamente');

        return to_route('tables.index');
    }
    public function edit(Table $table)
    {
       return view('tables.edit', [
            'table' => $table
        ]);
    }

    public function update(Request $request, Table $table)
    {
        $validateTable = $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

       $table->update($validateTable);

        notify()->success('Mesa actualizada correctamente.');

        return to_route('tables.index');
    }

    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();

        notify()->success('Mesa eliminada correctamente.');

        return to_route('tables.index');
    }
}
