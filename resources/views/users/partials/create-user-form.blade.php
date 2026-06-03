<section>
    <header class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Add New User</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Register a new minimarket system operator account.</p>
        </div>
        <button type="button" @click="users = 'listUser'" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md font-medium text-xs uppercase tracking-wider transition cursor-pointer">← Back</button>
    </header>

    <form method="POST" action="{{ route('users.store') }}" class="mt-6 space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-6">
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autocomplete="off" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required placeholder="Minimum 8 characters" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="role" :value="__('Access Rights (Role)')" />
                    <select id="role" name="role" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs cursor-pointer">
                        <option value="">-- Select Access Rights --</option>
                        @if(Auth::user()->isOwner())
                            <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner (Pemilik)</option>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager (Kepala Cabang)</option>
                        @endif
                        <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor (Pengawas toko)</option>
                        <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier (Kasir Utama)</option>
                        <option value="warehouse" {{ old('role') == 'warehouse' ? 'selected' : '' }}>Warehouse (Petugas Gudang)</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')"/>
                </div>

                <div>
                    <x-input-label for="branch_id" :value="__('Branch Store Placement')" />
                    @if(Auth::user()->isOwner())
                        <select id="branch_id" name="branch_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-xs cursor-pointer">
                            <option value="">None (Primary Owner Account Only)</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}" {{ old('branch_id') == $b->id ? 'selected' : '' }}>{{ strtoupper($b->branch_code) }} - {{ ucfirst($b->branch_name) }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                        <x-text-input type="text" class="mt-1 block w-full cursor-not-allowed text-gray-500" value="{{ strtoupper(Auth::user()->branch?->branch_code) }} - {{ ucfirst(Auth::user()->branch?->branch_name) }}" disabled />
                    @endif
                    <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                </div>

                <div class="block mt-14.5">
                    <label for="is_active_user" class="inline-flex items-center cursor-pointer">
                        <input id="is_active_user" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded shadow-xs cursor-pointer">
                        <span class="ms-2 text-sm text-gray-600 dark:text-[#EDEDEC]">Activate Live Account</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <x-primary-button>{{ __('Save User') }}</x-primary-button>
        </div>
    </form>
</section>
