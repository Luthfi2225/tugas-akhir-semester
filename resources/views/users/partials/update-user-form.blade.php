<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Change User Data</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Adjust system access authority information or update operational password.</p>
        </div>

        <button type="button" @click="users = 'listUser'; editId = ''; editName = ''; editEmail = ''; editRole = ''; editBranchId = ''; editIsActive = true;"
                class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md font-medium text-xs uppercase tracking-wider transition cursor-pointer">
            {{ __('← Back') }}
        </button>
    </header>

    <form method="POST" :action="`{{ url('users') }}/${editId}`" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <input type="hidden" name="edit_id" :value="editId">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-6">
                <div>
                    <x-input-label for="update_name" :value="__('Full name')" />
                    <x-text-input id="update_name" name="name" type="text" class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black" x-model="editName" required />
                </div>
                <div>
                    <x-input-label for="update_email" :value="__('Email address')" />
                    <x-text-input id="update_email" name="email" type="email" class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black" x-model="editEmail" required />
                </div>
                <div>
                    <x-input-label for="update_password" :value="__('Change Password (Optional)')" />
                    <x-text-input id="update_password" name="password" type="password" class="mt-1 block w-full dark:bg-[#3a3a3a] dark:border-black" placeholder="Leave blank if you don't want to change it." />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="update_role" :value="__('Access Rights (Role)')" />
                    <select id="update_role" name="role" x-model="editRole" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs cursor-pointer">
                        <option value="">-- Select Access Rights --</option>
                        @if(Auth::user()->isOwner())
                            <option value="owner">Owner</option>
                            <option value="manager">Manager</option>
                        @endif
                        <option value="supervisor">Supervisor</option>
                        <option value="cashier">Cashier</option>
                        <option value="warehouse">Warehouse</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="update_branch_id" :value="__('Branch Store Placement')" />
                    @if(Auth::user()->isOwner())
                        <select id="update_branch_id" name="branch_id" x-model="editBranchId" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs cursor-pointer">
                            <option value="">None (Primary Owner Account Only)</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}">{{ strtoupper($b->branch_code) }} - {{ ucfirst($b->branch_name) }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                        <x-text-input type="text" class="mt-1 block w-full dark:bg-gray-700 cursor-not-allowed dark:text-gray-300" value="{{ strtoupper(Auth::user()->branch?->branch_code ?? '') }} - {{ ucfirst(Auth::user()->branch?->branch_name ?? '') }}" disabled />
                    @endif
                </div>

                <div class="block mt-14.5">
                    <label for="update_is_active_user" class="inline-flex items-center cursor-pointer">
                        <input id="update_is_active_user" name="is_active" type="checkbox" value="1" x-model.boolean="editIsActive" class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded shadow-xs cursor-pointer">
                        <span class="ms-2 text-sm text-gray-600 dark:text-[#EDEDEC]">Authorize Active Account Status</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <x-primary-button>{{ __('Update User') }}</x-primary-button>
            <x-input-error :messages="$errors->get('user_name_update')" class="mt-2" />
        </div>
    </form>
</section>
