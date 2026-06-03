<x-app-layout>
    <x-slot name="header">
        {{ __('Users Management') }}
    </x-slot>

    <div class="mt-12 max-h-210">
        <div x-data="{
                users: Alpine.$persist('listUser'),
                editId: '{{ $errors->has('user_name_update') ? old('edit_id') : '' }}' || Alpine.$persist(''),
                editName: '{{ $errors->has('user_name_update') ? old('name') : '' }}' || Alpine.$persist(''),
                editEmail: '{{ $errors->has('user_name_update') ? old('email') : '' }}' || Alpine.$persist(''),
                editRole: '{{ $errors->has('user_name_update') ? old('role') : '' }}' || Alpine.$persist(''),
                editBranchId: '{{ $errors->has('user_name_update') ? old('branch_id') : '' }}' || Alpine.$persist(''),
                editIsActive: {{ $errors->has('user_name_update') ? (old('is_active') ? 'true' : 'false') : 'true' }} || Alpine.$persist(true)
             }"
             x-init="
                if ('{{ session('status') }}' === 'user-created' || '{{ session('status') }}' === 'user-updated' || '{{ session('status') }}' === 'user-deleted') {
                    users = 'listUser';
                    editId = ''; editName = ''; editEmail = ''; editRole = ''; editBranchId = ''; editIsActive = true;
                } else if ({{ $errors->has('user_name_update') ? 'true' : 'false' }}) {
                    users = 'updateUser';
                } else if ({{ $errors->has('name') || $errors->has('email') || $errors->has('password') ? 'true' : 'false' }}) {
                    users = 'createUser';
                }
             "
             class="w-300">

            <div x-show="users === 'listUser'" class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                @include('users.partials.table-user-list')
            </div>

            <div x-show="users === 'createUser'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                @include('users.partials.create-user-form')
            </div>

            <div x-show="users === 'updateUser'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                @include('users.partials.update-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
