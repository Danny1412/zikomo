<x-app-layout>
<div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
    <h1 class="text-2xl font-semibold text-gray-900 ">{{ $recipe->nombre }}</h1>

    <h3 class="mb-2 text-lg font-bold">Insumos Utilizados</h3>
    <table  class="min-w-full mb-2">
        <thead class="bg-white border-b">
            <tr class="border border-gray-400">
                <th scope="col"
                class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">Nombre</th>
                <th scope="col"
                class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">Cantidad usadas en gramos(g) por el total de gramos ingresados para la receta</th>
                <th scope="col"
                class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">Costo Total en base a los gramos usados (Por costo de los insumos) COP</th>
            </tr>
        </thead>
        <tbody class="border border-gray-400 " id="table-body">
            @foreach($recipe->inputs as $inputs)
            <tr class="bg-orange-300 border-b border-gray-400">
                <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">{{ $inputs->nombre }}</td>
                <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">{{ $inputs->pivot->cantidad_usada }}</td>
                <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x"> <!-- {{ number_format($inputs->pivot->cantidad_usada * $inputs->costo / 1000, 2) }} --> </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if ($recipe->dressings->isEmpty())
        <p class="mb-4 text-2xl font-bold text-center">No hay aliños usados para esta receta</p>
    @else
        <h3  class="mb-2 text-lg font-bold">Aliños Utilizados</h3>
        <p class="text-lg font-bold"> Total de gramos ingresados para la receta : {{ $totalGramsFromDressings }} (gr)</p>
        <table class="min-w-full mb-2">
            <thead class="bg-white border-b">
                <tr class="border border-gray-400">
                    <th scope="col"
                    class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">Nombre</th>
                    <th scope="col"
                    class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">Cantidad en gramos(gr) usadas por el total de gramos ingresados para la receta</th>
                    <th scope="col"
                    class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">Costo total en base a los gramos usados (Por costo de los aliños) COP</th>
                </tr>
            </thead>
            <tbody class="border border-gray-400 " id="table-body">
                @foreach($recipe->dressings as $dressing)
                <tr class="bg-orange-300 border-b border-gray-400">
                    <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">{{ $dressing->nombre }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">{{ number_format($dressing->pivot->cantidad_gramos, 2)}}</td> 
                    <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x"> <!-- {{ number_format($dressing->pivot->cantidad_gramos * $dressing->costo_por_gramo, 2) }} --></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    

    <a class="px-4 py-2 my-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500" href="{{ route('recipe.edit', $recipe->id) }}">Editar Receta</a>
    <a class="px-4 py-2 my-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500" href="{{ route('recipe.index') }}">Volver</a>
    
    <div class="p-6 mt-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Planificación de Pasteles</h2>

        <form>
            <label for="num_cakes" class="block font-bold text-gray-700">Número de Pasteles:</label>
            <input type="number" id="num_cakes" class="w-full px-3 py-2 mb-4 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">

            <div id="results" class="mt-4"></div>

            <div class="flex items-center justify-between mt-5">
                <button type="button" onclick="calculate()" class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline">
                    Calcular
                </button>
            </div>
        </form>
    </div>

    <script>
function calculate() {
    const numCakes = document.getElementById('num_cakes').value;
    const recipe = @json($recipe);
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '';  // Limpiar resultados anteriores

    if (numCakes > 0) {
        let totalCost = 0;
        let totalCostByUnits = 0;

        // Calcular insumos
        recipe.inputs.forEach(input => {
            // Cálculo por gramos (por pastel)
            const requiredAmountPerCake = input.pivot.cantidad_usada / numCakes;
            const costPerCake = requiredAmountPerCake * input.costo / 1000;

            // Cálculo por unidades totales
            const requiredAmountTotal = Number(input.pivot.cantidad_usada);
            const costTotal = requiredAmountTotal * input.costo / 1000;

            totalCost += costPerCake;
            totalCostByUnits += costTotal;

            // Mostrar resultados
            resultsDiv.innerHTML += `
                <p>${input.nombre}: 
                    ${requiredAmountPerCake.toFixed(2)} gramos por pastel (Costo: ${costPerCake.toFixed(2)})
                    - Total: ${requiredAmountTotal.toFixed(2)} gramos (Costo total: ${costTotal.toFixed(2)})
                </p>`;
        });

        // Calcular total de gramos usados en aliños
        let totalGramsForAllDressings = 0; // Inicializar como número
        recipe.dressings.forEach(dressing => {
            totalGramsForAllDressings += Number(dressing.pivot.cantidad_gramos);
        });

        // Calcular el costo para cada aliño (por pastel y total)
        let totalCostForDressings = 0;
        let totalCostForDressingsByUnits = 0;

        const gramsPerDressingPerCake = totalGramsForAllDressings / numCakes;

        recipe.dressings.forEach(dressing => {
            // Cálculo por pastel
            const costPerDressing = gramsPerDressingPerCake * dressing.costo / 1000;
            totalCostForDressings += costPerDressing;

            // Cálculo por unidades totales
            const costPerDressingTotal = dressing.pivot.cantidad_gramos * dressing.costo / 1000;
            totalCostForDressingsByUnits += costPerDressingTotal;
        });

        // Mostrar aliños
        resultsDiv.innerHTML += `
            <p>Aliños: 
                ${gramsPerDressingPerCake.toFixed(2)} gramos por pastel (Costo: ${totalCostForDressings.toFixed(2)})
                - Total: ${totalGramsForAllDressings.toFixed(2)} gramos (Costo total: ${totalCostForDressingsByUnits.toFixed(2)})
            </p>`;

        // Sumar los costos totales de insumos y aliños
        totalCost += totalCostForDressings;
        totalCostByUnits += totalCostForDressingsByUnits;

        // Mostrar el costo total por pastel y el costo total general
        resultsDiv.innerHTML += `
            <p class="font-bold">Costo Total por pastel: ${totalCost.toFixed(2)}</p>
            <p class="font-bold">Costo Total general para ${numCakes} pasteles: ${totalCostByUnits.toFixed(2)}</p>`;
    } else {
        resultsDiv.innerHTML = '<p class="text-red-500">Por favor, ingrese un número válido de pasteles.</p>';
    }
}
</script>

</x-app-layout>