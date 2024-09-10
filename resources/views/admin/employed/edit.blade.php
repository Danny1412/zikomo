<x-app-layout>
<div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Editar Producto</h2>
        <form action="{{ route('empleados.update', $employed->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="nombre">Empleado </label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="nombre" name="nombre" type="text" value="{{ $employed->nombre }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="apellido">Descripción</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="apellido" name="apellido" type="text" value="{{ $employed->apellido }}">
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="cedula">cedula</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="cedula" name="cedula" type="text" value="{{ $employed->cedula }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="cargo">cargo</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="cargo" name="cargo" type="text" value="{{ $employed->cargo }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="salario">salario</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="salario" name="salario" type="text" value="{{ $employed->salario }}" required>
            
            <div class="flex items-center justify-between mt-5">
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="submit">
                    Actualizar
                </button>
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="button" onclick="window.location.href='{{ route('empleados.index') }}'">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>