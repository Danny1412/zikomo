<x-app-layout>
<div class="bg-orange-300 p-6 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="text-2xl font-bold mb-4">Editar Producto</h2>
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="nombre">Producto</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="nombre" name="nombre" type="text" value="{{ $product->nombre }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="descripcion">Descripción</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="descripcion" name="descripcion" type="text" value="{{ $product->descripcion }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="proveedor">Proveedor</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="proveedor" name="proveedor" type="text" value="{{ $product->proveedor }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="precio">Precio</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="precio" name="precio" type="text" value="{{ $product->precio }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="unidades">Unidades</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200 placeholder-gray-700"
                    id="unidades" name="unidades" type="text" value="{{ $product->unidades }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Seleccione El Tipo De Producto</label>
                <select name="tipo"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-orange-200"
                    required>
                    <option value="Producto Final" {{ $product->tipo == 'Producto Final' ? 'selected' : '' }}>Producto Final
                    </option>
                    <option value="Materia Prima" {{ $product->tipo == 'Materia Prima' ? 'selected' : '' }}>Materia Prima
                    </option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Seleccione La Tienda</label>
                <select name="tienda"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline  bg-orange-200"
                    required>
                    <option value="" disabled selected>Seleccione una Opción</option>
                    <option value="Tienda 1" {{ $product->tienda == 'Tienda 1' ? 'selected' : '' }}>Tienda 1</option>
                    <option value="Salon"{{ $product->tienda == 'Salon' ? 'selected' : '' }}>Salon</option>
                    <option value="Almacen"{{ $product->tienda == 'Almacen' ? 'selected' : '' }}>Almacen</option>
                    <option value="Cuarto Frio"{{ $product->tienda == 'Cuarto Frio' ? 'selected' : '' }}>Cuarto Frio
                    </option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-orange-400 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Actualizar
                </button>
                <button
                    class="bg-orange-400 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="button" onclick="window.location.href='{{ route('products.index') }}'">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>