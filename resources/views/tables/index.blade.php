<x-app-layout>
<div class="p-6 bg-orange-200 rounded-lg shadow-lg shadow-orange-300">
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <div class="flex justify-between mb-4">
                            <div class="flex-1">
                                <h2 class="text-lg font-semibold text-gray-900">Lista de Mesas</h2>
                            </div>
                            
                            <div class="relative">
                                <input type="text" id="search" placeholder="Buscar..."
                                    class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 ">
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
                                        Nombre de la mesa
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Lugar de la mesa
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Estado
                                    </th>
                                    
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="border border-gray-400 " id="table-body">
                                @foreach ($tables as $table)
                                    <tr class="bg-orange-300 border-b border-gray-400">
                                        <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                            {{ $table->id }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                            {{ $table->nombre }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                            {{ $table->zona }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                            {{ $table->estado == 0 ? 'Disponible' : 'Ocupado' }}
                                        </td>

                                        <td
                                            class="px-6 py-4 text-sm font-medium text-gray-900 border-gray-400 whitespace-nowrap border-x">
                                            <a href="{{ route('tables.edit', $table->id) }}"
                                                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Editar</a>
                                            <form action="{{ route('tables.destroy', $table->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta table?')">Eliminar</button>
                                            </form>
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
            <a href="{{ route('tables.create') }}" class="text-white">Añadir Mesas</a>
        </button>
        
        <button class="px-4 py-2 my-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500">
            <a href="{{ route('planoMesas') }}" class="text-white">Mapa de mesas</a>
        </button>

        <button class="px-4 py-2 my-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500">
            <a href="{{ route('command.index') }}" class="text-white">Ver Comandas</a>
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