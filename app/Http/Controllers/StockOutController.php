<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StockOutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // if (!$user->isWarehouse()) { abort(403); }

        $histories = InventoryHistory::with('product')
            ->where('branch_id', $user->branch_id)
            ->where('type', 'stock_out')
            ->latest()
            ->get();

        $products = Product::where('is_active', true)->latest()->get();

        return view('stock-out.index', compact('histories', 'products'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isWarehouse()) { abort(403); }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|in:damaged,expired,lost,stolen',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $inventory = Inventory::where('branch_id', $user->branch_id)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$inventory || $inventory->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok di cabang Anda tidak mencukupi untuk dikeluarkan.'])->withInput();
        }

        DB::transaction(function () use ($request, $user, $inventory) {
            $beginningStock = $inventory->stock;
            $endingStock = $beginningStock - $request->quantity;

            $inventory->update(['stock' => $endingStock]);

            InventoryHistory::create([
                'branch_id' => $user->branch_id,
                'product_id' => $request->product_id,
                'user_id' => $user->id,
                'quantity' => -$request->quantity,
                'beginning_stock' => $beginningStock,
                'ending_stock' => $endingStock,
                'type' => 'stock_out',
                'reason' => $request->reason,
                'reference_number' => 'STKO-' . strtoupper(Str::random(8)),
                'notes' => $request->notes,
                'transaction_date' => $request->transaction_date,
            ]);
        });

        return redirect()->route('stock-out.index')->with('status', 'success');
    }
}
