<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Change Category') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Please update your category name below.') }}
            </p>
        </div>

        <button type="button" @click="categories = 'listCategory'; editId = ''; editName = ''; editParentId = '';"
                class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md font-medium text-xs uppercase tracking-wider transition ease-in-out duration-150 cursor-pointer">
            {{ __('← Back') }}
        </button>
    </header>

    <form method="POST" :action="`{{ url('categories') }}/${editId}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}`" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <input type="hidden" name="edit_id" :value="editId">

        <div>
            <x-input-label for="update_name" :value="__('Category Name')" class="dark:text-[#EDEDEC]" />

            <div class="absolute mt-9.75">
                <x-input-error :messages="$errors->get('category_name_update')" />
            </div>

            <x-text-input id="update_name"
                          name="category_name"
                          type="text"
                          class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black"
                          x-model="editName"
                          required
                          autocomplete="off"
                          placeholder="Enter category name..." />
        </div>

        @if (request()->has('sub-category') && !request()->has('main-category'))
            <div>
                <x-input-label for="parent_id" :value="__('Main Categories')" class="dark:text-[#EDEDEC]" />

                <select name="parent_id" x-model="editParentId" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs"
                        style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236b7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E'); background-size: 1.5em 1.5em; background-position: right 0.20rem center;">
                    @foreach($cat as $category)
                        <option value="{{ $category->id }}" class="bg-gray-200 dark:bg-gray-800">
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Update Category') }}
            </x-primary-button>

            @if (session('status') === 'category-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('Berhasil diperbarui.') }}
                </p>
            @endif
        </div>
    </form>
</section>
