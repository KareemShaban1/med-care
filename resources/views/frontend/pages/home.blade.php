@extends('frontend.layouts.app')
@section('title','Home')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>

</style>
@endpush


@section('content')

<!-- Banners -->
@include('frontend.pages.partials.banners', ['banners' => $banners])

{{-- Product Sections --}}
<div class="container mx-auto my-12">

    {{-- New Arrivals --}}
    <div class="mb-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">{{ __('New Arrivals') }}</h2>
            <div class="flex gap-2">
                <div class="swiper-button-prev-new text-gray-600 hover:text-black">
                    <i class="bi bi-arrow-left-circle"></i>
                </div>
                <div class="swiper-button-next-new text-gray-600 hover:text-black">
                    <i class="bi bi-arrow-right-circle"></i>
                </div>

            </div>
        </div>
        <div class="swiper newArrivalsSwiper">
            <div class="swiper-wrapper">
                @foreach($newArrivals as $product)
                <div class="swiper-slide">
                    @include('frontend.pages.partials.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Best Sellers --}}
    <div class="mb-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">{{ __('Best Sellers') }}</h2>
            <div class="flex gap-2">
                <div class="swiper-button-prev-best text-gray-600 hover:text-black">
                    <i class="bi bi-arrow-left-circle"></i>
                </div>
                <div class="swiper-button-next-best text-gray-600 hover:text-black">
                    <i class="bi bi-arrow-right-circle"></i>
                </div>

            </div>
        </div>
        <div class="swiper bestSellersSwiper">
            <div class="swiper-wrapper">
                @foreach($bestSellers as $product)
                <div class="swiper-slide">
                    @include('frontend.pages.partials.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Popular --}}
    <div class="mb-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">{{ __('Popular Products') }}</h2>
            <div class="flex gap-2">
                <div class="swiper-button-prev-popular text-gray-600 hover:text-black">
                    <i class="bi bi-arrow-left-circle"></i>
                </div>
                <div class="swiper-button-next-popular text-gray-600 hover:text-black">
                    <i class="bi bi-arrow-right-circle"></i>
                </div>

            </div>
        </div>
        <div class="swiper popularSwiper">
            <div class="swiper-wrapper">
                @foreach($popular as $product)
                <div class="swiper-slide">
                    @include('frontend.pages.partials.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<!-- Service Features -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 text-center">
                <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                <h5>{{ __('Free Shipping') }}</h5>
                <p class="text-muted">{{ __('On orders over $99') }}</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-undo fa-3x text-success mb-3"></i>
                <h5>{{ __('Easy Returns') }}</h5>
                <p class="text-muted">{{ __('30-day return policy') }}</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-headset fa-3x text-warning mb-3"></i>
                <h5>{{ __('24/7 Support') }}</h5>
                <p class="text-muted">{{ __('Customer service') }}</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-shield-alt fa-3x text-info mb-3"></i>
                <h5>{{ __('Secure Payment') }}</h5>
                <p class="text-muted">{{ __('100% secure checkout') }}</p>
            </div>
        </div>
    </div>
</section>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script>
    new Swiper(".mySwiper", {
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        autoplay: {
            delay: 2000
        },
    });

    // New Arrivals Swiper
    new Swiper(".newArrivalsSwiper", {
        slidesPerView: 1, // default for smallest screens
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next-new",
            prevEl: ".swiper-button-prev-new"
        },
        autoplay: {
            delay: 3000
        },
        breakpoints: {
            640: {
                slidesPerView: 2
            }, // ≥640px
            768: {
                slidesPerView: 3
            }, // ≥768px
            1024: {
                slidesPerView: 4
            } // ≥1024px
        }
    });

    // Best Sellers Swiper
    new Swiper(".bestSellersSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next-best",
            prevEl: ".swiper-button-prev-best"
        },
        autoplay: {
            delay: 3000
        },
        breakpoints: {
            640: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3
            },
            1024: {
                slidesPerView: 4
            }
        }
    });

    // Popular Swiper
    new Swiper(".popularSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next-popular",
            prevEl: ".swiper-button-prev-popular"
        },
        autoplay: {
            delay: 3000
        },
        breakpoints: {
            640: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3
            },
            1024: {
                slidesPerView: 4
            }
        }
    });
</script>
@endpush