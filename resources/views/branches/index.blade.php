<x-app-layout>
    <x-slot name="header">
        {{ __('Branches') }}
    </x-slot>

    <div class="mt-12 max-h-210 overflow-y-auto">
        <div x-data="{
                branches: Alpine.$persist('listBranch'),
                editId: '{{ $errors->has('branch_name_update') || $errors->has('branch_code_update') ? old('edit_id') : '' }}' || Alpine.$persist(''),
                editCode: '{{ $errors->has('branch_name_update') || $errors->has('branch_code_update') ? old('branch_code') : '' }}' || Alpine.$persist(''),
                editName: '{{ $errors->has('branch_name_update') || $errors->has('branch_code_update') ? old('branch_name') : '' }}' || Alpine.$persist(''),
                editCity: '{{ $errors->has('branch_name_update') || $errors->has('branch_code_update') ? old('city') : '' }}' || Alpine.$persist(''),
                editAddress: '{{ $errors->has('branch_name_update') || $errors->has('branch_code_update') ? old('address') : '' }}' || Alpine.$persist(''),
                editPhone: '{{ $errors->has('branch_name_update') || $errors->has('branch_code_update') ? old('phone') : '' }}' || Alpine.$persist(''),
                editIsActive: {{ $errors->has('branch_name_update') || $errors->has('branch_code_update') ? (old('is_active') ? 'true' : 'false') : 'true' }} || Alpine.$persist(true)
             }"
             x-init="
                if ('{{ session('status') }}' === 'branch-created' || '{{ session('status') }}' === 'branch-updated' || '{{ session('status') }}' === 'branch-deleted') {
                    branches = 'listBranch';
                    editId = ''; editCode = ''; editName = ''; editCity = ''; editAddress = ''; editPhone = ''; editIsActive = true;
                } else if ({{ $errors->has('branch_code_update') || $errors->has('branch_name_update') || $errors->has('city_update') || $errors->has('address_update') ? 'true' : 'false' }}) {
                    branches = 'updateBranch';
                } else if ({{ $errors->has('branch_code') || $errors->has('branch_name') || $errors->has('city') || $errors->has('address') ? 'true' : 'false' }}) {
                    branches = 'createBranch';
                }
             "
             class="w-300">

            <div x-show="branches === 'listBranch'" class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('branches.partials.table-branch-list')
                </div>
            </div>

            <div x-show="branches === 'createBranch'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('branches.partials.create-branch-form')
                </div>
            </div>

            <div x-show="branches === 'updateBranch'" x-cloak class="p-4 sm:p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="w-full">
                    @include('branches.partials.update-branch-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
