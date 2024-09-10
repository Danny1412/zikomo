    <!-- Boton del Modal para crear -->
    <div class="mt-10 mb-5 ml-5">
            <button class="px-4 py-2 font-bold text-gray-500 bg-transparent border border-gray-500 rounded-full modal-open hover:border-indigo-500 hover:text-indigo-500">Agregar Insumo</button>
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
                    <p class="text-2xl font-bold">Agrega un nuevo insumo</p>
                    <div class="z-50 cursor-pointer modal-close">
                        <svg class="text-black fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <!--Cuerpo-->
                <form action="{{ route('input.store') }}" method="post">
                    @csrf
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del insumo</label>
                    <input type="text" name="nombre" id="nombre" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese el nombre del insumo" value="{{ old('nombre') }}" require>
                    
                    <label for="unidad" class="block text-sm font-medium text-gray-700">Unidad del insumo (Kg - L - gr) </label>
                    <input type="text" name="unidad" id="unidad" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese la unidad del insumo" value="{{ old('unidad') }}" require>
                    
                    <label for="medida" class="block text-sm font-medium text-gray-700">Medidas del insumo (gr - ml) </label>
                    <input type="number" name="medida" id="medida" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese la medida del insumo" value="{{ old('medida') }}" require>
                    
                    <label for="costo" class="block text-sm font-medium text-gray-700">Costo del insumo</label>
                    <input type="number" name="costo" id="costo" class="block w-full mt-1 mb-5 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese el costo del insumo" value="{{ old('costo') }}" require>
        
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
