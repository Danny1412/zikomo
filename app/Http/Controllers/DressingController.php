<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dressing;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DressingController extends Controller
{
    public function index()
    {
        $totalPortion = DB::table('settings')->value('value');
        $dressings = Dressing::all();
    
        $totalGramsForPortion = 0; // Variable acumulativa para almacenar el total de gramos
    
        foreach ($dressings as $dressing) {
            $dressing->cantidad_gramos = $dressing->calcularCantidadGramos($totalPortion);
            $totalGramsForPortion += $dressing->cantidad_gramos; // Sumar la cantidad de gramos de cada dressing
        }
    
        return view('admin.dressing.index', compact('dressings', 'totalPortion', 'totalGramsForPortion'));
    }    

    public function create()
    {
        return view('dressings.create');
    }

    public function store(Request $request)
    {
        $validateDressing = $request->validate([
            'nombre' => 'required|string|max:255',
            'unidad' => 'required|string|max:255',
            'cantidad' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0',
        ]);

        Dressing::create($validateDressing);

        notify()->success('Aliño creado exitosamente.');

        return to_route('dressing.index');
    }

    public function edit(Dressing $dressing)
    {
        return view('admin.dressing.edit', compact('dressing'));
    }

    public function update(Request $request, Dressing $dressing)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'unidad' => 'required|string|max:255',
            'cantidad' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0',
        ]);

        $dressing->update($request->all());

        notify()->success('Aliño actualizado exitosamente.');

        return to_route('dressing.index');
    }

    public function destroy(Dressing $dressing)
    {
        $dressing->delete();

        notify()->success('Aliño eliminado exitosamente.');
        
        return to_route('dressing.index');
    }

    public function dressingImport(Request $request)
    {
        try {
            // Subir el archivo y obtener su ruta
            $file = $request->file('excel');
    
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
    
            // Asumiendo que la primera fila es el encabezado, empieza en la segunda fila
            foreach ($rows as $index => $row) {
                if ($index === 0) {
                    continue; // saltar el encabezado
                }

                // Crear el bien nacional
                Dressing::create([
                    'nombre' => $row[0],
                    'unidad' => $row[1],
                    'cantidad' => $row[2],
                    'costo' => $row[3],
                ]);
            }
    
            notify()->success('Archivo de aliños importado con exito');

            return back();
    
        } catch (\Exception $e) {
            // Manejo de errores

            notify()->error('Error al importar el archivo de aliños' . $e->getMessage());
        
            return back();
        }
    }
}
