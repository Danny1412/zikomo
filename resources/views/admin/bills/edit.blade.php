<x-app-layout>
<div class="p-6 bg-orange-300 rounded-lg shadow-lg shadow-orange-400">
        <h2 class="mb-4 text-2xl font-bold">Editar Producto</h2>
        <form action="{{ route('nomina.update', $payroll->id) }}" method="post">
        @csrf
        @method('PUT')
        
        <label for="empleado_id" class="block text-sm font-medium text-gray-700">Empleado</label>
        <select name="empleado_id" id="empleado_id" class="mb-5" onchange="updateSalary()">
            <option disabled>Seleccione un empleado</option>
            @foreach ($employeds as $employed)
                <option value="{{ $employed->id }}" data-salary="{{ $employed->salario }}" {{ $payroll->empleado_id == $employed->id ? 'selected' : '' }}>
                    {{ $employed->nombre }} {{ $employed->apellido }}
                </option>
            @endforeach
        </select>

        <label for="monto" class="block text-sm font-medium text-gray-700">Monto de la Nómina</label>
        <input type="number" name="monto" id="monto" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese el monto de la nómina" value="{{ $payroll->monto }}" required readonly>

        <label for="fecha_pago" class="block text-sm font-medium text-gray-700">Fecha de Pago</label>
        <input type="date" name="fecha_pago" id="fecha_pago" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese la fecha de pago de la nómina" value="{{ $payroll->fecha_pago }}" required>

        <label for="periodo" class="block text-sm font-medium text-gray-700">Periodo</label>
        <input type="text" name="periodo" id="periodo" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese el periodo de la nómina" value="{{ $payroll->periodo }}" required>

        <button class="p-3 px-4 text-white bg-orange-400 rounded hover:bg-orange-500">Actualizar</button>
        <a href="{{ route('nomina.index') }}" class="p-3 px-4 ml-2 text-white bg-gray-400 rounded hover:bg-gray-500">Cancelar</a>
    </form>
</div>

<script>
    function updateSalary() {
        var empleadoSelect = document.getElementById('empleado_id');
        var montoInput = document.getElementById('monto');
        
        var selectedOption = empleadoSelect.options[empleadoSelect.selectedIndex];
        var salary = selectedOption.getAttribute('data-salary');
        
        montoInput.value = salary;
    }
</script>
    </div>
</x-app-layout>