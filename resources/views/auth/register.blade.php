<x-guest-layout>

    <div style="display: flex; justify-content: center; align-items: center; margin: 0;">
        <a href="/" style="margin-bottom: 10px;">
            <img src="{{ asset('images/logo_light_instagram.png') }}" alt="Your Logo" style="width: 300px;">
        </a>
    </div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" required autofocus />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Hidden Photo Input -->
        <input type="hidden" name="photo" value="default-photo.jpg" /> 

        <!-- Hidden Biodata Input -->
        <input type="hidden" name="biodata" value="Hi there!" />

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
