@extends('frontend.layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="container mx-auto px-4 py-12">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

        {{-- Contact Info --}}
        <div class="bg-white shadow-xl rounded-2xl p-8 space-y-6">

            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ __('Contact Us') }}</h1>
            <p class="text-gray-600">{{ __('Contact Description') }}</p>

            <div class="space-y-4">
                <div class="flex items-start space-x-4">
                    <div class="text-blue-600 text-2xl">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ __('Address') }}</h3>
                        <p class="text-gray-600">{{ __('Address Description') }}</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="text-blue-600 text-2xl">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ __('Phone') }}</h3>
                        <p class="text-gray-600">{{ __('Phone Description') }}</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="text-blue-600 text-2xl">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ __('Email') }}</h3>
                        <p class="text-gray-600">{{ __('Email Description') }}</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="text-blue-600 text-2xl">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ __('Working Hours') }}</h3>
                        <p class="text-gray-600">{{ __('Working Hours Description') }}</p>
                    </div>
                </div>
            </div>



        </div>

        {{-- Contact Form --}}
        <div class="bg-white shadow-xl rounded-2xl p-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Send Us a Message') }}</h2>
            <form action="" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="email">{{ __('Email') }}</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="subject">{{ __('Subject') }}</label>
                    <input type="text" name="subject" id="subject"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1" for="message">{{ __('Message') }}</label>
                    <textarea name="message" id="message" rows="5" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-300">
                    {{ __('Send Message') }}
                </button>
            </form>
        </div>

    </div>

    {{-- Map --}}
    <div class="mt-12 rounded-xl overflow-hidden shadow-lg">
        <iframe
            class="w-full h-96"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3456.123456789!2d31.2357123!3d30.0444192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458411234567890%3A0xabcdef1234567890!2sMediStore!5e0!3m2!1sen!2seg!4v1694598741234!5m2!1sen!2seg"
            allowfullscreen=""
            loading="lazy"></iframe>
    </div>
</div>
@endsection