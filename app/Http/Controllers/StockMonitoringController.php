<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockMonitoringController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isOwner()) {
            $stocks = Inventory::with(['branch', 'product'])->latest()->get();
        } else {
            $stocks = Inventory::with(['branch', 'product'])
                ->where('branch_id', $user->branch_id)
                ->latest()
                ->get();
        }

        return view('stock-monitoring.index', compact('stocks'));
    }
}
