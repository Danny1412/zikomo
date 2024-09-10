<x-app-layout>
    <div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Editar Prociones</h2>
        <form action="{{ route('settings.update') }}" method="POST">
            @method('PUT')
            @csrf
            
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="total_porciones">Cantidad de porciones</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="total_porciones" name="total_porciones" type="text" placeholder="Ingrese el valor de la cantidad" required value="{{ $totalPortion }}">
            </div>

            <div class="flex items-center justify-between">
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

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </form>
    </div>
</x-app-layout>