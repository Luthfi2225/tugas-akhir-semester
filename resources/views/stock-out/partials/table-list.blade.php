<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Outgoing Goods Adjustment List</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Internal audit logs for damaged, expired, or missing products at your branches.</p>
        </div>

        <button type="button" @click="stockOutState = 'create'"
                class="px-4 py-2 bg-amber-600 hover:bg-amber-500 text-white rounded-md font-semibold text-xs uppercase tracking-widest transition shadow-xs cursor-pointer">
            + Input Goods Out
        </button>
    </div>

    @if($errors->has('quantity'))
        <div class="mb-4 p-4 text-sm text-red-800 bg-red-50 dark:bg-gray-700 dark:text-red-400 font-medium rounded-lg">
            🚨 {{ $errors->first('quantity') }}
        </div>
    @endif

    @if(session('status') === 'success')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 p-4 text-sm text-green-800 bg-green-50 dark:bg-gray-700 dark:text-green-400 font-medium rounded-lg">
            ✓ Success! The warehouse stock quantity has been successfully reduced, and the mutation reason has been locked into the system.
        </div>
    @endif

    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3 w-12 text-center">No</th>
                    <th scope="col" class="px-4 py-3 w-40">Reference Number</th>
                    <th scope="col" class="px-4 py-3 w-36">Business Date</th>
                    <th scope="col" class="px-4 py-3">Product name</th>
                    <th scope="col" class="px-4 py-3 w-28 text-center">Reason</th>
                    <th scope="col" class="px-4 py-3 w-32 text-center">Initial Stock</th>
                    <th scope="col" class="px-4 py-3 w-32 text-center">Out Amount</th>
                    <th scope="col" class="px-4 py-3 w-32 text-center">Ending Stock</th>
                    <th scope="col" class="px-4 py-3">Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($histories as $history)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 font-mono text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">{{ $history->reference_number }}</td>
                        <td class="px-4 py-4 text-gray-600 dark:text-gray-300">{{ $history->transaction_date->format('Y-m-d') }}</td>
                        <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white capitalize">{{ $history->product?->product_name }}</td>

                        <td class="px-4 py-4 text-center">
                            @if($history->reason === 'damaged')
                                <span class="px-2 py-0.5 text-xs font-semibold text-amber-800 bg-amber-100 rounded dark:bg-amber-900/20 dark:text-amber-400">Rusak</span>
                            @elseif($history->reason === 'expired')
                                <span class="px-2 py-0.5 text-xs font-semibold text-red-800 bg-red-100 rounded dark:bg-red-900/20 dark:text-red-400">Expired</span>
                            @elseif($history->reason === 'lost')
                                <span class="px-2 py-0.5 text-xs font-semibold text-blue-800 bg-blue-100 rounded dark:bg-blue-900/20 dark:text-blue-400">Hilang</span>
                            @else
                                <span class="px-2 py-0.5 text-xs font-semibold text-purple-800 bg-purple-100 rounded dark:bg-purple-900/20 dark:text-purple-400">Dicuri</span>
                            @endif
                        </td>

                        <td class="px-4 py-4 text-center font-mono text-gray-600 dark:text-gray-300">{{ $history->beginning_stock }}</td>

                        <td class="px-4 py-4 text-center font-mono font-bold text-red-600 dark:text-red-400">{{ abs($history->quantity) }}</td>

                        <td class="px-4 py-4 text-center font-mono font-bold text-gray-900 dark:text-white">{{ $history->ending_stock }}</td>
                        <td class="px-4 py-4 text-gray-500 dark:text-gray-400 text-xs max-w-xs truncate">{{ $history->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                            There is no log record of goods out/damaged at this branch.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
