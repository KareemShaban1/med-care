<header class="bg-light shadow-sm py-2 d-flex align-items-center"  style="height: 80px;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">

            <!-- Logo -->
            <div>
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fa-solid fa-hospital"></i>
                    MedShop
                </a>
            </div>
            <!-- Desktop Navigation -->
            <nav class="d-none d-md-flex gap-3">
                <a href="{{ route('home') }}" class="nav-link text-dark">Home</a>
                <a href="{{ route('all-products') }}" class="nav-link text-dark">Products</a>
                <a href="#" class="nav-link text-dark">About</a>
                <a href="#" class="nav-link text-dark">Contact</a>
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
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle cart-badge">
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
                                <li class="text-center text-muted">Your cart is empty</li>
                                @endforelse

                                @if(count($cart))
                                <li class="d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span>{{ number_format($total, 2) }}</span>
                                </li>
                                <li class="mt-2">
                                    <a href="{{ route('cart.index') }}" class="btn btn-primary w-100">View Cart</a>
                                </li>
                                @endif
                            </ul>
                        </li>


                    </ul>



                </div>



                <!-- Mobile Menu Button -->
                <button class="btn btn-outline-secondary d-md-none" id="menuToggle">
                    <i class="ri-menu-line"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="d-md-none mt-2">
            <nav class="mb-2 d-flex flex-column align-items-center">
                <a href="#" class="nav-link text-dark">Home</a>
                <a href="#" class="nav-link text-dark">Shop</a>
                <a href="#" class="nav-link text-dark">About</a>
                <a href="#" class="nav-link text-dark">Contact</a>
            </nav>
            <div class="mb-3">
                <a href="#" class="btn w-100">
                    <i class="ri-login-circle-line"></i>
                </a>
                <a href="#" class="btn w-100 mb-2">
                    <i class="ri-shopping-cart-2-line"></i>
                </a>
            </div>
            <input type="text" class="form-control" placeholder="Search...">
        </div>
    </div>
</header>