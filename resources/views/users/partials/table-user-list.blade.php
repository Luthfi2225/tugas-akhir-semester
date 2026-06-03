<div class="w-full max-h-198 pb-1.75">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">System User List</h3>

        <button type="button" @click="users = 'createUser'"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-md font-semibold text-xs uppercase tracking-widest transition shadow-xs cursor-pointer">
            + Add User
        </button>
    </div>

    <div class="overflow-y-auto w-full max-h-183">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
            <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3 w-12 text-center">No</th>
                    <th scope="col" class="px-4 py-3">Full Name</th>
                    <th scope="col" class="px-4 py-3">Email address</th>
                    <th scope="col" class="px-4 py-3 w-36 text-center">Access Rights (Role)</th>
                    <th scope="col" class="px-4 py-3 w-44">Branch Placement</th>
                    <th scope="col" class="px-4 py-3 w-32 text-center">Status</th>
                    <th scope="col" class="px-4 py-3 w-36 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <td class="px-4 py-4 text-center font-medium text-gray-900 dark:text-white">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white capitalize">
                            {{ $user->name }}
                        </td>
                        <td class="px-4 py-4 text-gray-600 dark:text-gray-300 font-mono text-xs">
                            {{ $user->email }}
                        </td>

                        <td class="px-4 py-4 text-center">
                            @if($user->role === 'owner')
                                <span class="px-2 py-1 text-xs font-bold text-purple-800 bg-purple-100 rounded-md dark:bg-purple-900/30 dark:text-purple-400 uppercase">Owner</span>
                            @elseif($user->role === 'manager')
                                <span class="px-2 py-1 text-xs font-bold text-blue-800 bg-blue-100 rounded-md dark:bg-blue-900/30 dark:text-blue-400 uppercase">Manager</span>
                            @elseif($user->role === 'supervisor')
                                <span class="px-2 py-1 text-xs font-bold text-green-800 bg-green-100 rounded-md dark:bg-green-900/30 dark:text-green-400 uppercase">Supervisor</span>
                            @elseif($user->role === 'cashier')
                                <span class="px-2 py-1 text-xs font-bold text-orange-800 bg-orange-100 rounded-md dark:bg-orange-900/30 dark:text-orange-400 uppercase">Cashier</span>
                            @else
                                <span class="px-2 py-1 text-xs font-bold text-zinc-800 bg-zinc-200 rounded-md dark:bg-zinc-700 dark:text-zinc-300 uppercase">Warehouse</span>
                            @endif
                        </td>

                        <td class="px-4 py-4 text-gray-600 dark:text-gray-300">
                            @if($user->role === 'owner')
                                <span class="text-gray-400 italic">Central / Global</span>
                            @else
                                <span class="font-mono font-bold text-xs uppercase text-gray-500">{{ $user->branch?->branch_code }}</span> - <span class="capitalize">{{ $user->branch?->branch_name }}</span>
                            @endif
                        </td>

                        <td class="px-4 py-4 text-center">
                            @if($user->is_active)
                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-400">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-400">Non-Active</span>
                            @endif
                        </td>

                        <td class="px-4 py-4 text-center space-x-3 whitespace-nowrap">
                            @if($user->id !== Auth::id())
                                <button type="button"
                                        @click="
                                            users = 'updateUser';
                                            editId = '{{ $user->id }}';
                                            editName = '{{ $user->name }}';
                                            editEmail = '{{ $user->email }}';
                                            editRole = '{{ $user->role }}';
                                            editBranchId = '{{ $user->branch_id ?? '' }}';
                                            editIsActive = {{ $user->is_active ? 'true' : 'false' }};
                                        "
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-semibold text-xs uppercase tracking-wider cursor-pointer">
                                    Edit
                                </button>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            @click="if (confirm('Apakah Anda yakin ingin menghapus akun « {{ $user->name }} »?')) $el.closest('form').submit()"
                                            class="text-red-600 dark:text-red-400 hover:underline font-semibold text-xs uppercase tracking-wider cursor-pointer">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">Your account</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                            There is no operational data for registered minimarket system users yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
