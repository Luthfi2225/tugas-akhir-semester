<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->isOwner()) {
            $users = User::with('branch')->latest()->get();
            $branches = Branch::where('is_active', true)->latest()->get();
        } elseif ($currentUser->isManager()) {
            $users = User::with('branch')
                ->where('branch_id', $currentUser->branch_id)
                ->where('role', '!=', 'owner')
                ->latest()
                ->get();
            $branches = Branch::where('id', $currentUser->branch_id)->get();
        } else {
            abort(403, 'Akses ditolak.');
        }

        return view('users.index', compact('users', 'branches'));
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();

        $allowedRoles = $currentUser->isOwner()
            ? ['owner', 'manager', 'supervisor', 'cashier', 'warehouse']
            : ['supervisor', 'cashier', 'warehouse'];

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8',
            'role'      => ['required', Rule::in($allowedRoles)],
            'branch_id' => $currentUser->isOwner() ? 'nullable|exists:branches,id' : 'required|exists:branches,id',
        ]);

        $branchId = $currentUser->isOwner() ? $request->branch_id : $currentUser->branch_id;

        if ($request->role === 'owner') {
            $branchId = null;
        }

        User::create([
            'branch_id' => $branchId,
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('users.index')->with('status', 'user-created');
    }

    public function update(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->isManager() && ($user->role === 'owner' || $user->branch_id !== $currentUser->branch_id)) {
            abort(403, 'Akses ilegal.');
        }

        $allowedRoles = $currentUser->isOwner()
            ? ['owner', 'manager', 'supervisor', 'cashier', 'warehouse']
            : ['supervisor', 'cashier', 'warehouse'];

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password'  => 'nullable|string|min:8',
            'role'      => ['required', Rule::in($allowedRoles)],
            'branch_id' => $currentUser->isOwner() ? 'nullable|exists:branches,id' : 'required|exists:branches,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['user_name_update' => $validator->errors()->first()])->withInput();
        }

        $branchId = $currentUser->isOwner() ? $request->branch_id : $currentUser->branch_id;
        if ($request->role === 'owner') { $branchId = null; }

        $updateData = [
            'branch_id' => $branchId,
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('status', 'user-updated');
    }

    public function destroy(User $user)
    {
        $currentUser = Auth::user();
        if ($currentUser->isManager() && $user->role === 'owner') { abort(403); }

        $user->delete();
        return redirect()->route('users.index')->with('status', 'user-deleted');
    }
}
