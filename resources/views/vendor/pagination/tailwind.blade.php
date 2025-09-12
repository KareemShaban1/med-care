@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-6">
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                {{ __('Prev') }} 
                ←
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="px-4 py-2 text-sm text-gray-700 bg-white rounded-md border hover:bg-gray-100">
                {{ __('Prev') }} 
                ←
            </a>
        @endif

        {{-- Page Numbers --}}
        <div class="hidden md:flex space-x-2">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-md shadow">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="px-4 py-2 text-sm text-gray-700 bg-white border rounded-md hover:bg-gray-100">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="px-4 py-2 text-sm text-gray-700 bg-white rounded-md border hover:bg-gray-100">
                {{ __('Next') }} 
                →
            </a>
        @else
            <span class="px-4 py-2 text-sm text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                {{ __('Next') }} 
                →
            </span>
        @endif
    </nav>
@endif
