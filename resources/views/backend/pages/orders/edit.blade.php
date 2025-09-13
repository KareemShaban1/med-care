@extends('backend.layouts.app')

@section('content')
<div class="container card mt-3 mx-3">
    <h2>{{ __('Edit Order') }} #{{ $order->id }}</h2>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Customer Info --}}
        <div class="mb-3">
            <label class="form-label">{{ __('Customer Name') }}</label>
            <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Customer Phone') }}</label>
            <input type="text" class="form-control" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Delivery Address') }}</label>
            <input type="text" class="form-control" name="delivery_address" value="{{ old('delivery_address', $order->delivery_address) }}">
        </div>

        <hr>

        {{-- Order Products --}}
        <h4>{{ __('Products in this Order') }}</h4>
        <table class="table table-bordered align-middle" id="order-items-table">
            <thead>
                <tr>
                    <th>{{ __('Product') }}</th>
                    <th width="120">{{ __('Price') }}</th>
                    <th width="120">{{ __('Quantity') }}</th>
                    <th width="120">{{ __('Subtotal') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr data-item-id="{{ $item->id }}">
                    <input type="hidden" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">
                    <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                    <td>
                        <input type="number" step="0.01" name="items[{{ $item->id }}][price]" 
                               class="form-control price-input"
                               value="{{ old("items.$item->id.price", $item->unit_price) }}">
                    </td>
                    <td>
                        <input type="number" name="items[{{ $item->id }}][quantity]" 
                               class="form-control quantity-input"
                               value="{{ old("items.$item->id.quantity", $item->quantity) }}" min="1">
                    </td>
                    <td class="subtotal">
                        {{ number_format($item->unit_price * $item->quantity, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Order Total --}}
        <div class="mb-3">
            <label class="form-label">{{ __('Order Total') }}</label>
            <input type="number" step="0.01" class="form-control" id="order-total" name="total" 
                   value="{{ old('total', $order->total) }}" required readonly>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update Order') }}</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("order-items-table");
    const totalInput = document.getElementById("order-total");

    function recalcTotals() {
        let total = 0;

        table.querySelectorAll("tbody tr").forEach(row => {
            const price = parseFloat(row.querySelector(".price-input").value) || 0;
            const qty = parseInt(row.querySelector(".quantity-input").value) || 0;
            const subtotal = price * qty;

            row.querySelector(".subtotal").innerText = subtotal.toFixed(2);
            total += subtotal;
        });

        totalInput.value = total.toFixed(2);
    }

    // Listen for changes
    table.addEventListener("input", function (e) {
        if (e.target.classList.contains("price-input") || e.target.classList.contains("quantity-input")) {
            recalcTotals();
        }
    });
});
</script>
@endpush
