    <!-- Boton del Modal para crear -->
        <div class="mt-10 mb-5 ml-5">
            <button class="px-4 py-2 font-bold text-gray-500 bg-transparent border border-gray-500 rounded-full modal-open hover:border-indigo-500 hover:text-indigo-500">Agregar pago nomina</button>
        </div>

    <!--Modal para crear-->
    <div class="fixed top-0 left-0 z-10 flex items-center justify-center w-full h-full opacity-0 pointer-events-none modal">
        <div class="absolute w-full h-full bg-gray-900 opacity-50 modal-overlay"></div>

        <div class="z-50 w-11/12 mx-auto overflow-y-auto bg-white rounded shadow-lg modal-container md:max-w-md">

            <div class="absolute top-0 right-0 z-50 flex flex-col items-center mt-4 mr-4 text-sm text-white cursor-pointer modal-close">
                <svg class="text-white fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
                <span class="text-sm">(Esc)</span>
            </div>

            <div class="px-6 py-4 text-left modal-content">
                <!--Titulo-->
                <div class="flex items-center justify-between pb-3">
                    <p class="text-2xl font-bold">Agrega un pago de nomina</p>
                    <div class="z-50 cursor-pointer modal-close">
                        <svg class="text-black fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <!--Cuerpo-->
                <form action="{{ route('nomina.store') }}" method="post">
                    @csrf
                    <label for="empleado_id" class="block text-sm font-medium text-gray-700">Empleado a seleccionar para la nomina</label>
                    <select name="empleado_id" id="empleado_id" class="select2" onchange="updateSalary()">
                        <option disabled selected>Seleccione un empleado</option>
                        @foreach ($employeds as $employed)
                            <option value="{{ $employed->id }}" data-salary="{{ $employed->salario }}">{{ $employed->nombre }} {{ $employed->apellido }}</option>
                        @endforeach
                    </select>
                    
                    <label for="monto" class="block mt-5 text-sm font-medium text-gray-700">Monto de la nomina</label>
                    <input type="number" name="monto" id="monto" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese el monto de la nomina" value="{{ old('monto') }}" require readonly>
                    
                    <label for="fecha_pago" class="block text-sm font-medium text-gray-700">Fecha pago de la nomina</label>
                    <input type="date" name="fecha_pago" id="fecha_pago" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese el fecha de pago de la nomina" value="{{ old('fecha_pago') }}" require>
                    
                    <label for="periodo" class="block text-sm font-medium text-gray-700">Periodo de la nomina</label>
                    <input type="text" name="periodo" id="periodo" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese el periodo de la nomina" value="{{ old('periodo') }}" require>
                    
                    <!--Pie de modal-->
                        <button class="p-3 px-4 ml-6 text-white bg-orange-400 rounded hover:bg-orange-500">Agregar</button>

                        <a class="p-3 px-4 mt-4 text-white bg-orange-400 rounded modal-close hover:bg-orange-500">Cerrar</a>

                </form>

              

                <x-input-error :messages="$errors->all()"></x-input-error>

            </div>
        </div>
    </div>

    <!-- Script del modal para crear -->
    <script>
        var openmodal = document.querySelectorAll('.modal-open')
        for (var i = 0; i < openmodal.length; i++) {
            openmodal[i].addEventListener('click', function(event) {
                event.preventDefault()
                toggleModal()
            })
        }

        const overlay = document.querySelector('.modal-overlay')
        overlay.addEventListener('click', toggleModal)

        var closemodal = document.querySelectorAll('.modal-close')
        for (var i = 0; i < closemodal.length; i++) {
            closemodal[i].addEventListener('click', toggleModal)
        }

        document.onkeydown = function(evt) {
            evt = evt || window.event
            var isEscape = false
            if ("key" in evt) {
                isEscape = (evt.key === "Escape" || evt.key === "Esc")
            } else {
                isEscape = (evt.keyCode === 27)
            }
            if (isEscape && document.body.classList.contains('modal-active')) {
                toggleModal()
            }
        };


        function toggleModal() {
            const body = document.querySelector('body')
            const modal = document.querySelector('.modal')
            modal.classList.toggle('opacity-0')
            modal.classList.toggle('pointer-events-none')
            body.classList.toggle('modal-active')
        }
    </script>

      <!-- Script para actualizar el campo de monto automáticamente -->
<script>
    function updateSalary() {
        // Obtener el elemento select y el campo de monto
        var empleadoSelect = document.getElementById('empleado_id');
        var montoInput = document.getElementById('monto');
        
        // Obtener la opción seleccionada y su atributo data-salary
        var selectedOption = empleadoSelect.options[empleadoSelect.selectedIndex];
        var salary = selectedOption.getAttribute('data-salary');
        
        // Actualizar el valor del campo de monto con el salario
        montoInput.value = salary;
    }
</script>
