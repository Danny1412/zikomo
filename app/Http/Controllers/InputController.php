<?php

namespace App\Http\Controllers;

use App\Models\Input;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InputController extends Controller
{
    public function index()
    {
        $inputs = Input::all();

        return view('admin.input.index', compact('inputs'));
    }

    public function store(Request $request)
    {
        $validateInput = $request->validate([
            'nombre' => 'required|string',
            'unidad' => 'required|string',
            'medida' => 'required|numeric|min:1',
            'costo' => 'required|numeric|min:1',
        ]);

        Input::create($validateInput);

        notify()->success('Insumo creado correctamente.');

        return back();
    }

    public function edit(Input $input)
    {
        return view('admin.input.edit', [
            'input' => $input
        ]); 
    }

    public function update(Request $request, Input $input)
    {
        $validateInput = $request->validate([
            'nombre' => 'required|string',
            'unidad' => 'required|string',
            'medida' => 'required|numeric|min:1',
            'costo' => 'required|numeric|min:1',
        ]);

        $input->update($validateInput);
        
        notify()->success('Insumo actualizado exitosamente.');

        return to_route('input.index'); // Redirect to index page after update
    }
    
    public function destroy($id)
    {
        $input = Input::findOrFail($id);
        $input->delete();

        notify()->success('Insumo eliminado exitosamente.');

        return to_route('input.index'); // Redirect to index page after delete
    }

    public function inputImport(Request $request)
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
                Input::create([
                    'nombre' => $row[0],
                    'unidad' => $row[1],
                    'medida' => $row[2],
                    'costo' => $row[3],
                ]);
            }
    
            notify()->success('Archivo de insumos importado con exito');

            return back();
    
        } catch (\Exception $e) {
            // Manejo de errores

            notify()->error('Error al importar el archivo de insumos' . $e->getMessage());
        
            return back();
        }
    }

}
