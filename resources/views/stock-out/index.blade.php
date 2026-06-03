<x-app-layout>
    <x-slot name="header">
        {{ __('Stock Out') }}
    </x-slot>

    <div class="mt-12 max-h-210 overflow-y-auto">
        <div x-data="{ stockOutState: Alpine.$persist('list') }"
             x-init="
                if ('{{ session('status') }}' === 'success') {
                    stockOutState = 'list';
                } else if ({{ $errors->any() ? 'true' : 'false' }}) {
                    stockOutState = 'create';
                }
             "
             class="w-300">

            <div x-show="stockOutState === 'list'" class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('stock-out.partials.table-list')
                </div>
            </div>

            <div x-show="stockOutState === 'create'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('stock-out.partials.create-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
