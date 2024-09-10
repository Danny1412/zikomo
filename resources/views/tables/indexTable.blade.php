<x-app-layout>
    <div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-500">
        <h2 class="mb-4 text-2xl font-bold">Mesas</h2>

        @php
            $zonas = $tables->groupBy('zona'); // Agrupar las mesas por zona
        @endphp

        @foreach ($zonas as $zona => $mesas)
            <div class="zona">
                <h3 class="mt-4 mb-2 text-xl font-semibold">{{ ucfirst($zona) }}</h3> <!-- Título de la zona -->

                <div id="mesas-grid" class="grid grid-cols-4 gap-4">
                    @foreach ($mesas as $table)
                        <div class="mesa {{ $table->estado ? 'bg-red-500' : 'bg-green-500' }} rounded-lg p-4 text-center" data-id="{{ $table->id }}" style="cursor:pointer;">
                            <h3 class="font-bold text-white">{{ $table->nombre }}</h3>
                            <p class="text-white">{{ $table->estado ? 'Ocupada' : 'Libre' }}</p>
                        </div>
                        @if($table->estado)
                            <!-- Si la mesa está ocupada, muestra el botón para interactuar con la comanda -->
                            <button><a href="{{ route('commands.show', $table->activeCommand?->id) }}" class="block p-1 mt-2 text-sm font-bold text-white bg-orange-500 rounded">Ver Comanda</a></button>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach

        <button class="px-4 py-2 my-2 font-bold text-white bg-orange-400 rounded hover:bg-orange-500">
            <a href="{{ route('tables.index') }}" class="text-white">Volver</a>
        </button>
    </div>

    <script>
        $(document).ready(function() {
            // Hacer clic en una mesa para cambiar su estado
            $('.mesa').on('click', function() {
                var mesaId = $(this).data('id');
                var mesaDiv = $(this);

                $.ajax({
                    url: '/mesas/' + mesaId,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Cambia el color y el texto según el nuevo estado de la mesa
                            if (response.estado) {
                                mesaDiv.removeClass('bg-green-500').addClass('bg-red-500');
                                mesaDiv.find('p').text('Ocupada');
                                location.reload(); // Recargar para ver el botón de "Ver Comanda"
                            } else {
                                mesaDiv.removeClass('bg-red-500').addClass('bg-green-500');
                                mesaDiv.find('p').text('Libre');
                                location.reload();
                            }
                        }
                    }
                });
            });
        });
    </script>
</x-app-layout>
