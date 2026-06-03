<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div>
        <x-input-label class="dark:text-[#EDEDEC]" for="email" :value="__('Email')" />

        <div class="absolute mt-[2.1rem]">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <x-text-input id="email" class="block w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required autocomplete="username" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label class="dark:text-[#EDEDEC]" for="password" :value="__('Password')" />

        <div class="absolute mt-[2.1rem]">
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-text-input id="password" class="block w-full"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />
    </div>

    <!-- Remember Me -->
    <div class="block mt-4">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-[#4a4a4a] dark:border-black cursor-pointer" name="remember">
            <span class="ms-2 text-sm text-gray-600 dark:text-[#EDEDEC]">{{ __('Remember me') }}</span>
        </label>
    </div>

    <div class="flex items-center justify-between">
        <div>
            {{-- Your password has been reset. --}}
            <x-auth-session-status :status="session('status')" />
        </div>
        <x-primary-button class="ms-3">
            {{ __('Log in') }}
        </x-primary-button>
    </div>

    <div class="flex items-center justify-center mt-4">
        @if (Route::has('password.request'))
                <button type="button" @click="page = 'forgot-password'" class="underline text-sm text-gray-600 dark:text-[#EDEDEC] hover:text-gray-900 dark:hover:text-gray-400 rounded-md cursor-pointer">{{ __('Forgot your password?') }}</button>
        @endif
    </div>

    <div class="flex items-center justify-center mt-2">
        <span class="ms-2 text-sm text-gray-600 dark:text-[#EDEDEC]">{{ __('Or') }}</span>
    </div>

    <div class="flex items-center justify-center mt-2">
        <span class="text-sm text-gray-600 dark:text-[#EDEDEC]">{{ __('Don\'t have an account?') }}</span>
        <button type="button" @click="page = 'register'" class="underline ms-3 text-sm font-bold text-blue-600 hover:text-blue-700 rounded-md cursor-pointer">{{ __('Register') }}</button>
    </div>
</form>
