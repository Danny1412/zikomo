<?php

namespace App\Http\Controllers;

use App\Models\Employed;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $mes = $request->input('mes', Carbon::now()->month); // Obtiene el mes actual si no se proporciona uno
        $anio = $request->input('anio', Carbon::now()->year); // Obtiene el año actual si no se proporciona uno

        $payrolls = Payroll::whereYear('fecha_pago', $anio)
        ->whereMonth('fecha_pago', $mes)
        ->with('empleado')
        ->get();

        $employeds = Employed::all();

        $totalPayrolls = $payrolls->sum('monto');

        return view('admin.bills.index',compact('payrolls', 'employeds', 'totalPayrolls', 'mes', 'anio'));
    }

    public function store(Request $request)
    {
        $validatePayroll = $request->validate([
            'empleado_id' => 'required|exists:employeds,id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'periodo' => 'required|string|max:255',
        ]);

        try {
            Payroll::create($validatePayroll);

            notify()->success('Pago de nómina registrado exitosamente.');

            return redirect()->route('nomina.index');
        } catch (\Exception $e) {
            Log::error('Error al registrar el pago de nómina: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al registrar el pago de nómina: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);
        $employeds = Employed::all();
        return view('admin.bills.edit', compact('payroll', 'employeds'));
    }

    public function update(Request $request, $id)
    {
        $validatePayrroll = $request->validate([
            'empleado_id' => 'required|exists:employeds,id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'periodo' => 'required|string|max:255',
        ]);

        $employed = Payroll::findOrFail($id);
        $employed->update($validatePayrroll);

        notify()->success('Nomina actualizado exitosamente.');

        return redirect()->route('nomina.index'); // Redirect to index page after update
    }

    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();

        notify()->success('Registro de nomina eliminado exitosamente.');

        return to_route('nomina.index'); // Redirect to index page after delete
    }

}
