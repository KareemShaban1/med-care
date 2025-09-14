<div class="group card h-full shadow-md rounded-xl overflow-hidden bg-white 
            transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1
            p-4">

    {{-- Product Image --}}
    <div class="relative">
        @if($product->main_image_url)
        <img src="{{ $product->main_image_url }}"
            alt="{{ $product->name }}"
            class="w-full h-48 object-cover transform group-hover:scale-105 transition duration-500
            rounded-lg">
        @else
        <div class="bg-gray-100 flex items-center justify-center h-48 text-gray-400">
            {{ __('No Image') }}
        </div>
        @endif

        {{-- Discount & Sale Badges --}}
        @if($product->old_price && $product->old_price > $product->price)
        @php
        $discount = round((($product->old_price - $product->price) / $product->old_price) * 100);
        @endphp
        <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-lg shadow">
            -{{ $discount }}%
        </span>
        <span class="absolute top-3 right-3 bg-yellow-400 text-gray-800 text-xs font-bold px-2 py-1 rounded-lg shadow">
            {{ __('Sale') }}
        </span>
        @endif

        {{-- Quick View Button --}}
        <a href="{{ route('product.show', $product->slug) }}"
            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 
                  flex items-center justify-center transition duration-300">
            <span class="px-3 py-2 bg-white text-sm rounded-lg shadow hover:bg-gray-100">
                {{ __('View Details') }}
            </span>
        </a>
    </div>

    {{-- Product Info --}}
    <div class="pt-4 flex flex-col space-y-2">
        <h6 class="font-semibold text-gray-800 truncate">{{ $product->name }}</h6>
        <p class="text-xs text-gray-500">
            <span class="font-semibold text-gray-800">{{ __('Category') }}</span>:
            <span class="text-gray-800 text-xs">{{ $product->category->name ?? '-' }}</span>
        </p>
        @php
        $maxStock = max($product->stock, 1); // prevent division by zero
        $sold = rand(0, $maxStock); // example if you track sold separately
        $remaining = $product->stock;
        $progress = ($remaining / ($remaining + $sold)) * 100;
        @endphp

        <div class="w-full mt-2">
            <div class="flex justify-between items-center text-xs mb-1">
                <span class="font-semibold text-gray-800">{{ __('Stock') }}</span>
                <span class="text-gray-600"> {{ __('left') }} {{ $remaining }} {{ __('from') }} {{ $remaining + $sold }}</span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                <div class="bg-green-500 h-2 rounded-full transition-all duration-500"
                    style="width: {{ $progress }}%"></div>
            </div>

            <!-- <p class="text-[11px] mt-1 text-gray-500">
                {{ $sold }} {{ __('sold') }} / {{ $remaining + $sold }} {{ __('total') }}
            </p> -->
        </div>


        {{-- Prices --}}
        @if($product->old_price && $product->old_price > $product->price)
        <div class="flex items-center space-x-2 mb-2 gap-3">
            <p class="text-sm font-bold text-green-600">
                {{ __('EGP') }} {{ number_format($product->price, 2) }}
            </p>
            <p class="text-sm line-through text-red-500">
                {{ __('EGP') }} {{ number_format($product->old_price, 2) }}
            </p>
        </div>
        @else
        <p class="text-sm font-bold text-gray-700 mb-2">
            {{ __('EGP') }} {{ number_format($product->price, 2) }}
        </p>
        @endif

        {{-- Add to Cart --}}
        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-auto">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button
                class="btn btn-sm w-full rounded-lg text-white py-2 transition 
                       {{ $product->stock <= 0 
                            ? 'bg-red-600 hover:bg-red-700 cursor-not-allowed opacity-100' 
                            : 'bg-green-600 hover:bg-green-700' }}"
                {{ $product->stock <= 0 ? 'disabled' : '' }}
                style="{{ $product->stock <= 0 ? 'opacity: 1 !important;' : '' }}">
                {{ $product->stock <= 0 ? __('Out of Stock') : __('Add To Cart') }}
            </button>
        </form>
    </div>
</div>