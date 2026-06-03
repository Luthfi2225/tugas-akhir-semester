<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Incoming Goods Supply History</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Below is the log of incoming goods documents at your branch.</p>
        </div>

        <button type="button" @click="stockInState = 'create'"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-md font-semibold text-xs uppercase tracking-widest transition shadow-xs cursor-pointer">
            + Incoming Goods Input
        </button>
    </div>

    @if(session('status') === 'success')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-4 p-4 text-sm text-green-800 bg-green-50 dark:bg-gray-700 dark:text-green-400 font-medium rounded-lg">
            ✓ Success! The product stock has been successfully added to the branch balance and recorded on the stock card.
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
                    <th scope="col" class="px-4 py-3 w-32 text-center">Initial Stock</th>
                    <th scope="col" class="px-4 py-3 w-32 text-center">Entry Amount</th>
                    <th scope="col" class="px-4 py-3 w-32 text-center">Ending Stock</th>
                    <th scope="col" class="px-4 py-3">Description / Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($histories as $history)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 font-mono text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">{{ $history->reference_number }}</td>
                        <td class="px-4 py-4 text-gray-600 dark:text-gray-300">{{ $history->transaction_date->format('Y-m-d') }}</td>
                        <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white capitalize">{{ $history->product?->product_name }}</td>
                        <td class="px-4 py-4 text-center font-mono text-gray-600 dark:text-gray-300">{{ $history->beginning_stock }}</td>
                        <td class="px-4 py-4 text-center font-mono font-bold text-blue-600 dark:text-blue-400">+{{ $history->quantity }}</td>
                        <td class="px-4 py-4 text-center font-mono font-bold text-gray-900 dark:text-white">{{ $history->ending_stock }}</td>
                        <td class="px-4 py-4 text-gray-500 dark:text-gray-400 text-xs max-w-xs truncate">{{ $history->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                            There is no recorded history of incoming goods at this branch.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
