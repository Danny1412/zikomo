<x-app-layout>
    <div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Crear Receta</h2>

        <form action="{{ route('recipe.store') }}" method="POST">
            @csrf
            <label class="block font-bold text-gray-700" for="nombre">Nombre de la Receta</label>
            <input class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="nombre" id="nombre" required placeholder="Agregue el nombre de la receta">

            <h4 class="mt-5 text-xl font-black">Insumos</h4>
            <select id="insumos-select" class="w-full px-3 py-2 bg-orange-200 border rounded" name="inputs_id[]" multiple>
                @foreach($inputs as $input)
                    <option value="{{ $input->id }}">{{ $input->nombre }} ({{ $input->unidad }})</option>
                @endforeach
            </select>

            <div id="insumos-quantities" class="mt-5"></div>

            <h4 class="mt-5 text-xl font-black">Aliños</h4>
            <div class="mt-3">
                <label class="block font-bold text-gray-700">Total gramos de aliños por porción</label>
                <input class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="number" step="any" name="total_grams_for_portion" placeholder="Cantidad total de gramos en aliños">
            </div>

            <div class="flex items-center justify-between mt-5">
                <button class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline" type="submit">
                    Crear Receta
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

    <script>
        $(document).ready(function() {
            $('#insumos-select').select2();

            $('#insumos-select').on('change', function() {
                $('#insumos-quantities').empty();
                var selectedOptions = $(this).val();
                selectedOptions.forEach(function(inputId) {
                    var inputName = $('#insumos-select option[value="' + inputId + '"]').text();
                    $('#insumos-quantities').append(`
                        <div class="mt-3">
                            <label class="block font-bold text-gray-700">${inputName} (Cantidad en gramos)</label>
                            <input class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="number" name="inputs[${inputId}]" placeholder="Cantidad en gramos">
                        </div>
                    `);
                });
            });
        });
    </script>
</x-app-layout>
