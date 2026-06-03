<div class="w-full max-h-198 pb-1.75">
    <div class="flex justify-between items-center">
        <div class="flex justify-start mb-4">
            <a href="?main-category" wire:navigate class="flex items-center px-4 py-2 text-start text-base font-medium text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out {{ request()->has('main-category') && !request()->has('sub-category') ? 'border-b-4 border-gray-400 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 rounded-t-md' : 'border-none bg-none dark:bg-none' }}">
                {{ __('Main Category') }}
            </a>

            <a href="?sub-category" wire:navigate class="flex items-center px-4 py-2 text-start text-base font-medium text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out {{ request()->has('sub-category') && !request()->has('main-category') ? 'border-b-4 border-gray-400 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 rounded-t-md' : 'border-none bg-none dark:bg-none' }}">
                {{ __('Sub Category') }}
            </a>
        </div>

        <div class="flex justify-between gap-10 mb-4">
            @if (session('status') === 'category-created' || session('status') === 'category-updated' || session('status') === 'category-deleted')
                <div x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="px-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400 font-medium flex items-center justify-between shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 me-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>
                            @if (session('status') === 'category-created') Kategori baru berhasil ditambahkan! @endif
                            @if (session('status') === 'category-updated') Data kategori berhasil diperbarui! @endif
                            @if (session('status') === 'category-deleted') Kategori berhasil dihapus! @endif
                        </span>
                    </div>
                    <button @click="show = false" class="ml-4 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200 cursor-pointer">✕</button>
                </div>
            @endif
            <div></div>
            <button type="button" @click="categories = 'createCategory'" class="bg-blue-600 hover:bg-blue-700 font-semibold text-xs tracking-widest text-white px-3.25 py-2.25 rounded-md cursor-pointer">
                @if (request()->has('main-category'))
                    {{ __('+ ADD MAIN CATEGORY') }}
                @else
                    {{ __('+ ADD SUB CATEGORY') }}
                @endif
            </button>
        </div>
    </div>

    <div class="overflow-y-auto w-full max-h-168">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
            <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 w-16 text-center">No</th>
                    <th scope="col" class="px-6 py-3">Category Name</th>
                    @if (request()->has('sub-category') && !request()->has('main-category'))
                        <th scope="col" class="px-6 py-3">Main Category</th>
                    @endif
                    <th scope="col" class="px-6 py-3">Created At</th>
                    <th scope="col" class="px-6 py-3">Updated At</th>
                    <th scope="col" class="px-6 py-3 text-center w-40">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $category)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $category->category_name }}
                        </td>
                        @if (request()->has('sub-category') && !request()->has('main-category'))
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $category->parent?->category_name ?? 'Unkown Main Category' }}
                            </td>
                        @endif
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $category->created_at }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $category->updated_at }}
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <button type="button" @click="categories = 'updateCategory'; editId = '{{ $category->id }}'; editName = '{{ $category->category_name }}'; editParentId = '{{ $category->parent_id }}'"
                                    class="text-blue-600 dark:text-blue-400 hover:underline font-semibold text-xs uppercase cursor-pointer">
                                Edit
                            </button>

                            <form action="{{ route('categories.destroy', $category->id) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                                <button type="button"
                                        @click="if (confirm('Apakah Anda yakin ingin menghapus kategori « {{ $category->category_name }} »? Semua sub-kategori di dalamnya juga akan terpengaruh.')) $el.closest('form').submit()"
                                        class="text-red-600 dark:text-red-400 hover:underline font-semibold text-xs uppercase cursor-pointer">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td colspan="{{ request()->has('main-category') && !request()->has('sub-category') ? 5 : 6 }}" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <!-- Ikon folder kosong minimalis -->
                                <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.008 1.24l.885 1.77a2.25 2.25 0 0 0 2.007 1.24h1.98a2.25 2.25 0 0 0 2.007-1.24l.885-1.77a2.25 2.25 0 0 1 2.007-1.24h3.86m-18 1.5h18m-18-9.75A2.25 2.25 0 0 1 3.5 3h5.788a2.25 2.25 0 0 1 1.588.658l1.248 1.248a2.25 2.25 0 0 0 1.588.658H20.5A2.25 2.25 0 0 1 22.75 7.5v9a2.25 2.25 0 0 1-2.25 2.25H3.5A2.25 2.25 0 0 1 1.25 16.5v-9A2.25 2.25 0 0 1 3.5 5.25h1.125" />
                                </svg>
                                <span>No categories have been added yet.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
