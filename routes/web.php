<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DressingController;
use App\Http\Controllers\EmployedController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TableController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Ruta para los productos
    Route::resource('products', ProductsController::class);
    Route::get('/low-stock-products', [ProductsController::class, 'lowStockProducts']);

    // Ruta para las ordenes
    Route::resource('orders', OrdersController::class);
    Route::get('/Orders/{order}/generarRecibo', [OrdersController::class,'generarRecibo'])->name('generar.recibo');
    Route::put('/Orders/{id}/ordenPagada', [OrdersController::class,'ordenCancelada'])->name('pagar.orden');

    // Ruta para el perfil de usuarios
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para la administracion
    Route::get('admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/ingresos/index', [AdminController::class, 'indexIncome'])->name('ingresos.index');

    // Ruta para el manejo de los empleados
    Route::resource('empleados', EmployedController::class);
    Route::post('Empleados/Importar', [EmployedController::class, 'employedImport'])->name('importar.empleados');

    // Ruta para la nomina
    Route::resource('nomina', PayrollController::class);

    // Ruta para los dressings
    Route::resource('dressing', DressingController::class);
    Route::post('Aliños/importar', [DressingController::class, 'dressingImport'])->name('importar.dressing');

   // Ruta para mostrar el formulario de edición
    Route::get('/settings/total-porciones/edit', [SettingController::class, 'editTotalPorciones'])->name('settings.edit');
    // Ruta para actualizar el valor
    Route::put('/settings/total-porciones', [SettingController::class, 'updateTotalPorciones'])->name('settings.update');
    
    // Ruta para los insumos
    Route::resource('input', InputController::class);
    Route::post('Insumos/Importar', [InputController::class, 'inputImport'])->name('importar.input');

    // Ruta para las recetas
    Route::resource('recipe', RecipeController::class);

    // Ruta para las mesas
    Route::resource('tables', TableController::class);
    Route::get('table/plano', [TableController::class, 'Tables'])->name('planoMesas');
    Route::patch('/mesas/{table}', [TableController::class, 'estado'])->name('estadoUpdate');

    // Ruta para las comandas
    Route::get('commands/index', [CommandController::class, 'index'])->name('command.index');
    Route::get('/comandas/{command}', [CommandController::class, 'show'])->name('commands.show');
    Route::post('/comandas/{command}/items', [CommandController::class, 'addItem'])->name('commands.addItem');

});

require __DIR__.'/auth.php';
