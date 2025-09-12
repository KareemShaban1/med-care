@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Product Image --}}
        <div class="relative">
            @if($product->main_image_url)
                <img src="{{ $product->main_image_url }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-96 object-cover rounded-xl shadow-md">
            @else
                <div class="bg-gray-100 flex items-center justify-center h-96 rounded-xl">
                    No Image Available
                </div>
            @endif
        </div>

        {{-- Product Details --}}
        <div class="flex flex-col space-y-4">
            <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>
            <p class="text-sm text-gray-500">Category: {{ $product->category->name ?? 'Uncategorized' }}</p>

            {{-- Prices --}}
            @if($product->old_price)
                <div class="flex items-center space-x-3">
                    <span class="text-xl font-semibold text-green-600">EGP {{ number_format($product->price,2) }}</span>
                    <span class="text-base line-through text-red-500">EGP {{ number_format($product->old_price,2) }}</span>
                </div>
            @else
                <span class="text-xl font-semibold text-gray-700">EGP {{ number_format($product->price,2) }}</span>
            @endif

            {{-- Description --}}
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Description</h3>
                <p class="text-gray-600 leading-relaxed">
                    {!! nl2br(e($product->description ?? 'No description available.')) !!}
                </p>
            </div>

            {{-- Stock Status --}}
            <div>
                @if($product->stock > 0)
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-sm rounded-lg">
                        In Stock ({{ $product->stock }})
                    </span>
                @else
                    <span class="inline-block px-3 py-1 bg-red-100 text-red-700 text-sm rounded-lg">
                        Out of Stock
                    </span>
                @endif
            </div>

            {{-- Add to Cart Form --}}
            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="space-y-3">
                @csrf
                <div class="flex items-center space-x-3">
                    <label for="quantity" class="text-gray-700 font-medium">Quantity</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                           class="w-20 border rounded-md px-2 py-1">
                </div>

                <button type="submit" 
                        class="w-full py-3 rounded-lg text-white text-lg font-semibold transition 
                               {{ $product->stock <= 0 ? 'bg-red-600 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700' }}"
                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    {{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Related Products --}}
    <div class="mt-12">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Related Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($product->category->products->where('id', '!=', $product->id)->take(4) as $related)
                <a href="{{ route('product.show', $related->id) }}" 
                   class="group card h-full shadow-md rounded-xl overflow-hidden bg-white 
                          transform transition hover:shadow-lg hover:-translate-y-1">
                    <div class="relative">
                        @if($related->main_image_url)
                            <img src="{{ $related->main_image_url }}" 
                                 class="w-full h-40 object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="bg-gray-100 flex items-center justify-center h-40">No Image</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h6 class="font-semibold text-gray-800 truncate">{{ $related->name }}</h6>
                        <p class="text-sm text-gray-500">Category: {{ $related->category->name }}</p>
                        @if($related->old_price)
                        <div class="flex items-center space-x-3 gap-2">
                            <span class="text-xl font-semibold text-green-600">EGP {{ number_format($related->price,2) }}</span>
                            <span class="text-base line-through text-red-500">EGP {{ number_format($related->old_price,2) }}</span>
                        </div>
                        @else
                            <span class="text-xl font-semibold text-gray-700">EGP {{ number_format($related->price,2) }}</span>
                        @endif
                        
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
