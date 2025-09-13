@extends('frontend.layouts.app')
@section('content')
<div class="container mx-auto py-8">

  <h3 class="text-2xl font-bold mb-6">🛒 {{ __('Your Cart') }}</h3>

  @if(count($cart))
  <div class="overflow-x-auto rounded-lg shadow">
    <!-- Desktop Table -->
    <table class="hidden md:table min-w-full divide-y divide-gray-200 bg-white" id="cartTable">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">{{ __('Product') }}</th>
          <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('Price') }}</th>
          <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('Quantity') }}</th>
          <th class="px-4 py-3 text-sm font-semibold text-gray-600">{{ __('Subtotal') }}</th>
          <th></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @foreach($cart as $id => $item)
        <tr data-id="{{ $id }}" class="hover:bg-gray-50 transition">
          <td class="px-4 py-3 flex items-center gap-3">
            <img src="{{ $item['image'] ?? '/images/no-image.png' }}" alt="{{ $item['name'] }}"
              class="w-16 h-16 object-cover rounded-md shadow">
            <div>
              <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>
              <p class="text-xs text-gray-500">{{ __('ID') }}: {{ $item['id'] }}</p>
            </div>
          </td>
          <td class="px-4 py-3 price">{{ __('EGP') }} {{ number_format($item['price'],2) }}</td>
          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              <button type="button" class="decrease bg-gray-200 px-2 py-1 rounded">−</button>
              <span class="qty font-medium">{{ $item['quantity'] }}</span>
              <button type="button" class="increase bg-gray-200 px-2 py-1 rounded">+</button>
            </div>
          </td>
          <td class="px-4 py-3 subtotal font-medium text-gray-700">
            {{ number_format($item['price']*$item['quantity'],2) }}
          </td>
          <td class="px-4 py-3">
            <button type="button"
              class="remove-item bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition"
              data-id="{{ $id }}">
              ✕
            </button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-4" id="cartMobile">
      @foreach($cart as $id => $item)
      <div data-id="{{ $id }}" class="flex flex-col bg-white rounded-lg shadow p-4">
        <div class="flex items-center gap-3">
          <img src="{{ $item['image'] ?? '/images/no-image.png' }}" alt="{{ $item['name'] }}"
            class="w-20 h-20 object-cover rounded-md shadow">
          <div>
            <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>
            <p class="text-xs text-gray-500">{{ __('ID') }}: {{ $item['id'] }}</p>
          </div>
        </div>
        <div class="mt-3 flex justify-between text-sm text-gray-600">
          <span>{{ __('Price') }}:</span>
          <span class="price">{{ __('EGP') }} {{ number_format($item['price'],2) }}</span>
        </div>
        <div class="mt-2 flex justify-between items-center">
          <div class="flex items-center gap-2">
            <button type="button" class="decrease bg-gray-200 px-2 py-1 rounded">−</button>
            <span class="qty font-medium">{{ $item['quantity'] }}</span>
            <button type="button" class="increase bg-gray-200 px-2 py-1 rounded">+</button>
          </div>
          <span class="subtotal font-medium text-gray-700">
            {{ number_format($item['price']*$item['quantity'],2) }}
          </span>
        </div>
        <button type="button"
          class="remove-item mt-3 bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition self-end"
          data-id="{{ $id }}">
          ✕ {{ __('Remove') }}
        </button>
      </div>
      @endforeach
    </div>
  </div>

  <!-- Totals + Checkout -->
  <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-4">
    <a href="{{ route('home') }}"
      class="text-blue-600 hover:underline order-2 md:order-1 text-center md:text-left">
      ← {{ __('Continue shopping') }}
    </a>

    <div class="flex flex-col sm:flex-row items-center gap-3 order-1 md:order-2 w-full md:w-auto justify-center md:justify-end">
      <strong class="text-lg text-center sm:text-left">
        {{ __('Total') }}:
        <span class="text-green-600">
          {{ __('EGP') }} <span id="cartTotal">{{ number_format($total,2) }}</span>
        </span>
      </strong>

      <a href="{{ route('checkout.show') }}"
        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition w-full sm:w-auto text-center">
        {{ __('Checkout') }}
      </a>
    </div>
  </div>
  @else
  {{-- Empty Cart --}}
  <div class="text-center py-12 px-4 sm:px-6">
    <img src="{{ asset('frontend/images/empty_cart.png') }}" alt="Empty Cart"
      class="mx-auto w-40 sm:w-64 mb-6 animate-bounce">
    <h3 class="text-lg sm:text-xl font-semibold text-gray-700">{{ __('Your cart is empty') }}</h3>
    <p class="text-gray-500 mt-2 text-sm sm:text-base">{{ __('Looks like you haven’t added anything yet.') }}</p>
    <a href="{{ route('home') }}"
      class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition w-full sm:w-auto">
      {{ __('Browse Products') }}
    </a>
  </div>
  @endif
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const cartTotalEl = document.getElementById("cartTotal");

    function sendUpdate(id, qty, row) {
      fetch(`/cart/update/${id}`, {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
            "Accept": "application/json"
          },
          body: JSON.stringify({
            quantity: qty
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // update row qty + subtotal
            const qtyEl = row.querySelector(".qty");
            const subtotalEl = row.querySelector(".subtotal");

            qtyEl.textContent = data.quantity;
            subtotalEl.textContent = data.subtotal;

            // update total
            if (cartTotalEl) cartTotalEl.textContent = data.total;
          } else {
            alert(data.message || "Update failed");
            if (data.quantity && row) {
              row.querySelector(".qty").textContent = data.quantity;
            }
          }
        })
        .catch(() => alert("Something went wrong"));
    }

    // handle increase/decrease buttons logic
    document.querySelectorAll(".increase, .decrease").forEach(btn => {
      btn.addEventListener("click", function() {
        const row = this.closest("[data-id]");
        const id = row.dataset.id;
        const qtyEl = row.querySelector(".qty");
        let qty = parseInt(qtyEl.textContent);

        if (this.classList.contains("increase")) {
          qty++;
        } else {
          if (qty > 1) {
            qty--;
          } else {
            alert("Minimum quantity is 1");
            return;
          }
        }

        sendUpdate(id, qty, row);
      });
    });

    document.querySelectorAll(".remove-item").forEach(btn => {
      btn.addEventListener("click", function() {
        const id = this.dataset.id;
        fetch(`/cart/remove/${id}`, {
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": "{{ csrf_token() }}",
              "Accept": "application/json"
            }
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) location.reload();
          });
      });
    });
  });
</script>

@endsection