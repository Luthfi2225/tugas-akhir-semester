<x-app-layout>
    <x-slot name="header">
        {{ __('Stock In') }}
    </x-slot>

    <div class="mt-12 max-h-210 overflow-y-auto">
        <div x-data="{ stockInState: Alpine.$persist('list') }"
             x-init="
                if ('{{ session('status') }}' === 'success') {
                    stockInState = 'list';
                } else if ({{ $errors->any() ? 'true' : 'false' }}) {
                    stockInState = 'create';
                }
             "
             class="w-300">

            <div x-show="stockInState === 'list'" class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('stock-in.partials.table-list')
                </div>
            </div>

            <div x-show="stockInState === 'create'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('stock-in.partials.create-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
