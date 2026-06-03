<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Change Branch Data') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Update your branch office operational information below.') }}
            </p>
        </div>

        <button type="button" @click="branches = 'listBranch'; editId = ''; editCode = ''; editName = ''; editCity = ''; editAddress = ''; editPhone = ''; editIsActive = true;"
                class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md font-medium text-xs uppercase tracking-wider transition ease-in-out duration-150 cursor-pointer">
            {{ __('← Kembali') }}
        </button>
    </header>

    <form method="POST" :action="`{{ url('branches') }}/${editId}`" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <input type="hidden" name="edit_id" :value="editId">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="space-y-6">
                <div>
                    <x-input-label for="update_branch_code" :value="__('Branch Code')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('branch_code_update')" />
                    </div>
                    <x-text-input id="update_branch_code" name="branch_code" type="text" class="mt-1 block w-full font-mono uppercase" x-model="editCode" required />
                </div>

                <div>
                    <x-input-label for="update_branch_name" :value="__('Branch Name')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('branch_name_update')" />
                    </div>
                    <x-text-input id="update_branch_name" name="branch_name" type="text" class="mt-1 block w-full capitalize" x-model="editName" required />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="update_city" :value="__('City')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('city_update')" />
                    </div>
                    <x-text-input id="update_city" name="city" type="text" class="mt-1 block w-full capitalize" x-model="editCity" required />
                </div>

                <div>
                    <x-input-label for="update_phone" :value="__('Phone Number / HP')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('phone_update')" />
                    </div>
                    <x-text-input id="update_phone" name="phone" type="text" class="mt-1 block w-full" x-model="editPhone" />
                </div>
            </div>

        </div>

        <div class="space-y-6">
            <div>
                <x-input-label for="update_address" :value="__('Complete Address')" class="dark:text-[#EDEDEC]" />
                <textarea id="update_address" name="address" rows="3" x-model="editAddress" required class="mt-1 block w-full min-h-25 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs"></textarea>
                <div class="absolute">
                    <x-input-error :messages="$errors->get('address_update')" />
                </div>
            </div>

            <div class="block">
                <label for="update_is_active_branch" class="inline-flex items-center cursor-pointer">
                    <input id="update_is_active_branch" name="is_active" type="checkbox" value="1" x-model.boolean="editIsActive" class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded shadow-xs">
                    <span class="ms-2 text-sm text-gray-600 dark:text-[#EDEDEC]">{{ __('Activate Branch (Tick if the branch office is actively operating)') }}</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <x-primary-button>
                {{ __('Update Branch') }}
            </x-primary-button>

            @if (session('status') === 'branch-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('Perubahan berhasil disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
