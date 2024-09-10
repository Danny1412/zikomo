<x-app-layout>
<div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Editar Producto</h2>
        <form action="{{ route('input.update', $input->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="nombre"> Nombre del insumo </label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="nombre" name="nombre" type="text" value="{{ $input->nombre }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="unidad">Unidad del insumo (Kg - L - gr)</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="unidad" name="unidad" type="text" value="{{ $input->unidad }}">
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="medida">Medidas del insumo (gr - ml) </label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="medida" name="medida" type="number" value="{{ $input->medida }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="costo">Costo del insumo</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="costo" name="costo" type="number" value="{{ $input->costo }}" required>
            </div>
            <div class="flex items-center justify-between mt-5">
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="submit">
                    Actualizar
                </button>
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="button" onclick="window.location.href='{{ route('input.index') }}'">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>