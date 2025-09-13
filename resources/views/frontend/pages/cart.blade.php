@extends('frontend.layouts.app')
@section('content')
<div class="container mx-auto py-8">

  <h3 class="text-2xl font-bold mb-6">🛒 {{ __('Your Cart') }}</h3>

  <!-- check cart has products -->
  @if(count($cart))
  {{-- Update Cart Form --}}
  <form method="POST" action="{{ route('cart.update') }}" id="updateCartForm">
    @csrf
    <div class="overflow-x-auto rounded-lg shadow">
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
              <input type="number" name="quantity[{{ $id }}]"
                value="{{ $item['quantity'] }}" min="0"
                class="qty w-20 border rounded-md p-1 text-center focus:ring focus:ring-blue-300">
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

      {{-- Mobile Card Layout --}}
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
            <input type="number" name="quantity[{{ $id }}]"
              value="{{ $item['quantity'] }}" min="0"
              class="qty w-20 border rounded-md p-1 text-center focus:ring focus:ring-blue-300">
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

        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto justify-center">
          <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition w-full sm:w-auto">
            {{ __('Update Cart') }}
          </button>
          <a href="{{ route('checkout.show') }}"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition w-full sm:w-auto text-center">
            {{ __('Checkout') }}
          </a>
        </div>
      </div>
    </div>

  </form>
  @else
  {{-- Empty Cart --}}
  <div class="text-center py-12 px-4 sm:px-6">
    <img src="{{ asset('frontend/images/empty_cart.png') }}"
      alt="Empty Cart"
      class="mx-auto w-40 sm:w-64 mb-6 animate-bounce">

    <h3 class="text-lg sm:text-xl font-semibold text-gray-700">
      {{ __('Your cart is empty') }}
    </h3>

    <p class="text-gray-500 mt-2 text-sm sm:text-base">
      {{ __('Looks like you haven’t added anything yet.') }}
    </p>

    <a href="{{ route('home') }}"
      class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition w-full sm:w-auto">
      {{ __('Browse Products') }}
    </a>
  </div>

  @endif
</div>

{{-- Live cart update script --}}
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const cartTable = document.getElementById("cartTable");
    const cartTotalEl = document.getElementById("cartTotal");

    function updateTotals() {
      let total = 0;
      cartTable?.querySelectorAll("tbody tr").forEach(row => {
        const priceEl = row.querySelector(".price");
        const qtyEl = row.querySelector(".qty");

        // Skip rows without price or quantity input (like "Cart empty" row)
        if (!priceEl || !qtyEl) return;

        const price = parseFloat(priceEl.textContent.replace(/[^\d.]/g, "")) || 0;
        const qty = parseInt(qtyEl.value) || 0;
        const subtotal = price * qty;

        const subtotalEl = row.querySelector(".subtotal");
        if (subtotalEl) subtotalEl.textContent = subtotal.toFixed(2);

        total += subtotal;
      });

      if (cartTotalEl) cartTotalEl.textContent = total.toFixed(2);
    }


    // update cart total live
    cartTable?.addEventListener("input", function(e) {
      if (e.target.classList.contains("qty")) {
        updateTotals();
      }
    });

    // handle remove with AJAX
    cartTable?.addEventListener("click", function(e) {
      if (e.target.classList.contains("remove-item")) {
        const id = e.target.dataset.id;
        fetch(`/cart/remove/${id}`, {
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": "{{ csrf_token() }}",
              "Accept": "application/json"
            }
          }).then(res => res.json())
          .then(data => {
            if (data.success) {
              location.reload();
            }
          });
      }
    });
  });
</script>
@endsection