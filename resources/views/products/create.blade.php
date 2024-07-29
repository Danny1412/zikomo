<x-app-layout>
    <div class="bg-orange-300 p-6 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="text-2xl font-bold mb-4">Crear Productos</h2>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="nombre">Producto</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="nombre" name="nombre" type="text" placeholder="Ingrese el Nombre del Producto" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="descripcion">Descripción</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="descripcion" name="descripcion" type="text" placeholder="Ingrese la Descripción del Producto">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="proveedor">Proveedor</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="proveedor" name="proveedor" type="text" placeholder="Ingrese el Proveedor del Producto" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="precio">Precio</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="precio" name="precio" type="text" placeholder="Ingrese el Precio del Producto" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="unidades">Unidades</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="unidades" name="unidades" type="text" placeholder="Ingrese las Unidades del Producto" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Seleccione El Tipo De Producto</label>
                <select name="tipo"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline  bg-orange-200"
                    required>
                    <option value="" disabled selected>Seleccione una Opción</option>
                    <option value="Producto Final">Producto Final</option>
                    <option value="Materia Prima">Materia Prima</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Seleccione La Tienda</label>
                <select name="tienda"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline  bg-orange-200"
                    required>
                    <option value="" disabled selected>Seleccione una Opción</option>
                    <option value="Producto Final">Tienda 1</option>
                    <option value="Salon">Salon</option>
                    <option value="Almacen">Almacen</option>
                    <option value="Cuarto Frio">Cuarto Frio</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-orange-400 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Crear
                </button>
                <button
                    class="bg-orange-400 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="button" onclick="window.location.href='{{ route('products.index') }}'">
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