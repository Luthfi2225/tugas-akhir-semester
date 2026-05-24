<div class="mb-4 text-sm text-gray-600 dark:text-[#EDEDEC]">
    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
</div>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email Address -->
    <div>
        <x-input-label class="dark:text-[#EDEDEC]" for="email" :value="__('Email')" />

        <div class="absolute mt-[2.1rem]">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <x-text-input id="email" class="block w-full dark:bg-[#3a3a3a] dark:border-black"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus />
    </div>

    <div class="flex items-center justify-end mt-6">
        <x-primary-button>
            {{ __('Email Password Reset Link') }}
        </x-primary-button>
    </div>
</form>

<!-- Session Status -->
<div class="flex items-center justify-center my-4">
    <x-auth-session-status :status="session('status')" />
</div>
