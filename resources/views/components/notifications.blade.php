<!-- resources/views/components/notifications.blade.php -->
<div id="notifications" class="fixed bottom-0 right-0 p-4 w-96">
    <!-- Las notificaciones se agregarán aquí -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.Echo.channel('low-stock')
            .listen('LowStockNotification', (e) => {
                let notificationElement = document.createElement('div');
                notificationElement.classList.add('bg-red-500', 'text-white', 'p-4', 'rounded', 'mb-2');
                notificationElement.innerText = `El producto ${e.product.nombre} tiene stock bajo (${e.product.unidades} unidades restantes).`;

                document.getElementById('notifications').appendChild(notificationElement);
            });
    });
</script>
