<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div>
        <x-input-label class="dark:text-[#EDEDEC]" for="name" :value="__('Name')" />

        <div class="absolute mt-[1.9rem]">
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <x-text-input id="name" class="block w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name" />
    </div>

    <!-- Email Address -->
    <div class="mt-2">
        <x-input-label class="dark:text-[#EDEDEC]" for="email" :value="__('Email')" />

        <div class="absolute mt-[1.9rem]">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <x-text-input id="email" class="block w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-2">
        <x-input-label class="dark:text-[#EDEDEC]" for="password" :value="__('Password')" />

        <div class="absolute mt-[1.9rem]">
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-text-input id="password" class="block w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-2">
        <x-input-label class="dark:text-[#EDEDEC]" for="password_confirmation" :value="__('Confirm Password')" />

        <div class="absolute mt-[1.9rem]">
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-text-input id="password_confirmation" class="block w-full"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <button type="button" @click="page = 'login'" class="underline text-sm text-gray-600 dark:text-[#EDEDEC] hover:text-gray-900 dark:hover:text-gray-400 rounded-md cursor-pointer">{{ __('Already registered?') }}</button>

        <x-primary-button class="ms-4">
            {{ __('Register') }}
        </x-primary-button>
    </div>
</form>
