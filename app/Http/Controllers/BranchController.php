<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->get();
        return view('branches.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_code' => 'required|string|max:50|unique:branches,branch_code',
            'branch_name' => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'address'     => 'required|string',
            'phone'       => 'nullable|string|max:20',
        ]);

        Branch::create([
            'branch_code' => Str::upper($request->branch_code),
            'branch_name' => $request->branch_name,
            'city'        => Str::lower($request->city),
            'address'     => $request->address,
            'phone'       => $request->phone,
            'is_active'   => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('branches.index')->with('status', 'branch-created');
    }

    public function update(Request $request, Branch $branch)
    {
        $validator = \Validator::make($request->all(), [
            'branch_code' => ['required', 'string', 'max:50', Rule::unique('branches', 'branch_code')->ignore($branch->id)],
            'branch_name' => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'address'     => 'required|string',
            'phone'       => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->messages() as $key => $messages) {
                $errors[$key . '_update'] = $messages[0];
            }

            return back()->withErrors($errors)->withInput();
        }

        $branch->update([
            'branch_code' => Str::upper($request->branch_code),
            'branch_name' => Str::lower($request->branch_name),
            'city'        => Str::lower($request->city),
            'address'     => $request->address,
            'phone'       => $request->phone,
            'is_active'   => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('branches.index')->with('status', 'branch-updated');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('status', 'branch-deleted');
    }
}
