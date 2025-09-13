<header class="shadow-sm py-2 d-flex align-items-center bg-gray-200" style="height: 80px;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">

            <div>
                <a class="navbar-brand text-lg d-flex align-items-center gap-2" href="{{ route('home') }}">
                    <h5 class="fw-bold text-lg d-flex align-items-center gap-2">
                        <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo">
                        MediStore
                    </h5>
                </a>
            </div>
            <!-- Desktop Navigation -->
            <nav class="d-none d-md-flex gap-3">
                <a href="{{ route('home') }}" class="nav-link text-dark text-lg">{{ __('Home') }}</a>
                <a href="{{ route('all-products') }}" class="nav-link text-dark text-lg">{{ __('Products')}}</a>
                <a href="{{ route('policy') }}" class="nav-link text-dark text-lg">{{ __('Privacy & Policy')}}</a>
                <a href="{{ route('contact') }}" class="nav-link text-dark text-lg">{{ __('Contact')}}</a>
            </nav>

            <!-- Right Section -->
            <div class="d-flex align-items-center">
                <div class="collapse navbar-collapse d-none d-md-flex">
                    <ul class="navbar-nav ms-auto d-flex justify-content-between flex-row">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                @if (App::getLocale() == 'ar')
                                <img src="{{ asset('backend/assets/images/flags/eg.png') }}" alt="">
                                @else
                                <img src="{{ asset('backend/assets/images/flags/us.png') }}" alt="">
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu">

                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a class="dropdown-item notify-item" rel="alternate" hreflang="{{ $localeCode }}"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                                @endforeach

                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="cartDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- <i class="fa-solid fa-cart-shopping"></i> -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-bag" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.852a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z"></path>
                                    <path d="M9 11v-5a3 3 0 0 1 6 0v5"></path>
                                </svg>
                                <span class="badge bg-green-600 rounded-pill position-absolute top-0 start-100 translate-middle cart-badge">
                                    {{ count(session('cart', [])) }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3 cart-menu" aria-labelledby="cartDropdown">
                                @php
                                $cart = session('cart', []);
                                $total = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);
                                @endphp

                                @forelse ($cart as $item)
                                <li class="d-flex align-items-center mb-2 gap-2">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" width="40" class="me-2 rounded">
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">{{ $item['name'] }}</div>
                                        <small>Qty: {{ $item['quantity'] }} × {{ number_format($item['price'], 2) }}</small>
                                    </div>
                                    <div class="text-end">
                                        <strong>{{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @empty
                                <li class="text-center text-muted">{{ __('Your cart is empty') }}</li>
                                @endforelse

                                @if(count($cart))
                                <li class="d-flex justify-content-between fw-bold">
                                    <span>{{ __('Total') }}:</span>
                                    <span>{{ number_format($total, 2) }}</span>
                                </li>
                                <li class="mt-2">
                                    <a href="{{ route('cart.index') }}" class="btn btn-primary w-100">{{ __('View Cart') }}</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>



                <!-- Mobile Menu Button -->
                <button class="btn btn-outline-secondary d-md-none" id="menuToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="d-md-none mt-2" style="position: absolute;z-index: 10;width: 95%;left: 2.5%;">
            <nav class="mb-2 d-flex flex-column align-items-center">
                <a href="{{ route('home') }}" class="nav-link text-dark">{{ __('Home') }}</a>
                <a href="{{ route('all-products') }}" class="nav-link text-dark">{{ __('Products') }}</a>
                <a href="{{ route('policy') }}" class="nav-link text-dark">{{ __('Privacy & Policy') }}</a>
                <a href="{{ route('contact') }}" class="nav-link text-dark">{{ __('Contact') }}</a>
            </nav>
            <div class="mb-3">
                <ul class="navbar-nav ms-auto d-flex flex-column align-items-center gap-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            @if (App::getLocale() == 'ar')
                            <img src="{{ asset('backend/assets/images/flags/eg.png') }}" alt="">
                            @else
                            <img src="{{ asset('backend/assets/images/flags/us.png') }}" alt="">
                            @endif
                        </a>

                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu">

                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item notify-item" rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                            @endforeach

                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="cartDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="badge bg-green-600 rounded-pill position-absolute top-0 start-100 translate-middle cart-badge">
                                {{ count(session('cart', [])) }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3 cart-menu" aria-labelledby="cartDropdown">
                            @php
                            $cart = session('cart', []);
                            $total = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);
                            @endphp

                            @forelse ($cart as $item)
                            <li class="d-flex align-items-center mb-2 gap-2">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" width="40" class="me-2 rounded">
                                <div class="flex-grow-1">
                                    <div class="fw-bold">{{ $item['name'] }}</div>
                                    <small>Qty: {{ $item['quantity'] }} × {{ number_format($item['price'], 2) }}</small>
                                </div>
                                <div class="text-end">
                                    <strong>{{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @empty
                            <li class="text-center text-muted">{{ __('Your cart is empty') }}</li>
                            @endforelse

                            @if(count($cart))
                            <li class="d-flex justify-content-between fw-bold">
                                <span>{{ __('Total') }}:</span>
                                <span>{{ number_format($total, 2) }}</span>
                            </li>
                            <li class="mt-2">
                                <a href="{{ route('cart.index') }}" class="btn btn-primary w-100">{{ __('View Cart') }}</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>