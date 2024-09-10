<?php

namespace App\Http\Controllers;

use App\Models\Employed;
use App\Models\Payroll;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EmployedController extends Controller
{
    public function index()
    {
        $employeds = Employed::all();

        return view('admin.employed.index', compact('employeds'));
    }

    public function store(Request $request)
    {
        $validateEmployed = $request->validate([
            'nombre' => 'required|string|max:150',
            'apellido' => 'required|string|max:150',
            'cedula' => 'required|max:150',
            'cargo' => 'required|string|max:150',
            'salario' => 'required|numeric'
        ]);

        Employed::create($validateEmployed);

        notify()->success('Empleado registrado exitosamente.');

        return back();
    }

    public function edit(Employed $employed)
    {
        return view('admin.employed.edit', [
            'employed' => $employed
        ]); 
    }

    public function update(Request $request, $id)
    {
    $validateEmployed = $request->validate([
        'nombre' => 'required|string|max:150',
        'apellido' => 'required|string|max:150',
        'cedula' => 'required|max:150',
        'cargo' => 'required|string|max:150',
        'salario' => 'required|numeric'
    ]);

    $employed = Employed::findOrFail($id);
    $employed->update($validateEmployed);

    notify()->success('Empleado actualizado exitosamente.');

    return redirect()->route('empleados.index'); // Redirect to index page after update
    }

    public function destroy($id)
    {
        $employed = Employed::findOrFail($id);
        $employed->delete();

        notify()->success('Empleado eliminado exitosamente.');

        return redirect()->route('empleados.index'); // Redirect to index page after delete
    }

    public function employedImport(Request $request)
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
                Employed::create([
                    'nombre' => $row[0],
                    'apellido' => $row[1],
                    'cedula' => $row[2],
                    'cargo' => $row[3],
                    'salario' => $row[4],
                ]);
            }
    
            notify()->success('Archivo de empleados importado con exito');

            return back();
    
        } catch (\Exception $e) {
            // Manejo de errores

            notify()->error('Error al importar el archivo de empleados' . $e->getMessage());
        
            return back();
        }
    }

}
