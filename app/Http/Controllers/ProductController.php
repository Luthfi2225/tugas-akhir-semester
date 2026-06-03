<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        $categories = Category::latest()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $categoryId = $request->category_id;

        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'product_name'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'product_name')->where(function ($query) use ($categoryId) {
                    return $query->where('category_id', $categoryId);
                }),
            ],
            'sku'            => 'required|string|max:100|unique:products,sku',
            'barcode'        => 'nullable|string|max:100|unique:products,barcode',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'unit'           => 'required|string|max:50',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id'    => $request->category_id,
            'product_name'   => $request->product_name,
            'slug'           => Str::slug($request->product_name),
            'sku'            => Str::upper($request->sku),
            'barcode'        => $request->barcode,
            'purchase_price' => $request->purchase_price,
            'selling_price'  => $request->selling_price,
            'unit'           => Str::lower($request->unit),
            'description'    => $request->description,
            'image'          => $imagePath,
            'is_active'      => $request->has('is_active') ? true : false,
        ]);

        $allBranchIds = \App\Models\Branch::pluck('id');

        foreach ($allBranchIds as $bId) {
            \App\Models\Inventory::create([
                'branch_id' => $bId,
                'product_id' => $product->id, // ID produk baru yang baru saja dibuat
                'stock' => 0,
                'minimum_stock' => 5 // Batas aman default
            ]);
        }

        return redirect()->route('products.index')->with('status', 'product-created');
    }

    public function update(Request $request, Product $product)
    {
        $categoryId = $request->category_id;

        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'product_name'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'product_name')->where(function ($query) use ($categoryId) {
                    return $query->where('category_id', $categoryId);
                })->ignore($product->id),
            ],
            'sku'            => ['required', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product->id)],
            'barcode'        => ['nullable', 'string', 'max:100', Rule::unique('products', 'barcode')->ignore($product->id)],
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'unit'           => 'required|string|max:50',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id'    => $request->category_id,
            'product_name'   => $request->product_name,
            'slug'           => Str::slug($request->product_name) . '-' . Str::lower($request->sku),
            'sku'            => Str::upper($request->sku),
            'barcode'        => $request->barcode,
            'purchase_price' => $request->purchase_price,
            'selling_price'  => $request->selling_price,
            'unit'           => Str::lower($request->unit),
            'description'    => $request->description,
            'image'          => $imagePath,
            'is_active'      => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('products.index')->with('status', 'product-updated');
    }

    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('status', 'product-deleted');
    }
}
