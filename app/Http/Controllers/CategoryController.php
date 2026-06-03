<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $cat = Category::whereNull('parent_id')->latest()->get();

        if ($request->has('sub-category')) {
            $categories = Category::whereNotNull('parent_id')->with('parent')->latest()->get();
        }
        elseif ($request->has('main-category')) {
            $categories = Category::whereNull('parent_id')->latest()->get();
        }

        return view('categories.index', compact('categories', 'cat'));
    }

    public function store(Request $request)
    {
        if($request->has('main-category')) {
            $parentId = null;
            $param = ['main-category' => ''];
        } else {
            $parentId = $request->parent_id;
            $param = ['sub-category' => ''];
        }

        $slug = Str::slug($request->category_name);

        $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name')->where(function ($query) use ($parentId) {
                    return $query->where('parent_id', $parentId);
                }),
            ],
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'parent_id' => $parentId,
            'slug' => $slug
        ]);

        return redirect()->route('categories.index', $param)->with('status', 'category-created');
    }

    public function update(Request $request, Category $category)
    {
        if($request->has('main-category')) {
            $parentId = null;
            $param = ['main-category' => ''];
        } else {
            $parentId = $request->parent_id;
            $param = ['sub-category' => ''];
        }

        $slug = \Str::slug($request->category_name);

        $validator = \Validator::make($request->all(), [
            'parent_id' => 'nullable|exists:categories,id',
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name')->where(function ($query) use ($parentId) {
                        return $query->where('parent_id', $parentId);
                    })->ignore($category->id),
            ],
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['category_name_update' => $validator->errors()->first()])
                         ->withInput();
        }

        $category->update([
            'category_name' => $request->category_name,
            'parent_id' => $parentId,
            'slug' => $slug,
        ]);

        return redirect()->route('categories.index', $param)->with('status', 'category-updated');
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        if ($request->has('main-category')) {
            return redirect()->route('categories.index', ['main-category'])->with('status', 'category-deleted');
        } else {
            return redirect()->route('categories.index', ['sub-category'])->with('status', 'category-deleted');
        }
    }
}
