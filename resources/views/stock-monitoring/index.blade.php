<x-app-layout>
    <x-slot name="header">
        {{ __('Stock Monitoring') }}
    </x-slot>

    <div class="mt-12 max-h-210 w-300">
        <div class="w-full max-h-198 pb-1.75">
            <div class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Real-Time Stock List</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            @if(Auth::user()->isOwner())
                                {{ __('Displays a summary of remaining product stock across all company branches.') }}
                            @else
                                {{ __('Displays a summary of the remaining stock of a specific product at your branch office.') }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="overflow-y-auto w-full max-h-183">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                        <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3 w-12 text-center">No</th>
                                <th scope="col" class="px-4 py-3 w-36">Product Code (SKU)</th>
                                <th scope="col" class="px-4 py-3">Product name</th>
                                <th scope="col" class="px-4 py-3 w-44">Store Branch</th>
                                <th scope="col" class="px-4 py-3 w-32 text-center">Minimum Limit</th>
                                <th scope="col" class="px-4 py-3 w-32 text-center">Active Stock</th>
                                <th scope="col" class="px-4 py-3 w-36 text-center">Status Indikator</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($stocks as $stock)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-4 font-mono text-xs text-gray-600 dark:text-gray-300 font-bold uppercase">
                                        {{ $stock->product?->sku }}
                                    </td>

                                    <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white capitalize">
                                        {{ $stock->product?->product_name }}
                                    </td>

                                    <td class="px-4 py-4 text-gray-600 dark:text-gray-300">
                                        <span class="font-mono font-bold text-xs uppercase">{{ $stock->branch?->branch_code }}</span> - <span class="capitalize">{{ $stock->branch?->branch_name }}</span>
                                    </td>

                                    <td class="px-4 py-4 text-center font-mono text-gray-600 dark:text-gray-300">
                                        {{ $stock->minimum_stock }} {{ $stock->product?->unit }}
                                    </td>

                                    <td class="px-4 py-4 text-center font-mono font-bold text-base {{ $stock->stock <= $stock->minimum_stock ? 'text-red-600 dark:text-red-400 animate-pulse' : 'text-green-600 dark:text-green-400' }}">
                                        {{ $stock->stock }}
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        @if($stock->stock <= $stock->minimum_stock)
                                            <span class="px-2.5 py-1 text-xs font-bold text-red-800 bg-red-100 rounded-md dark:bg-red-900/30 dark:text-red-400 uppercase tracking-wider">
                                                🚨 Restock
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-bold text-green-800 bg-green-100 rounded-md dark:bg-green-900/30 dark:text-green-400 uppercase tracking-wider">
                                                ✓ Safe
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                                        {{ __('There is no logistics stock data recorded in the current branch system.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
