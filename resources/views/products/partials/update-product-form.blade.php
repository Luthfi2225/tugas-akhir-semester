<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Change Product Details') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Update your product details below.') }}
            </p>
        </div>

        <button type="button" @click="products = 'listProduct'; editId = ''; editName = ''; editCategoryId = ''; editSku = ''; editBarcode = ''; editPurchasePrice = ''; editSellingPrice = ''; editUnit = 'pcs'; editDescription = ''; editIsActive = true;"
                class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md font-medium text-xs uppercase tracking-wider transition ease-in-out duration-150 cursor-pointer">
            {{ __('← Back') }}
        </button>
    </header>

    <form method="POST" :action="`{{ url('products') }}/${editId}`" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <input type="hidden" name="edit_id" :value="editId">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="space-y-6">
                <div>
                    <x-input-label for="update_product_name" :value="__('Product name')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('product_name')" />
                    </div>
                    <x-text-input id="update_product_name" name="product_name" type="text" class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black" x-model="editName" required autocomplete="off" />
                </div>

                <div>
                    <x-input-label for="update_category_id" :value="__('Category')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('category_id')" />
                    </div>
                    <select id="update_category_id" name="category_id" x-model="editCategoryId" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs cursor-pointer">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ ucfirst($cat->category_name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="update_sku" :value="__('SKU (Stock Keeping Unit)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('sku')" />
                    </div>
                    <x-text-input id="update_sku" name="sku" type="text" class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black font-mono uppercase" x-model="editSku" required />
                </div>

                <div>
                    <x-input-label for="update_barcode" :value="__('Barcode (Optional)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('barcode')" />
                    </div>
                    <x-text-input id="update_barcode" name="barcode" type="text" class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black" x-model="editBarcode" />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="update_purchase_price" :value="__('Purchase Price (Rp)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('purchase_price')" />
                    </div>
                    <x-text-input id="update_purchase_price" name="purchase_price" type="number" min="0" step="0.01" class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black" x-model="editPurchasePrice" required />
                </div>

                <div>
                    <x-input-label for="update_selling_price" :value="__('Selling Price (Rp)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('selling_price')" />
                    </div>
                    <x-text-input id="update_selling_price" name="selling_price" type="number" min="0" step="0.01" class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black" x-model="editSellingPrice" required />
                </div>

                <div>
                    <x-input-label for="update_unit" :value="__('Unit')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('unit')" />
                    </div>
                    <x-text-input id="update_unit" name="unit" type="text" class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black" x-model="editUnit" required />
                </div>

                <div>
                    <x-input-label for="update_image" :value="__('Change Product Photo (Max 2MB)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('image')" />
                    </div>
                    <input id="update_image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600 cursor-pointer" />
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <x-input-label for="update_description" :value="__('Product Description')" class="dark:text-[#EDEDEC]" />
                <textarea id="update_description" name="description" rows="3" x-model="editDescription" class="mt-1 block w-full min-h-50 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs" placeholder="Enter product description or specifications here..."></textarea>
                <div class="absolute">
                    <x-input-error :messages="$errors->get('description')" />
                </div>
            </div>

            <div class="block">
                <label for="update_is_active" class="inline-flex items-center cursor-pointer">
                    <input id="update_is_active" name="is_active" type="checkbox" value="1" x-model.boolean="editIsActive" class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 shadow-xs focus:ring-indigo-500">
                    <span class="ms-2 text-sm dark:text-gray-300">{{ __('Activate Product (Tick if the item is ready to be marketed)') }}</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <x-primary-button>
                {{ __('Update Products') }}
            </x-primary-button>

            @if (session('status') === 'product-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('Changes saved successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>
