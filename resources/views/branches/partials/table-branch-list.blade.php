<div class="w-full max-h-198 pb-1.75">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Branch List</h3>

        <button type="button" @click="branches = 'createBranch'"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-md font-semibold text-xs uppercase tracking-widest transition shadow-xs cursor-pointer">
            + Add Branch
        </button>
    </div>

    <div class="overflow-y-auto w-full max-h-168">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
            <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3 w-12 text-center">No</th>
                    <th scope="col" class="px-4 py-3 w-32">Branch Code</th>
                    <th scope="col" class="px-4 py-3">Branch Name</th>
                    <th scope="col" class="px-4 py-3 w-36">City</th>
                    <th scope="col" class="px-4 py-3">Address</th>
                    <th scope="col" class="px-4 py-3 w-36">Phone number</th>
                    <th scope="col" class="px-4 py-3 w-32 text-center">Status</th>
                    <th scope="col" class="px-4 py-3 w-36 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($branches as $branch)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-4 font-mono text-xs text-gray-600 dark:text-gray-300 font-bold uppercase">
                            {{ $branch->branch_code }}
                        </td>

                        <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white capitalize">
                            {{ $branch->branch_name }}
                        </td>

                        <td class="px-4 py-4 text-gray-600 dark:text-gray-300 capitalize">
                            {{ $branch->city }}
                        </td>

                        <td class="px-4 py-4 text-gray-600 dark:text-gray-300 max-w-xs truncate">
                            {{ $branch->address }}
                        </td>

                        <td class="px-4 py-4 text-gray-600 dark:text-gray-300">
                            {{ $branch->phone ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-center">
                            @if($branch->is_active)
                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-400">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-400">Non-Active</span>
                            @endif
                        </td>

                        <td class="px-4 py-4 text-center space-x-3 whitespace-nowrap">
                            <button type="button"
                                    @click="
                                        branches = 'updateBranch';
                                        editId = '{{ $branch->id }}';
                                        editCode = '{{ $branch->branch_code }}';
                                        editName = '{{ $branch->branch_name }}';
                                        editCity = '{{ $branch->city }}';
                                        editAddress = `{!! addslashes($branch->address) !!}`;
                                        editPhone = '{{ $branch->phone }}';
                                        editIsActive = {{ $branch->is_active ? 'true' : 'false' }};
                                    "
                                    class="text-blue-600 dark:text-blue-400 hover:underline font-semibold text-xs uppercase tracking-wider cursor-pointer">
                                Edit
                            </button>

                            <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        @click="if (confirm('Apakah Anda yakin ingin menghapus cabang « {{ $branch->branch_name }} »?')) $el.closest('form').submit()"
                                        class="text-red-600 dark:text-red-400 hover:underline font-semibold text-xs uppercase tracking-wider cursor-pointer">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.5a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                                </svg>
                                <span>No store branch data has been added yet.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
