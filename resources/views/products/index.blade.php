<x-app-layout>
    <x-slot name="header">
        {{ __('Products') }}
    </x-slot>

    <div class="mt-12 max-h-210">
        <div x-data="{
                products: Alpine.$persist('listProduct'),
                editId: '{{ $errors->has('product_name_update') ? old('edit_id') : '' }}' || Alpine.$persist(''),
                editName: '{{ $errors->has('product_name_update') ? old('product_name') : '' }}' || Alpine.$persist(''),
                editCategoryId: '{{ $errors->has('product_name_update') ? old('category_id') : '' }}' || Alpine.$persist(''),
                editSku: '{{ $errors->has('product_name_update') ? old('sku') : '' }}' || Alpine.$persist(''),
                editBarcode: '{{ $errors->has('product_name_update') ? old('barcode') : '' }}' || Alpine.$persist(''),
                editPurchasePrice: '{{ $errors->has('product_name_update') ? old('purchase_price') : '' }}' || Alpine.$persist(''),
                editSellingPrice: '{{ $errors->has('product_name_update') ? old('selling_price') : '' }}' || Alpine.$persist(''),
                editUnit: '{{ $errors->has('product_name_update') ? old('unit') : 'pcs' }}' || Alpine.$persist('pcs'),
                editDescription: '{{ $errors->has('product_name_update') ? old('description') : '' }}' || Alpine.$persist(''),
                editIsActive: {{ $errors->has('product_name_update') ? (old('is_active') ? 'true' : 'false') : 'true' }} || Alpine.$persist(true)
             }"
             x-init="
                if ('{{ session('status') }}' === 'product-created' || '{{ session('status') }}' === 'product-updated' || '{{ session('status') }}' === 'product-deleted') {
                    products = 'listProduct';
                } else if ({{ $errors->has('product_name_update') ? 'true' : 'false' }}) {
                    products = 'updateProduct';
                } else if ({{ $errors->has('product_name') || $errors->has('sku') || $errors->has('barcode') || $errors->has('purchase_price') || $errors->has('selling_price') || $errors->has('image') ? 'true' : 'false' }}) {
                    products = 'createProduct';
                }
             "
             class="w-300">

            <!-- 1. Memanggil partials tabel untuk menampilkan data produk -->
            <div x-show="products === 'listProduct'" class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('products.partials.table-product-list')
                </div>
            </div>

            <!-- 2. Memanggil partials form tambah produk -->
            <div x-show="products === 'createProduct'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('products.partials.create-product-form')
                </div>
            </div>

            <!-- 3. Memanggil partials form edit produk -->
            <div x-show="products === 'updateProduct'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('products.partials.update-product-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
