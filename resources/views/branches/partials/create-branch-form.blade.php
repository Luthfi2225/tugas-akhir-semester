<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add New Branch') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Please enter the new branch operational data below.') }}
            </p>
        </div>

        <button type="button" @click="branches = 'listBranch'"
                class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md font-medium text-xs uppercase tracking-wider transition ease-in-out duration-150 cursor-pointer">
            {{ __('← Back') }}
        </button>
    </header>

    <form method="POST" action="{{ route('branches.store') }}" class="mt-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="space-y-6">
                <div>
                    <x-input-label for="branch_code" :value="__('Branch Code')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('branch_code')" />
                    </div>
                    <x-text-input id="branch_code" name="branch_code" type="text" class="mt-1 block w-full font-mono uppercase" :value="old('branch_code')" required autofocus placeholder="Example: BRG-01" />
                </div>

                <div>
                    <x-input-label for="branch_name" :value="__('Branch Name')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('branch_name')" />
                    </div>
                    <x-text-input id="branch_name" name="branch_name" type="text" class="mt-1 block w-full capitalize" :value="old('branch_name')" required placeholder="Example: Jayusman Branch" />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="city" :value="__('City')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('city')" />
                    </div>
                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full capitalize" :value="old('city')" required placeholder="Example: Bandung" />
                </div>

                <div>
                    <x-input-label for="phone" :value="__('Phone Number / HP (optional)')" class="dark:text-[#EDEDEC]" />
                    <div class="absolute mt-9.75">
                        <x-input-error :messages="$errors->get('phone')" />
                    </div>
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" placeholder="Example: 08123456789" />
                </div>
            </div>

        </div>

        <div class="space-y-6">
            <div>
                <x-input-label for="address" :value="__('Complete Address')" class="dark:text-[#EDEDEC]" />
                <textarea id="address" name="address" rows="3" required class="mt-1 block w-full min-h-25 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs" placeholder="Enter the complete address of the store branch location here...">{{ old('address') }}</textarea>
                <div class="absolute">
                    <x-input-error :messages="$errors->get('address')"/>
                </div>
            </div>

            <div class="block">
                <label for="is_active_branch" class="inline-flex items-center cursor-pointer">
                    <input id="is_active_branch" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded shadow-xs">
                    <span class="ms-2 text-sm text-gray-600 dark:text-[#EDEDEC]">{{ __('Activate Branch (Branch is directly operational in the system)') }}</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <x-primary-button>
                {{ __('Save Branch') }}
            </x-primary-button>

            @if (session('status') === 'branch-created')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('Cabang berhasil ditambahkan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
