<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add New Products') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Fill in the detailed information below to register a new item into the system.') }}
            </p>
        </div>

        <button type="button" @click="products = 'listProduct'"
                class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md font-medium text-xs uppercase tracking-wider transition ease-in-out duration-150 cursor-pointer">
            {{ __('← Back') }}
        </button>
    </header>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="space-y-6">
                <div>
                    <x-input-label for="product_name" :value="__('Product name')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('product_name')" />
                    </div>
                    <x-text-input id="product_name" name="product_name" type="text" class="mt-1 block w-full" :value="old('product_name')" required autofocus autocomplete="off" placeholder="Enter the product name..." />
                </div>

                <div>
                    <x-input-label for="category_id" :value="__('Category')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('category_id')" />
                    </div>
                    <select id="category_id" name="category_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs cursor-pointer">
                        <option value="">-- Select Category --</option>
                        @foreach($categories->whereNotNull('parent_id') as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ ucfirst($cat->category_name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="sku" :value="__('SKU (Stock Keeping Unit)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('sku')" />
                    </div>
                    <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full font-mono uppercase" :value="old('sku')" required placeholder="Example: KMJ-FLN-01" />
                </div>

                <div>
                    <x-input-label for="barcode" :value="__('Barcode (Optional)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('barcode')" />
                    </div>
                    <x-text-input id="barcode" name="barcode" type="text" class="mt-1 block w-full" :value="old('barcode')" placeholder="Enter the item barcode number..." />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="purchase_price" :value="__('Purchase Price (Rp)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('purchase_price')" />
                    </div>
                    <x-text-input id="purchase_price" name="purchase_price" type="number" min="0" class="mt-1 block w-full" :value="old('purchase_price')" required placeholder="Enter the purchase price from the supplier" />
                </div>

                <div>
                    <x-input-label for="selling_price" :value="__('Selling Price (Rp)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('selling_price')" />
                    </div>
                    <x-text-input id="selling_price" name="selling_price" type="number" min="0" class="mt-1 block w-full" :value="old('selling_price')" required placeholder="Enter the consumer selling price" />
                </div>

                <div>
                    <x-input-label for="unit" :value="__('Unit')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('unit')" />
                    </div>
                    <x-text-input id="unit" name="unit" type="text" class="mt-1 block w-full" :value="old('unit', 'pcs')" required placeholder="Examples: pcs, box, pack" />
                </div>

                <div>
                    <x-input-label for="image" :value="__('Product Photos (Max 2MB)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('image')" />
                    </div>
                    <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:my-1 file:py-2 file:px-4 file:rounded-md file:border file:border-gray-300 dark:file:border-gray-600 file:text-xs file:font-semibold file:bg-gray-100 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-200 dark:hover:file:bg-gray-600 cursor-pointer file:cursor-pointer" />
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <x-input-label for="description" :value="__('Product Description')" class="dark:text-[#EDEDEC]" />
                <div class="absolute mt-9.75">
                    <x-input-error :messages="$errors->get('description')" />
                </div>
                <textarea id="description" name="description" rows="3" class="mt-1 block w-full min-h-50 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs" placeholder="Enter product description or specifications here...">{{ old('description') }}</textarea>
            </div>

            <div class="block">
                <label for="is_active" class="inline-flex items-center cursor-pointer">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded shadow-xs">
                    <span class="ms-2 text-sm text-gray-600 dark:text-[#EDEDEC]">{{ __('Activate Products (Products can be searched and sold)') }}</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <x-primary-button>
                {{ __('Save Product') }}
            </x-primary-button>

            @if (session('status') === 'product-created')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('Product added successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>
