<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title','Medical Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @if (App::getLocale() == 'en')
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet" type="text/css">
    @else
    <link href="{{ asset('frontend/css/rtl_style.css') }}" rel="stylesheet">
    @endif

    <!-- Global CSS -->
    <link href="{{ asset('frontend/css/global.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

    @include('frontend.layouts.header')

    <main class="py-4 md:mx-[150px] lg:mx-[150px]">
        <div class="container">
            @yield('content')
        </div>
    </main>

    @include('frontend.layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toast container -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
        @if(session('toast_success'))
        <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('toast_success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if(session('toast_error'))
        <div id="toastError" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('toast_error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>


    @stack('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            toastElList.map(function(toastEl) {
                var toast = new bootstrap.Toast(toastEl, {
                    delay: 3000,
                    autohide: true,
                    animation: true,
                    keyboard: true,
                });
                toast.show();
            })
        });

        const menuToggle = document.getElementById("menuToggle");
        const mobileMenu = document.getElementById("mobileMenu");

        menuToggle.addEventListener("click", () => {
            mobileMenu.style.display = mobileMenu.style.display === "block" ? "none" : "block";
        });
    </script>


</body>

</html>