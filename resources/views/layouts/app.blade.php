<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        @notifyCss

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>        
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>

        <style>
           #alert-container {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    text-align: center;
}

.alert {
    display: inline-block;
    margin: 10px auto;
    padding: 15px;
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: #f2dede;
    color: #a94442;
    border-color: #ebccd1;
    transition: opacity 0.5s ease;
    opacity: 1;
}

.alert.hidden {
    opacity: 0;
}

        </style>

    </head>
    <body class="font-sans antialiased">
        <!-- @if (session('success'))
        <div class="p-2 text-lg text-center text-green-100 bg-green-600 fon-bold">{{session('success')}}</div>
        @endif
        @if (session('error'))
        <div class="p-2 text-lg text-center text-green-100 bg-red-600 fon-bold">{{session('error')}}</div>
        @endif -->

    <!-- El contenido de la aplicación -->
        <div class="flex">
            @include('layouts.navigation')
            @component('components.notifications')@endcomponent

            <!-- Page Content -->
            <div class="flex-1 min-h-screen ml-64 bg-orange-100 dark:bg-gray-900">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-orange-200 shadow dark:bg-gray-800">
                        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main>
                    {{ $slot }}
                </main>
            </div>
            
        </div>
        
        <x-notify::notify />

        @notifyJs

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function fetchLowStockProducts() {
                    fetch('/low-stock-products')
                        .then(response => response.json())
                        .then(data => {
                            showAlerts(data);
                        })
                        .catch(error => console.error('Error:', error));
                }

                function showAlerts(products) {
                    let alertContainer = document.getElementById('alert-container');
                    alertContainer.innerHTML = '';

                    products.forEach(product => {
                        let alert = document.createElement('div');
                        alert.className = 'alert';
                        alert.textContent = `El producto ${product.nombre} tiene pocas unidades (${product.unidades}).`;
                        alertContainer.appendChild(alert);

                        // Mostrar la alerta
                        setTimeout(() => {
                            alert.classList.add('hidden');
                        }, 5000); // Ocultar la alerta después de 5 segundos
                    });
                }

                // Fetch low stock products every 30 seconds
                setInterval(() => {
                    fetchLowStockProducts();

                    // Mostrar alertas nuevamente
                    let alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        alert.classList.remove('hidden');
                    });
                }, 30000);

                // Fetch immediately on page load
                fetchLowStockProducts();
            });
        </script>

        <div id="alert-container"></div>

    </body>
    
</html>
