<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="shrink-0">
                <a href="{{ route('dashboard') }}" wire:navigate>
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>

            <div class="ml-23">
                <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 mt-2">
                    {{ $header ?? 'Dashboard' }}
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" wire:navigate
                class="group flex items-center h-fit gap-3"
            >
                <div class="text-md font-medium text-gray-500 dark:text-gray-100 group-hover:text-gray-800 dark:group-hover:text-gray-300">{{ Auth::user()->name }}</div>
                <div class="w-6 h-6 rounded-full bg-red-500 group-hover:bg-red-700"></div>
            </a>

        </div>
    </div>
</nav>
