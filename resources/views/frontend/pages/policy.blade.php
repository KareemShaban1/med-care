@extends('frontend.layouts.app')

@section('title', 'Privacy & Policy')

@section('content')
<div class="container mx-auto px-4 py-12">

    {{-- Card Wrapper --}}
    <div class="bg-white shadow-xl rounded-2xl p-8 md:p-12">
        {{-- Header --}}
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 text-center">
            {{ __('Privacy & Policy') }}
        </h1>
        <p class="text-gray-600 mb-8 text-center max-w-3xl mx-auto">
            {{ __('Policy Description') }}
        </p>

        {{-- Tabs --}}
        <div class="flex justify-center mb-10 space-x-2">
            <button class="policy-tab px-6 py-2 rounded-t-xl bg-blue-600 text-white font-semibold focus:outline-none" data-tab="privacy">Privacy Policy</button>
            <button class="policy-tab px-6 py-2 rounded-t-xl bg-gray-100 text-gray-800 font-semibold focus:outline-none" data-tab="terms">Terms & Conditions</button>
        </div>

        {{-- Content --}}
        <div id="privacy" class="tab-content space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ __('Privacy Policy') }}</h2>
            <p class="text-gray-700 leading-relaxed">
                At <span class="font-semibold">MediStore</span>, we are committed to protecting your personal and medical information. All your data is handled with strict confidentiality.
            </p>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li><span class="font-semibold">Information Collection:</span> We collect personal details, health data, and purchase history to provide accurate prescriptions and recommendations.</li>
                <li><span class="font-semibold">Data Usage:</span> Your information helps us personalize your experience and ensure timely delivery of medicines.</li>
                <li><span class="font-semibold">Data Security:</span> We use advanced encryption and secure servers to safeguard sensitive medical information.</li>
                <li><span class="font-semibold">Third-Party Sharing:</span> Only with authorized medical partners and delivery services, under strict privacy agreements.</li>
            </ul>
        </div>

        <div id="terms" class="tab-content hidden space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Terms & Conditions</h2>
            <p class="text-gray-700 leading-relaxed">
                By using <span class="font-semibold">MediStore</span>, you agree to the following rules and guidelines for safe and legal use of our platform:
            </p>
            <ul class="list-decimal list-inside text-gray-700 space-y-2">
                <li>Use the website responsibly for personal or family medical needs.</li>
                <li>Do not misuse the platform to share or sell prescription medicines illegally.</li>
                <li>Follow all local laws and regulations regarding medical products.</li>
                <li>MediStore reserves the right to update terms and policies to comply with healthcare regulations.</li>
            </ul>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Tabs functionality
    const tabs = document.querySelectorAll('.policy-tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.getAttribute('data-tab');

            contents.forEach(c => c.classList.add('hidden'));
            document.getElementById(target).classList.remove('hidden');

            tabs.forEach(t => t.classList.remove('bg-blue-600','text-white'));
            tabs.forEach(t => t.classList.add('bg-gray-100','text-gray-800'));

            tab.classList.add('bg-blue-600','text-white');
            tab.classList.remove('bg-gray-100','text-gray-800');
        });
    });
</script>
@endpush
