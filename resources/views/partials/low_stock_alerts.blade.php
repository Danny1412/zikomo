<!-- resources/views/partials/low_stock_alerts.blade.php -->

@if (session('lowStockMessages'))
    <div class="text-white bg-red-600">
        @foreach (session('lowStockMessages') as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>
@endif
