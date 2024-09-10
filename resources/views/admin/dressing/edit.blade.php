<x-app-layout>
<div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Editar Producto</h2>
        <form action="{{ route('dressing.update', $dressing->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="nombre">Nombre del aliño</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="nombre" name="nombre" type="text" value="{{ $dressing->nombre }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="unidad">Unidad del aliño</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="unidad" name="unidad" type="text" value="{{ $dressing->unidad }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="cantidad">Cantidad Kilos a gramos</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="cantidad" name="cantidad" type="text" value="{{ $dressing->cantidad }}">
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="costo">Costo</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="costo" name="costo" type="text" value="{{ $dressing->costo }}" required>
            </div>
           
            <div class="flex items-center justify-between mt-5">
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="submit">
                    Actualizar
                </button>
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="button" onclick="window.location.href='{{ route('dressing.index') }}'">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>