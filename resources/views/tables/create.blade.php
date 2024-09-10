<x-app-layout>
    <div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Agregar Mesas</h2>
        <form action="{{ route('tables.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="nombre">Nombre de la mesa</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="nombre" name="nombre" type="text" placeholder="Ingrese el nombre de la mesa" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="nombre">Lugar de la mesa</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="zona" name="zona" type="text" placeholder="Ingrese la zona de la mesa" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="estado">Estado</label>
                <select name="estado"
                    class="w-full px-3 py-2 leading-tight text-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    required>
                    <option disabled selected>Seleccione una Opción</option>
                    <option value="{{ 0 }}">Disponible</option> 
                </select>
            </div>
            
            <div class="flex items-center justify-between">
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="submit">
                    Crear
                </button>
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="button" onclick="window.location.href='{{ route('tables.index') }}'">
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