@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto py-10">
  <h3 class="text-2xl font-bold mb-8 text-center">🛍️ {{ __('Checkout') }}</h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
    
    {{-- Checkout Illustration --}}
    <div class="hidden md:block">
      <img src="{{ asset('frontend/images/checkout.png') }}" 
           alt="Checkout" 
           class="w-full max-w-md mx-auto animate-fade-in">
    </div>

    {{-- Checkout Form --}}
    <div class="bg-white p-6 rounded-xl shadow-lg">
      <form method="POST" action="{{ route('checkout.process') }}" class="space-y-5">
        @csrf

        <div>
          <label class="block font-medium mb-1">{{ __('Full name') }}</label>
          <input name="customer_name" 
                 value="{{ old('customer_name') }}"
                 class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-300"
                 required>
          @error('customer_name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div>
          <label class="block font-medium mb-1">{{ __('Phone') }}</label>
          <input name="customer_phone" 
                 value="{{ old('customer_phone') }}"
                 class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-300"
                 required>
          @error('customer_phone')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div>
          <label class="block font-medium mb-1">{{ __('Delivery address') }}</label>
          <textarea name="delivery_address" rows="3"
                    class="w-full border rounded-md px-3 py-2 focus:ring focus:ring-blue-300"
                    required>{{ old('delivery_address') }}</textarea>
          @error('delivery_address')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div class="flex justify-between items-center border-t pt-4">
          <strong class="text-lg">{{ __('Total') }}: 
            <span class="text-green-600">{{ __('EGP') }} {{ number_format($total,2) }}</span>
          </strong>
          <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition">
            {{ __('Place order') }} →
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Small animation --}}
<style>
  @keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fade-in {
    animation: fade-in 1s ease-in-out;
  }
</style>
@endsection
