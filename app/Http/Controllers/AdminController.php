<?php

namespace App\Http\Controllers;

use App\Models\income;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function indexIncome()
    {
        // Cargar los ingresos junto con la orden asociada y los productos de la orden
        $incomes = income::with('order.products')->get();

        // Calcular el monto total de los ingresos
        $totalIncome = $incomes->sum('monto');

        return view('admin.income.index', compact('incomes', 'totalIncome'));
    }

}
