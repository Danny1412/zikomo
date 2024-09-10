<x-app-layout>

    <div class="grid grid-cols-4 gap-4 mt-10 ml-10">
        <div>
            <a href="{{ route('ingresos.index') }}">
                <img src="{{ asset('img/organico.png') }}" alt="Ingresos" class="h-48">
                <p class="ml-16 text-xl font-black dark:text-white">Ingresos</p>
            </a>
        </div>

        <div>
            <a href="{{ route('empleados.index') }}">
                <img src="{{ asset('img/empleado.png') }}" alt="Empleados" class="h-48">
                <p class="ml-16 text-xl font-black dark:text-white">Empleados</p>
            </a>
        </div>

        <div>
            <a href="{{ route('nomina.index') }}">
                <img src="{{ asset('img/nomina-de-sueldos.png') }}" alt="Nomina" class="h-48">
                <p class="ml-16 text-xl font-black dark:text-white">Nomina</p>
            </a>
        </div>

        <div>
            <a href="{{ route('dressing.index') }}">
                <img src="{{ asset('img/aderezo.png') }}" alt="Aliños" class="w-48 h-48">
                <p class="ml-16 text-xl font-black dark:text-white">Aliños</p>
            </a>
        </div>

        <div>
            <a href="{{ route('input.index') }}">
                <img src="{{ asset('img/materias.png') }}" alt="Insumos" class="h-48">
                <p class="ml-16 text-xl font-black dark:text-white">Insumos</p>
            </a>
        </div>

        <div>
            <a href="{{ route('recipe.index') }}">
                <img src="{{ asset('img/recetario.png') }}" alt="Recetas" class="h-48">
                <p class="ml-16 text-xl font-black dark:text-white">Recetas</p>
        </div>
        
        <div>
            <a href="{{ route('tables.index') }}">
                <img src="{{ asset('img/mesa.png') }}" alt="Mesas" class="h-48">
                <p class="ml-16 text-xl font-black dark:text-white">Mesas</p>
        </div>
    </div>

</x-app-layout>