<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StockInController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // if (!$user->isWarehouse()) { abort(403, 'Hanya untuk Warehouse.'); }

        $histories = InventoryHistory::with('product')
            ->where('branch_id', $user->branch_id)
            ->where('type', 'stock_in')
            ->latest()
            ->get();

        $products = Product::where('is_active', true)->latest()->get();

        return view('stock-in.index', compact('histories', 'products'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isWarehouse()) { abort(403); }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $user) {
            $inventory = Inventory::where('branch_id', $user->branch_id)
                ->where('product_id', $request->product_id)
                ->first();

            $beginningStock = $inventory ? $inventory->stock : 0;
            $endingStock = $beginningStock + $request->quantity;

            Inventory::updateOrCreate(
                ['branch_id' => $user->branch_id, 'product_id' => $request->product_id],
                ['stock' => $endingStock]
            );

            InventoryHistory::create([
                'branch_id' => $user->branch_id,
                'product_id' => $request->product_id,
                'user_id' => $user->id,
                'quantity' => $request->quantity,
                'beginning_stock' => $beginningStock,
                'ending_stock' => $endingStock,
                'type' => 'stock_in',
                'reason' => 'none', // Stock In tidak membutuhkan alasan kerusakan
                'reference_number' => 'STKI-' . strtoupper(Str::random(8)),
                'notes' => $request->notes,
                'transaction_date' => $request->transaction_date,
            ]);
        });

        return redirect()->route('stock-in.index')->with('status', 'success');
    }
}
