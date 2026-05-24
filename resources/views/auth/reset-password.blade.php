<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label class="dark:text-[#EDEDEC]" for="email" :value="__('Email')" />

            <div class="absolute mt-[2.1rem]">
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <x-text-input id="email" class="block w-full focus:border-gray-300 focus:ring-gray-300 dark:bg-[#3a3a3a] dark:border-black dark:focus:border-black dark:focus:ring-black cursor-not-allowed"
                            type="email"
                            name="email"
                            :value="old('email', $request->email)"
                            readonly
                            required
                            autocomplete="username" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label class="dark:text-[#EDEDEC]" for="password" :value="__('Password')" />

            <div class="absolute mt-[2.1rem]">
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <x-text-input id="password" class="block w-full dark:bg-[#3a3a3a] dark:border-black"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label class="dark:text-[#EDEDEC]" for="password_confirmation" :value="__('Confirm Password')" />

            <div class="absolute mt-[2.1rem]">
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <x-text-input id="password_confirmation" class="block w-full dark:bg-[#3a3a3a] dark:border-black"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
