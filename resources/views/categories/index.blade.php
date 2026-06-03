<x-app-layout>
    <x-slot name="header">
        {{ __('Categories') }}
    </x-slot>

    <div class="mt-12 max-h-210">
        <div x-data="{
                categories: Alpine.$persist('listCategory'),
                editId: '{{ $errors->has('category_name_update') ? old('edit_id') : '' }}' || Alpine.$persist(''),
                editName: '{{ $errors->has('category_name_update') ? old('category_name') : '' }}' || Alpine.$persist(''),
                editParentId: '{{ $errors->has('category_name_update') ? old('parent_id') : '' }}' || Alpine.$persist('')
            }"
            x-init="
                if ('{{ session('status') }}' === 'category-created' || '{{ session('status') }}' === 'category-updated' || '{{ session('status') }}' === 'category-deleted') {
                    categories = 'listCategory';
                    editId = ''; editName = ''; editParentId = '';
                } else if ({{ $errors->has('category_name_update') ? 'true' : 'false' }}) {
                    categories = 'updateCategory';
                } else if ({{ $errors->has('category_name') ? 'true' : 'false' }}) {
                    categories = 'createCategory';
                }
            "
            class="w-300"
        >

            <div x-show="categories === 'listCategory'" class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('categories.partials.table-category-list')
                </div>
            </div>

            <div x-show="categories === 'createCategory'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('categories.partials.create-category-form')
                </div>
            </div>

            <div x-show="categories === 'updateCategory'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('categories.partials.update-category-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
