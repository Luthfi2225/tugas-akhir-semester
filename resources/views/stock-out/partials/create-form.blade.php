<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Outgoing/Damaged Goods Input Form</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Reduce warehouse stock due to damaged goods, expiration, or physical loss of the store.</p>
        </div>
        <button type="button" @click="stockOutState = 'list'"
                class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md font-medium text-xs uppercase tracking-wider transition cursor-pointer">
            ← Back
        </button>
    </header>

    <form method="POST" action="{{ route('stock-out.store') }}" class="mt-6 space-y-6">
        @csrf

        <input type="hidden" name="transaction_type" value="out">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-6">
                <div>
                    <x-input-label for="product_id_out" :value="__('Select Product')" />
                    <select id="product_id_out" name="product_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs cursor-pointer">
                        <option value="">-- Search for Product Name --</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}" {{ old('product_id') == $prod->id ? 'selected' : '' }}>
                                {{ strtoupper($prod->sku) }} - {{ ucfirst($prod->product_name) }} ({{ $prod->unit }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="quantity_out" :value="__('Total Quantity Out')" />
                    <x-text-input id="quantity_out" name="quantity" type="number" min="1" class="mt-1 block w-full font-mono" :value="old('quantity')" required placeholder="Enter a positive nominal number" />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="reason" :value="__('Reason for Item Release')" />
                    <select id="reason" name="reason" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs cursor-pointer">
                        <option value="">-- Select Reason for Loss --</option>
                        <option value="damaged" {{ old('reason') == 'damaged' ? 'selected' : '' }}>Damaged (Barang Rusak / Pecah / Cacat)</option>
                        <option value="expired" {{ old('reason') == 'expired' ? 'selected' : '' }}>Expired (Sudah Melewati Kedaluwarsa)</option>
                        <option value="lost" {{ old('reason') == 'lost' ? 'selected' : '' }}>Lost (Hilang Saat Opname / Selisih)</option>
                        <option value="stolen" {{ old('reason') == 'stolen' ? 'selected' : '' }}>Stolen (Dicuri / Tindak Kriminalitas)</option>
                    </select>
                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="transaction_date_out" :value="__('Business Bookkeeping Date')" />
                    <x-text-input id="transaction_date_out" name="transaction_date" type="date" class="mt-1 block w-full font-mono" :value="old('transaction_date', date('Y-m-d'))" required />
                    <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="notes_out" :value="__('Chronology Description / Notes (Optional)')" />
            <textarea id="notes_out" name="notes" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs" placeholder="Example: A milk can was dented after falling from a display rack...">{{ old('notes') }}</textarea>
            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <x-primary-button class="bg-amber-600 hover:bg-amber-500 active:bg-amber-700">
                {{ __('Reduce Warehouse Stock') }}
            </x-primary-button>
        </div>
    </form>
</section>
