<footer class="footer-bg text-black py-5 bg-gray-200">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6 mt-4">
                <h5 class="fw-bold mb-3 text-lg d-flex align-items-center gap-2">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo">
                    MediStore
                </h5>
                <p class="text-gray-600">
                    {{ __('Footer Description') }}
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-gray-600"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-gray-600"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-gray-600"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-gray-600"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-4 mt-4 d-none d-sm-block">
                <h5 class="fw-bold text-lg mb-3">{{ __('Quick Links') }}</h5>
                <ul class="flex flex-col gap-2">
                    <li><a href="#" class="inline-block hover:text-green-600
                    text-gray-600">{{ __('About Us') }}</a></li>
                    <li><a href="#" class="inline-block hover:text-green-600
                    text-gray-600">{{ __('Contact') }}</a></li>
                    <li><a href="#" class="inline-block hover:text-green-600
                    text-gray-600">{{ __('FAQ') }}</a></li>
                    <li><a href="#" class="inline-block hover:text-green-600
                    text-gray-600">{{ __('Blog') }}</a></li>
                    <li><a href="#" class="inline-block hover:text-green-600
                    text-gray-600">{{ __('Careers') }}</a></li>
                </ul>
            </div>

            <div class="col-md-3 col-4 mt-4 d-none d-sm-block">
                <h5 class="fw-bold text-lg mb-3">{{ __('Customer Service') }}</h5>
                <ul class="flex flex-col gap-2">
                    <li><a href="#" class="inline-block hover:text-green-600 text-gray-600">{{ __('Shipping Info') }}</a></li>
                    <li><a href="#" class="inline-block hover:text-green-600 text-gray-600">{{ __('Returns') }}</a></li>
                    <li><a href="#" class="inline-block hover:text-green-600 text-gray-600">{{ __('Size Guide') }}</a></li>
                    <li><a href="#" class="inline-block hover:text-green-600 text-gray-600">{{ __('Track Order') }}</a></li>
                    <li><a href="#" class="inline-block hover:text-green-600 text-gray-600">{{ __('Support') }}</a></li>
                </ul>
            </div>

            <div class="col-md-3 col-6 mt-4">
                <h5 class="fw-bold text-lg mb-3">{{ __('Contact Info') }}</h5>
                <div class="flex flex-col gap-2 text-gray-600">
                    <p><i class="fas fa-map-marker-alt me-2"></i>123 Tech Street, Digital City</p>
                    <p><i class="fas fa-phone me-2"></i>+1 (555) 123-4567</p>
                    <p><i class="fas fa-envelope me-2"></i>info@techstore.com</p>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="row align-items-center text-center text-md-end">
            <div class="col-md-6 mb-3 mb-md-0">
                <p class="mb-0 text-gray-600">&copy; {{ date('Y') }} MediStore. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-flex justify-content-center justify-content-md-end gap-3">
                    <i class="fab fa-cc-visa fa-2x text-gray-600"></i>
                    <i class="fab fa-cc-mastercard fa-2x text-gray-600"></i>
                    <i class="fab fa-cc-paypal fa-2x text-gray-600"></i>
                    <i class="fab fa-cc-apple-pay fa-2x text-gray-600"></i>
                </div>
            </div>
        </div>

    </div>
</footer>