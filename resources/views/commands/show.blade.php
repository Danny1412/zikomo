<x-app-layout>
    <div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Comanda para {{ $command->table->nombre }}</h2>

        <h4 class="text-xl font-black">Productos en la Comanda</h4>
        <ul>
            @foreach ($command->products as $product)
                <li>{{ $product->nombre }} - Cantidad: {{ $product->pivot->quantity }}</li>
            @endforeach
        </ul>

        <form action="{{ route('commands.addItem', $command) }}" method="POST">
            @csrf
            <label class="block font-bold text-gray-700" for="product_id">Producto</label>
            <select name="product_id" class="w-full px-3 py-2 leading-tight text-gray-700 bg-orange-200 border rounded">
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->nombre }}</option>
                @endforeach
            </select>

            <label class="block mt-2 font-bold text-gray-700" for="quantity">Cantidad</label>
            <input type="number" name="quantity" class="w-full px-3 py-2 leading-tight text-gray-700 bg-orange-200 border rounded">

            <button type="submit" class="px-4 py-2 mt-3 font-bold text-white bg-orange-500 rounded">Agregar a la Comanda</button>
        </form>
        <button type="submit" class="px-4 py-2 mt-3 font-bold text-white bg-orange-500 rounded"><a href="{{ route('planoMesas') }}">Volver</a></button>
    </div>
</x-app-layout>
