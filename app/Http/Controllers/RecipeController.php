<?php

namespace App\Http\Controllers;

use App\Models\Dressing;
use App\Models\Input;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with(['inputs','dressings'])->get();

        return view('admin.recipe.index', compact('recipes'));
    }
    public function create()
    {
        $inputs = Input::all();
        $dressings = Dressing::all();
        return view('admin.recipe.create', compact('inputs', 'dressings'));
    }

    public function store(Request $request)
    {
        $recipe = Recipe::create(['nombre' => $request->nombre]);
    
        // Asociar inputs (insumos)
        foreach ($request->inputs as $input_id => $cantidad_usada) {
            if ($cantidad_usada > 0) {
                $recipe->inputs()->attach($input_id, ['cantidad_usada' => $cantidad_usada]);
            }
        }
    
        // Obtener el valor total de gramos por porción enviado desde el formulario
        $totalGramsForPortion = $request->input('total_grams_for_portion', 0);
    
        // Solo procesar si se ingresó un valor para los gramos de aliños
        if ($totalGramsForPortion > 0) {
            $dressings = Dressing::all();
            $costo_dressings = 0;
            $totalKilos = $dressings->sum('cantidad');
    
            foreach ($dressings as $dressing) {
                $gramos_usados = $dressing->calcularCantidadGramosPorTotal($totalKilos, $totalGramsForPortion);
                $recipe->dressings()->attach($dressing->id, ['cantidad_gramos' => $gramos_usados]);
    
                $costo_dressings += $gramos_usados * $dressing->costo / $dressing->cantidad;
            }
    
            // Calcular el costo total de la receta
            $costo_inputs = $recipe->inputs->sum(fn($input) => $input->pivot->cantidad_usada * $input->costo / 1000);
            $costo_total = $costo_inputs + $costo_dressings;
        } else {
            $costo_total = $recipe->inputs->sum(fn($input) => $input->pivot->cantidad_usada * $input->costo / 1000);
        }
    
        // Actualizar la receta con el costo total
        $recipe->update(['costo_total' => $costo_total]);
    
        notify()->success('Receta creada correctamente.');
    
        return to_route('recipe.index');
    }


    public function edit($id)
    {
        $recipe = Recipe::with(['inputs', 'dressings'])->findOrFail($id);
        $inputs = Input::all();
        $dressings = Dressing::all();
        return view('admin.recipe.edit', compact('recipe', 'inputs', 'dressings'));
    }
    
    public function update(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);
        
        // Actualizar el nombre de la receta
        $recipe->update(['nombre' => $request->nombre]);
    
        // Actualizar insumos
        // Sincronizar los insumos con las cantidades usadas
        $insumoData = [];
        foreach ($request->inputs as $input_id => $cantidad_usada) {
            if ($cantidad_usada > 0) {
                $insumoData[$input_id] = ['cantidad_usada' => $cantidad_usada];

            }
        }
        $recipe->inputs()->sync($insumoData);
    
        // Obtener el valor total de gramos por porción enviado desde el formulario
        $totalGramsForPortion = $request->input('total_grams_for_portion', 0);
    
        // Calcular el costo total de los dressings usando el valor total de gramos
        $dressings = Dressing::all();
        $costo_dressings = 0;
        $totalKilos = $dressings->sum('cantidad');

        // Eliminar cualquier asociación previa de dressings
        $recipe->dressings()->detach();
    
        foreach ($dressings as $dressing) {
            if ($totalGramsForPortion > 0) {
                $gramos_usados = $dressing->calcularCantidadGramosPorTotal($totalKilos, $totalGramsForPortion);
                $recipe->dressings()->attach($dressing->id, ['cantidad_gramos' => $gramos_usados]);
                $costo_dressings += $gramos_usados * $dressing->costo / $dressing->cantidad;
            }
        }
    
        // Calcular el costo total de la receta
        $costo_inputs = $recipe->inputs->sum(fn($input) => $input->pivot->cantidad_usada * $input->costo / 1000);
        $costo_total = $costo_inputs + $costo_dressings;
    
        // Actualizar la receta con el costo total
        $recipe->update(['costo_total' => $costo_total]);

        notify()->success('Receta actualizada correctamente.');

        return to_route('recipe.show', $recipe->id);
    }
    
    
    public function show($id)
    {
        $recipe = Recipe::with(['inputs', 'dressings'])->findOrFail($id);

        $totalGramsFromDressings = $recipe->dressings->sum('pivot.cantidad_gramos');

        return view('admin.recipe.show', compact('recipe', 'totalGramsFromDressings'));
    }


    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        notify()->success('Receta eliminada exitosamente.');

        return to_route('recipe.index'); // Redirect to index page after delete
    }

}
