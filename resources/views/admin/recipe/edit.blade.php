<x-app-layout>
    <div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Actualizar Receta</h2>

        <form action="{{ route('recipe.update', $recipe->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Para hacer la actualización correctamente -->

            <label class="block font-bold text-gray-700" for="nombre">Nombre de la Receta</label>
            <input value="{{ $recipe->nombre }}" class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="nombre" id="nombre" required placeholder="Agregue el nombre de la receta">

            <h4 class="mt-5 text-xl font-black">Insumos</h4>
            @foreach($inputs as $input)
                <div class="mt-3">
                    <label class="block font-bold text-gray-700">{{ $input->nombre }} ({{ $input->unidad }})</label>
                    <input value="{{ $recipe->inputs->find($input->id)->pivot->cantidad_usada ?? 0 }}" class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="number" name="inputs[{{ $input->id }}]" placeholder="Cantidad en gramos">
                </div>
            @endforeach

            <h4 class="mt-5 text-xl font-black">Aliños</h4>
            <div class="mt-3">
                <label class="block font-bold text-gray-700">Total gramos de aliños por porción</label>
                <input value="{{ $recipe->dressings->sum('pivot.cantidad_gramos') ?? 0 }}" class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="number" step="any" name="total_grams_for_portion" placeholder="Cantidad total en gramos">
            </div>

            <div class="flex items-center justify-between mt-5">
                <button class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline" type="submit">
                    Actualizar
                </button>
                <button class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline" type="button" onclick="window.location.href='{{ route('recipe.index') }}'">
                    Cancelar
                </button>
            </div>

            <ul class="mt-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </form>
    </div>
</x-app-layout>
