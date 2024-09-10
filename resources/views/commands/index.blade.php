<x-app-layout>
<div class="p-6 bg-orange-200 rounded-lg shadow-lg shadow-orange-300">
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <div class="flex justify-between mb-4">
                            <div class="flex-1">
                                <h2 class="text-lg font-semibold text-gray-900">Lista de comandas</h2>
                            </div>
                           
                            <div class="relative">
                                <input type="text" id="search" placeholder="Buscar..."
                                    class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                                <span class="absolute transform -translate-y-1/2 right-3 top-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 15l-5-5m0 0l-5 5m5-5V3"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <table class="min-w-full">
                            <thead class="bg-white border-b">
                                <tr class="border border-gray-400">
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Mesa
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Estado de la comanda

                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Pedido
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Cantidad de pedido
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Facturar
                                    </th>
                                   
                                </tr>
                            </thead>
                            <tbody class="border border-gray-400 " id="table-body">
                                @foreach ($commands as $command)
                                    <tr class="bg-orange-300 border-b border-gray-400">
                                        <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                            {{ $command->id }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                            {{ $command->table->nombre }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                            {{ $command->is_active ? 'Pendiente' : 'Pagada' }}
                                        </td>
                                       
                                        <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                            @foreach ($command->products as $product)
                                                {{ $product->nombre }}<br>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                            @foreach ($command->products as $product)
                                                {{ $product->pivot->quantity }}<br>
                                            @endforeach
                                        </td>
                                        
                                        
                                        <td
                                            class="px-6 py-4 text-sm font-medium text-gray-900 border-gray-400 whitespace-nowrap border-x">
                                            

                                        
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <button class="px-4 py-2 my-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500">
            <a href="{{ route('tables.index') }}" class="text-white">Volver</a>
        </button>
    </div>

    

    <script>
        const searchInput = document.getElementById('search');
        const tableBody = document.getElementById('table-body');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = tableBody.getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                const tdText = row.innerText.toLowerCase();
                if (tdText.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>