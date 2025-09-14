@extends('frontend.layouts.app')
@section('title','Home')



@section('content')

<div class="container mx-auto py-8">
    <div class="grid grid-cols-12 gap-6">

        {{-- Filters Sidebar --}}
        <div class="col-span-12 md:col-span-3">
            <div class="bg-white p-4 rounded-xl shadow mb-6">
                <form id="filtersForm" class="grid grid-cols-1 gap-4">
                    <div class="relative flex items-center">
                        <input id="searchInput" name="q" value="{{ request('q') }}"
                            class="form-control block w-full rounded-md border-gray-300"
                            placeholder="{{ __('Search Products') }}" />

                        <span class="ms-2 text-muted" data-bs-toggle="tooltip" title="{{ __('Type product name at least 3 characters to search') }}"
                        style="position: absolute; left: 0px; top: 50%; transform: translateY(-50%);">
                            <i class="fa fa-info-circle"></i>
                        </span>
                    </div>
                    <div>
                        <select name="category" id="categoryFilter"
                            class="form-select block w-full rounded-md border-gray-300">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="sort" id="sortFilter"
                            class="form-select block w-full rounded-md border-gray-300">
                            <option value="">{{ __('Sort') }}</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('Price ↓') }}</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('Price ↑') }}</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button class="btn btn-success w-full">{{ __('Apply') }}</button>
                        <button type="button" class="btn btn-secondary w-full" id="resetFilters">{{ __('Reset') }}</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Products Section (col-8) --}}
        <div class="col-span-12 md:col-span-9">
            <div id="productsGrid">
                @include('frontend.pages.partials.products', ['products' => $products])
            </div>
        </div>


    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filtersForm = document.getElementById('filtersForm');
        const productsGrid = document.getElementById('productsGrid');
        const searchInput = document.getElementById('searchInput');
        const resetBtn = document.getElementById('resetFilters');
        const productSearchUrl = "{{ route('home') }}";

        if (!filtersForm || !productsGrid) {
            console.warn('Filters form or products grid missing — aborting AJAX binding.');
            return;
        }

        // debounce
        function debounce(fn, delay = 350) {
            let t;
            return function(...args) {
                clearTimeout(t);
                t = setTimeout(() => fn.apply(this, args), delay);
            };
        }

        // Re-bind pagination links inside productsGrid to load via AJAX
        function bindPaginationLinks() {
            productsGrid.querySelectorAll('.pagination a').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href, location.origin);
                    const params = Object.fromEntries(url.searchParams.entries());
                    loadProducts(params);
                    // update browser history (optional)
                    history.pushState(null, '', this.href);
                });
            });
        }

        // Load products partial via AJAX and rebind behaviors
        function loadProducts(params = {}) {
            const url = productSearchUrl + '?' + new URLSearchParams(params);
            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.text();
                })
                .then(html => {
                    productsGrid.innerHTML = html;
                    bindPaginationLinks();
                })
                .catch(err => {
                    console.error('loadProducts error', err);
                });
        }

        // Reset filters — clear inputs and reload grid
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                filtersForm.reset();
                if (searchInput) searchInput.value = '';
                // build params from cleared form
                const params = new FormData(filtersForm);
                loadProducts(Object.fromEntries(params));
            });
        }

        // Live search (3+ chars or cleared)
        if (searchInput) {
            searchInput.addEventListener('input', debounce(function() {
                const q = this.value.trim();
                if (q.length >= 3 || q.length === 0) {
                    const params = new FormData(filtersForm);
                    loadProducts(Object.fromEntries(params));
                }
            }));
        }

        // Select change handlers
        ['categoryFilter', 'sortFilter'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('change', function() {
                const params = new FormData(filtersForm);
                loadProducts(Object.fromEntries(params));
            });
        });

        // Form submit (Apply button)
        filtersForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const params = new FormData(filtersForm);
            loadProducts(Object.fromEntries(params));
        });

        // initial bind for pagination links on first load
        bindPaginationLinks();

        // handle browser back/forward to reload correct grid
        window.addEventListener('popstate', function() {
            // re-load using current location's query params
            const url = new URL(location.href);
            loadProducts(Object.fromEntries(url.searchParams.entries()));
        });


        // Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush