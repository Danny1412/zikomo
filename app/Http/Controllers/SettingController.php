<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    // Mostrar el formulario de edición
    public function editTotalPorciones()
    {
        // Obtener el valor actual de las porciones
        $totalPortion = DB::table('settings')->where('key', 'total_porciones')->value('value');

        // Retornar la vista con el valor actual
        return view('admin.setting.edit', compact('totalPortion'));
    }

    // Actualizar el valor de las porciones
    public function updateTotalPorciones(Request $request)
    {
        $request->validate([
            'total_porciones' => 'required|integer|min:1',
        ]);

        // Actualizar el valor en la base de datos
        DB::table('settings')->where('key', 'total_porciones')->update([
            'value' => $request->total_porciones
        ]);

        notify()->success('Total de porciones actualizado.');

        // Redirigir con un mensaje de éxito
        return to_route('dressing.index');
    }
}
