@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6">
  <h3 class="text-2xl font-bold mb-8 text-center">🛍️ {{ __('Checkout') }}</h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
    
    {{-- Checkout Illustration (hidden on small) --}}
    <div class="hidden md:flex justify-center">
      <img src="{{ asset('frontend/images/checkout.png') }}" 
           alt="Checkout" 
           class="w-full max-w-sm lg:max-w-md animate-fade-in">
    </div>

    {{-- Checkout Form --}}
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full">
      <form method="POST" action="{{ route('checkout.process') }}" class="space-y-5">
        @csrf

        {{-- Full name --}}
        <div>
          <label class="block font-medium mb-1 text-sm sm:text-base">{{ __('Full name') }}</label>
          <input name="customer_name" 
                 value="{{ old('customer_name') }}"
                 class="w-full border rounded-md px-3 py-2 text-sm sm:text-base focus:ring focus:ring-blue-300"
                 required>
          @error('customer_name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
          @enderror
        </div>

        {{-- Phone --}}
        <div>
          <label class="block font-medium mb-1 text-sm sm:text-base">{{ __('Phone') }}</label>
          <input name="customer_phone" 
                 value="{{ old('customer_phone') }}"
                 class="w-full border rounded-md px-3 py-2 text-sm sm:text-base focus:ring focus:ring-blue-300"
                 required>
          @error('customer_phone')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
          @enderror
        </div>

        {{-- Delivery address --}}
        <div>
          <label class="block font-medium mb-1 text-sm sm:text-base">{{ __('Delivery address') }}</label>
          <textarea name="delivery_address" rows="3"
                    class="w-full border rounded-md px-3 py-2 text-sm sm:text-base focus:ring focus:ring-blue-300"
                    required>{{ old('delivery_address') }}</textarea>
          @error('delivery_address')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
          @enderror
        </div>

        {{-- Total + Place order --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center border-t pt-4 gap-4">
          <strong class="text-lg text-center sm:text-left">
            {{ __('Total') }}: 
            <span class="text-green-600">{{ __('EGP') }} {{ number_format($total,2) }}</span>
          </strong>
          <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition w-full sm:w-auto">
            {{ __('Place order') }} →
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
