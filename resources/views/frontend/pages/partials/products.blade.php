<div class="col-span-12 md:col-span-8">
    <div id="productsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
        <div class="col-span-1">
            <div class="group card h-full shadow-md rounded-xl overflow-hidden bg-white 
                        transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">

                {{-- Product Image --}}
                <div class="relative">
                    <!-- product type -->
                    <span class="text-white px-2 py-1 rounded absolute top-2 left-2 z-10
                        @switch($product->type)
                            @case('best_seller')
                                bg-green-600
                                @break
                            @case('new_arrival')
                                bg-blue-600
                                @break
                            @case('popular')
                                bg-red-600
                                @break
                            @case('top_rated')
                                bg-yellow-600
                                @break
                            @default
                                bg-gray-600
                        @endswitch
                        ">
                        {{ __( $product->type) }}
                    </span>

                    @if($product->main_image_url)
                    <img src="{{ $product->main_image_url }}"
                        class="w-full h-48 object-cover transform group-hover:scale-105 transition duration-500">
                    @else
                    <div class="bg-gray-100 flex items-center justify-center h-48">No Image</div>
                    @endif

                    {{-- Quick View Button --}}
                    <a href=""
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 
                          flex items-center justify-center transition duration-300">
                        <span class="px-3 py-2 bg-white text-sm rounded-lg shadow hover:bg-gray-100">
                            View Details
                        </span>
                    </a>
                </div>

                {{-- Product Info --}}
                <div class="p-4 flex flex-col space-y-2">
                    <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-gray-800">
                        <h6 class="font-semibold text-gray-800 truncate text-lg">{{ $product->name }}</h6>
                    </a>
                    <p class="text-sm text-gray-500">Category:
                        <span class="badge bg-primary text-white">{{ $product->category->name }}</span>
                    </p>

                    {{-- Prices --}}
                    @if($product->old_price)
                    <div class="flex items-center space-x-2 mb-2 gap-2">
                        <p class="text-sm font-bold text-green-600">EGP {{ number_format($product->price,2) }}</p>
                        <p class="text-sm line-through text-red-500">EGP {{ number_format($product->old_price,2) }}</p>
                    </div>
                    @else
                    <p class="text-sm font-bold text-gray-700 mb-2">EGP {{ number_format($product->price,2) }}</p>
                    @endif

                    {{-- Add to Cart --}}
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-auto">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button
                            class="btn btn-sm w-full rounded-lg text-white py-2 transition {{ $product->stock <= 0 ? 'bg-red-600 hover:bg-red-700 cursor-not-allowed opacity-100' : 'bg-green-600 hover:bg-green-700' }}"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}
                            style="{{ $product->stock <= 0 ? 'opacity: 1 !important;' : '' }}">
                            {{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        <div class="flex justify-center">
            {{ $products->links('pagination::tailwind') }}
        </div>
    </div>
</div>