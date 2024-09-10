<x-app-layout>
<div class="p-6 bg-orange-200 rounded-lg shadow-lg shadow-orange-300">
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <div class="flex justify-between mb-4">
                            <div class="flex-1">

                            <div class="flex">
                                    @include('admin.dressing.modalcrear')

                                    @include('admin.dressing.modalimport')
                                </div>


                                <h2 class="text-lg font-semibold text-gray-900">Lista de aliños</h2>
                                <h3>Total de porciones: {{ $totalPortion }}</h3>
                                <h3>Total de medida en gramos de las porciones: {{ number_format($totalGramsForPortion, 2) }} gr</h3>
                                <div class="mt-2">
                                    <a href="{{  route('settings.edit') }}"
                                    class="px-4 py-2 my-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500">Editar Total de porciones</a>
                                </div>
                                
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
                                        Nombre aliño
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Unidad (gr)
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Kilos en gramos (Kg a gr)
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Costo (COP)
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Cantidad en gramos (gr)
                                    </th>
                                   
                                    <th scope="col"
                                        class="px-6 py-4 text-sm font-medium text-left text-gray-900 border-gray-400 border-x">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="border border-gray-400 " id="table-body">
                            @foreach ($dressings as $dressing)

                                    <tr class="bg-orange-300 border-b border-gray-400">

                                            <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                                {{ $dressing->id }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                                {{ $dressing->nombre }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                                {{ $dressing->unidad }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-black border-gray-400 whitespace-nowrap border-x">
                                                {{ $dressing->cantidad }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-gray-400 whitespace-nowrap border-x">
                                                {{ number_format($dressing->costo, 2) }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-gray-400 whitespace-nowrap border-x">
                                                {{ number_format($dressing->cantidad_gramos, 2) }}
                                            </td>
                                            
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-gray-400 whitespace-nowrap border-x">
                                                <form action="{{ route('dressing.destroy', $dressing->id) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit"
                                                    class="px-4 py-2 mb-4 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta orden?')">Eliminar</button>
                                                </form>
                                                <a href="{{ route('dressing.edit', $dressing) }}"
                                                class="px-4 py-2 mt-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Editar</a>
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
            <a href="{{ route('admin.index') }}" class="text-white">Volver</a>
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