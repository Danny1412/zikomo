<x-app-layout>
<div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Editar Orden</h2>
        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="cliente">Cliente</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="cliente" name="cliente" type="text" value="{{ $order->cliente }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="cedula">Cédula del Cliente</label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    id="cedula" name="cedula" type="text" value="{{ $order->cedula }}" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="tipo">Tipo de Orden</label>
                <select id="tipo" name="tipo"
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    required>
                    <option value="">Seleccione el tipo de orden</option>
                    <option value="Para llevar" {{ $order->tipo == 'Para llevar' ? 'selected' : '' }}>Para llevar</option>
                    <option value="Para comer aquí" {{ $order->tipo == 'Para comer aquí' ? 'selected' : '' }}>Para comer
                        aquí</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-bold text-gray-700" for="estatus">Estado de Orden</label>
                <select id="estatus" name="estatus"
                    class="w-full px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    required>
                    <option value="">Seleccione el estado de orden</option>
                    <option value="1" {{ $order->estatus == 'Pagado' ? 'selected' : '' }}>Pagada</option>
                    <option value="2" {{ $order->estatus == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                </select>
            </div>
            <div class="flex mb-4">
                <div class="w-1/2 pr-2">
                    <label class="block mb-2 font-bold text-gray-700">Productos</label>
                    <div class="flex mb-2 producto-item">
                        <select id="producto-select"
                            class="w-full px-3 py-2 mr-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                            <option value="">Seleccione un producto</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-stock="{{ $product->unidades }}">
                                    {{ $product->nombre }} - Stock: {{ $product->unidades }}
                                </option>
                            @endforeach
                        </select>
                        <input id="producto-cantidad"
                            class="w-1/4 px-3 py-2 leading-tight text-gray-700 placeholder-gray-700 bg-orange-200 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            type="number" placeholder="Cantidad" min="1">
                    </div>
                    <button type="button" id="add-producto"
                        class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline">Añadir
                        Producto</button>
                </div>
                <div class="w-1/2 pl-2">
                    <label class="block mb-2 font-bold text-gray-700">Productos Seleccionados</label>
                    <div id="productos-seleccionados"
                        class="w-full px-3 py-2 leading-tight text-gray-700 bg-orange-200 border rounded shadow appearance-none">
                        <!-- Productos seleccionados se mostrarán aquí -->
                        @foreach ($order->products as $index => $product)
                            <div class="flex mb-2 producto-seleccionado">
                                <span class="w-full px-3 py-2 text-gray-700">{{ $product->nombre }}</span>
                                <span class="w-1/4 px-3 py-2 text-gray-700">{{ $product->pivot->quantity }}</span>
                                <input type="hidden" name="productos[{{ $index }}][producto_id]"
                                    value="{{ $product->id }}">
                                <input type="hidden" name="productos[{{ $index }}][cantidad]"
                                    value="{{ $product->pivot->quantity }}">
                                <button type="button"
                                    class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="this.parentElement.remove()">Quitar</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="submit">
                    Actualizar Orden
                </button>
                <button
                    class="px-4 py-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                    type="button" onclick="window.location.href='{{ route('orders.index') }}'">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('add-producto').addEventListener('click', function() {
            const select = document.getElementById('producto-select');
            const cantidadInput = document.getElementById('producto-cantidad');
            const selectedContainer = document.getElementById('productos-seleccionados');

            const productoId = select.value;
            const productoTexto = select.options[select.selectedIndex].text;
            const cantidad = cantidadInput.value;

            if (productoId && cantidad > 0) {
                const selectedItem = document.createElement('div');
                selectedItem.className = 'producto-seleccionado flex mb-2';
                selectedItem.innerHTML = `
                    <span class="w-full px-3 py-2 text-gray-700">${productoTexto}</span>
                    <span class="w-1/4 px-3 py-2 text-gray-700">${cantidad}</span>
                    <input type="hidden" name="productos[${selectedContainer.children.length}][producto_id]" value="${productoId}">
                    <input type="hidden" name="productos[${selectedContainer.children.length}][cantidad]" value="${cantidad}">
                    <button type="button" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700" onclick="this.parentElement.remove()">Quitar</button>
                `;
                selectedContainer.appendChild(selectedItem);

                // Reset the select and input fields
                select.value = '';
                cantidadInput.value = '';
            }
        });
    </script>
</x-app-layout>