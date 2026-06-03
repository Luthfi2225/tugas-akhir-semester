<div class="w-full max-h-198 pb-1.75">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Product List</h3>

        <button type="button" @click="products = 'createProduct'"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-md font-semibold text-xs uppercase tracking-widest transition shadow-sm cursor-pointer">
            + Add Products
        </button>
    </div>

    <div class="overflow-y-auto w-full max-h-183">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
            <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3 w-12 text-center">No</th>
                    <th scope="col" class="px-4 py-3 w-20 text-center">Picture</th>
                    <th scope="col" class="px-4 py-3">Product name</th>
                    <th scope="col" class="px-4 py-3 w-28">SKU</th>
                    <th scope="col" class="px-4 py-3 w-32">Category</th>
                    <th scope="col" class="px-4 py-3 w-32 text-right">Selling price</th>
                    <th scope="col" class="px-4 py-3 w-16 text-center">Units</th>
                    <th scope="col" class="px-4 py-3 w-32 text-center">Status</th>
                    <th scope="col" class="px-4 py-3 w-36 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-4 text-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-12 h-12 object-cover rounded-md border dark:border-gray-600 mx-auto shadow-xs">
                            @else
                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-md border dark:border-gray-600 flex items-center justify-center mx-auto">
                                    <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375 0 1 1-.75 0 .375 0 0 1 .75 0Z" />
                                    </svg>
                                </div>
                            @endif
                        </td>

                        <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white capitalize">
                            {{ $product->product_name }}
                        </td>

                        <td class="px-4 py-4 text-gray-600 dark:text-gray-300 font-mono text-xs">
                            {{ $product->sku }}
                        </td>

                        <td class="px-4 py-4 text-gray-600 dark:text-gray-300">
                            {{ $product->category?->category_name ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-right font-medium text-gray-900 dark:text-white">
                            Rp{{ number_format($product->selling_price, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-4 text-center text-gray-600 dark:text-gray-300">
                            {{ $product->unit }}
                        </td>

                        <td class="px-4 py-4 text-center">
                            @if($product->is_active)
                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-400">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-400">Non-Active</span>
                            @endif
                        </td>

                        <td class="px-4 py-4 text-center space-x-3 whitespace-nowrap">
                            <button type="button"
                                    @click="
                                        products = 'updateProduct';
                                        editId = '{{ $product->id }}';
                                        editName = '{{ $product->product_name }}';
                                        editCategoryId = '{{ $product->category_id }}';
                                        editSku = '{{ $product->sku }}';
                                        editBarcode = '{{ $product->barcode }}';
                                        editPurchasePrice = '{{ $product->purchase_price }}';
                                        editSellingPrice = '{{ $product->selling_price }}';
                                        editUnit = '{{ $product->unit }}';
                                        editDescription = `{!! addslashes($product->description) !!}`;
                                        editIsActive = {{ $product->is_active ? 'true' : 'false' }};
                                    "
                                    class="text-blue-600 dark:text-blue-400 hover:underline font-semibold text-xs uppercase tracking-wider cursor-pointer">
                                Edit
                            </button>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        @click="if (confirm('Apakah Anda yakin ingin menghapus produk « {{ $product->product_name }} »?')) $el.closest('form').submit()"
                                        class="text-red-600 dark:text-red-400 hover:underline font-semibold text-xs uppercase tracking-wider cursor-pointer">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                                <span>No product data has been added yet.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
