<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\InventoryHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// 1. Deklarasi State (Variabel Reaktif)
state([
    'search' => '',
    'cart' => [],
    'discount' => '',
    'taxPercent' => 11,
    'paymentMethod' => 'cash',
    'paidAmount' => ''
]);

// 2. Fungsi Hitung Total (Computed Property) - Ditampung kembali ke variabel namun dengan closure yang benar
$totals = computed(function () {
    $subtotal = collect($this->cart)->sum('subtotal');
    $tax = ($subtotal - (float)$this->discount) * ($this->taxPercent / 100);
    $totalAmount = ($subtotal - (float)$this->discount) + $tax;
    return [
        'subtotal'     => $subtotal,
        'tax'          => $tax,
        'total_amount' => $totalAmount < 0 ? 0 : $totalAmount,
    ];
});

// 3. Fungsi Mengambil Data Produk Berdasarkan Pencarian (Computed Property)
$products = computed(function () {
    $user = Auth::user();
    // Menggunakan variabel lokal penampung teks pencarian kasir
    $keyword = $this->search;

    return Inventory::where('branch_id', $user->branch_id)
        ->whereHas('product', function($query) use ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('product_name', 'like', '%' . $keyword . '%')
                  ->orWhere('sku', 'like', '%' . $keyword . '%');
            })->where('is_active', true);
        })
        ->with('product')
        ->take(8)
        ->get();
});

// 4. Fungsi Aksi Keranjang Belanja
$addToCart = function ($productId) {
    $user = Auth::user();
    $inventory = Inventory::where('branch_id', $user->branch_id)->where('product_id', $productId)->with('product')->first();

    if (!$inventory || $inventory->stock <= 0) {
        session()->flash('error', 'Gagal! Stok produk kosong.');
        return;
    }

    if (array_key_exists($productId, $this->cart)) {
        if ($this->cart[$productId]['quantity'] >= $inventory->stock) {
            session()->flash('error', 'Gagal! Melebihi batas stok.');
            return;
        }
        $this->cart[$productId]['quantity']++;
        $this->cart[$productId]['subtotal'] = $this->cart[$productId]['quantity'] * $this->cart[$productId]['unit_price'];
    } else {
        $this->cart[$productId] = [
            'product_id'     => $productId,
            'product_name'   => $inventory->product->product_name,
            'sku'            => $inventory->product->sku,
            'purchase_price' => $inventory->product->purchase_price,
            'unit_price'     => $inventory->product->selling_price,
            'quantity'       => 1,
            'subtotal'       => $inventory->product->selling_price,
        ];
    }
};

$decreaseQuantity = function ($productId) {
    if (array_key_exists($productId, $this->cart)) {
        if ($this->cart[$productId]['quantity'] > 1) {
            $this->cart[$productId]['quantity']--;
            $this->cart[$productId]['subtotal'] = $this->cart[$productId]['quantity'] * $this->cart[$productId]['unit_price'];
        } else {
            unset($this->cart[$productId]);
        }
    }
};

$removeFromCart = function ($productId) {
    unset($this->cart[$productId]);
};

// 5. Fungsi Simpan Transaksi (Checkout)
$checkout = function () {
    $user = Auth::user();
    if (empty($this->cart)) { session()->flash('error', 'Keranjang kosong.'); return; }

    // Memanggil properti computed totals menggunakan $this
    $calculated = $this->totals;
    if ((float)$this->paidAmount < $calculated['total_amount']) {
        session()->flash('error', 'Gagal! Uang pembayaran kurang.');
        return;
    }

    DB::transaction(function () use ($user, $calculated) {
        $invoiceNumber = 'TRX-' . $user->branch_id . '-' . date('YmdHis');

        $transaction = Transaction::create([
            'invoice_number'   => $invoiceNumber,
            'branch_id'        => $user->branch_id,
            'user_id'          => $user->id,
            'subtotal'         => $calculated['subtotal'],
            'discount'         => (float)$this->discount,
            'tax'              => $calculated['tax'],
            'total_amount'     => $calculated['total_amount'],
            'payment_method'   => $this->paymentMethod,
            'paid_amount'      => (float)$this->paidAmount,
            'change_amount'    => (float)$this->paidAmount - $calculated['total_amount'],
            'transaction_date' => now(),
        ]);

        foreach ($this->cart as $item) {
            $inventory = Inventory::where('branch_id', $user->branch_id)->where('product_id', $item['product_id'])->first();
            $beginningStock = $inventory->stock;
            $endingStock = $beginningStock - $item['quantity'];

            $inventory->update(['stock' => $endingStock]);

            InventoryHistory::create([
                'branch_id'        => $user->branch_id,
                'product_id'       => $item['product_id'],
                'user_id'          => $user->id,
                'quantity'         => -$item['quantity'],
                'beginning_stock'  => $beginningStock,
                'ending_stock'     => $endingStock,
                'type'             => 'sales_pos',
                'reason'           => 'none',
                'reference_number' => $invoiceNumber,
                'notes'            => 'Penjualan Kasir POS',
                'transaction_date' => now(),
            ]);

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $item['product_id'],
                'quantity'       => $item['quantity'],
                'purchase_price' => $item['purchase_price'],
                'unit_price'     => $item['unit_price'],
                'subtotal'       => $item['subtotal'],
            ]);
        }
    });

    session()->flash('success', 'Transaksi Kasir Berhasil Disimpan!');
    $this->cart = []; $this->discount = 0; $this->paidAmount = 0; $this->search = '';
};
?>



<!-- ========================================================================= -->
<!-- AREA KODE VISUAL BLADE KASIR (HTML) -->
<!-- ========================================================================= -->
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Grid Utama Kasir: 2 Kolom di Layar Lebar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- ========================================================================== -->
        <!-- SISI KIRI: PENCARIAN & KATALOG PRODUK (7 Kolom) -->
        <!-- ========================================================================== -->
        <div class="lg:col-span-7 space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">🛒 Aplikasi Kasir POS</h3>

                <!-- Kotak Input Pencarian Reaktif (Menggunakan wire:model.live) -->
                <div class="relative mb-6">
                    <!-- PERBAIKAN: Mengubah inset-s-0 menjadi start-0 -->
                    <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-0A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text"
                            wire:model.live.debounce.300ms="search"
                            class="block w-full ps-10 pr-4 py-2.5 text-sm text-gray-900 border border-gray-300 rounded-md bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            placeholder="Ketik nama produk atau scan SKU barang di sini...">
                </div>

                <!-- Tampilan Katalog Hasil Pencarian Barang -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @forelse($this->products as $inv)
                        <!-- Kotak Produk Yang Bisa Diklik -->
                        <!-- PERBAIKAN: Menambahkan transition-colors untuk efek hover halus -->
                        <div wire:click="addToCart({{ $inv->product_id }})"
                                class="group flex flex-col justify-between p-4 bg-gray-50 hover:bg-indigo-50 dark:bg-gray-700 dark:hover:bg-gray-600/70 border border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer transition-colors select-none shadow-xs">
                            <div>
                                <div class="flex justify-between items-start gap-1">
                                    <span class="text-[10px] font-mono font-bold uppercase text-gray-400 group-hover:text-indigo-500">{{ $inv->product?->sku }}</span>
                                    <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-sm bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300">Stok: {{ $inv->stock }}</span>
                                </div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white capitalize mt-1 line-clamp-2">{{ $inv->product?->product_name }}</h4>
                            </div>
                            <div class="text-sm font-extrabold text-indigo-600 dark:text-indigo-400 mt-3">
                                Rp{{ number_format($inv->product?->selling_price, 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-10 text-center text-sm text-gray-500 italic">
                            Barang tidak ditemukan atau stok kosong di cabang ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SISI KANAN: RINGKASAN NOTA KERANJANG (5 Kolom) -->
        <!-- ========================================== -->
        <div class="lg:col-span-5 space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <h3 class="text-base font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-3 mb-4">🧾 Struk Keranjang Belanja</h3>

                <!-- TAMPILAN JIKA ADA ERROR / SUKSES DI FLASHSESSION -->
                @if (session()->has('error'))
                    <div class="p-3 mb-4 text-xs text-red-800 bg-red-50 dark:bg-gray-700 dark:text-red-400 font-medium rounded-md flex items-center justify-between">
                        <span>⚠️ {{ session('error') }}</span>
                        <button type="button" @click="$el.closest('div').remove()">✕</button>
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="p-3 mb-4 text-xs text-green-800 bg-green-50 dark:bg-gray-700 dark:text-green-400 font-medium rounded-md">
                        🎉 {{ session('success') }}
                    </div>
                @endif

                <!-- DAFTAR ITEM DI DALAM KERANJANG -->
                <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-85 overflow-y-auto pr-1">
                    @forelse($cart as $id => $item)
                        <div class="py-3 flex justify-between items-center gap-2">
                            <div class="flex-1">
                                <h5 class="text-sm font-bold text-gray-900 dark:text-white capitalize">{{ $item['product_name'] }}</h5>
                                <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">@Rp{{ number_format($item['unit_price'], 0, ',', '.') }}</span>
                            </div>
                            <!-- Tombol Pengatur Kuantitas (+ / -) -->
                            <div class="flex items-center gap-2">
                                <button type="button" wire:click="decreaseQuantity({{ $id }})" class="w-6 h-6 flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-600 dark:text-white font-bold text-xs cursor-pointer">-</button>
                                <span class="text-sm font-bold text-gray-900 dark:text-white w-6 text-center font-mono">{{ $item['quantity'] }}</span>
                                <button type="button" wire:click="addToCart({{ $id }})" class="w-6 h-6 flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-600 dark:text-white font-bold text-xs cursor-pointer">+</button>
                            </div>
                            <div class="text-sm font-bold text-gray-900 dark:text-white text-right w-24 font-mono">
                                Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center text-sm text-gray-400 italic">
                            Keranjang kosong. Klik produk di sebelah kiri.
                        </div>
                    @endforelse
                </div>

                <!-- NOTA RINCIAN BIAYA & FINANSIAL -->
                <div class="border-t border-gray-100 dark:border-gray-700 mt-4 pt-4 space-y-2 text-sm text-gray-600 dark:text-gray-400 font-medium">
                    <div class="flex justify-between">
                        <span>Subtotal Barang:</span>
                        <span class="font-mono text-gray-900 dark:text-white">Rp{{ number_format($this->totals['subtotal'], 0, ',', '.') }}</span>
                    </div>

                    <!-- Input Potongan Diskon Manual oleh Kasir -->
                    <div class="flex justify-between items-center gap-4 py-1">
                        <span>Potongan Diskon (Rp):</span>
                        <input type="number" min="0" wire:model.live="discount" class="w-32 py-1 px-2 text-xs rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white font-mono font-bold" placeholder="0">
                    </div>

                    <div class="flex justify-between">
                        <span>PPN ({{ $taxPercent }}%):</span>
                        <span class="font-mono text-gray-900 dark:text-white">Rp{{ number_format($this->totals['tax'], 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between border-t border-dashed border-gray-200 dark:border-gray-600 pt-2 text-base font-extrabold text-gray-900 dark:text-white">
                        <span>TOTAL AKHIR:</span>
                        <span class="font-mono text-indigo-600 dark:text-indigo-400 text-lg">Rp{{ number_format($this->totals['total_amount'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- PROSES METODE BAYAR & INPUT UANG KONSUMEN -->
                <!-- ========================================== -->
                <div class="border-t border-gray-100 dark:border-gray-700 mt-4 pt-4 space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-input-label :value="__('Metode Bayar')" />
                            <select wire:model.live="paymentMethod" class="mt-1 block w-full py-1.5 text-xs border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md cursor-pointer">
                                <option value="cash">💵 CASH (Tunai)</option>
                                <option value="qris">📱 QRIS / E-Wallet</option>
                                <option value="debit">💳 KARTU DEBIT</option>
                                <option value="credit">💳 KARTU KREDIT</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label :value="__('Uang Dibayar (Rp)')" />
                            <input type="number" wire:model.live="paidAmount" min="0" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md font-mono font-bold" placeholder="{{ $this->totals['total_amount'] }}">
                        </div>
                    </div>

                    <!-- Hitung Kembalian Uang Konsumen Otomatis -->
                    <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg text-sm font-bold">
                        <span class="text-gray-600 dark:text-gray-400">UANG KEMBALIAN:</span>
                        <span class="font-mono text-base {{ ((float)$paidAmount - $this->totals['total_amount']) < 0 ? 'text-red-500' : 'text-green-600 dark:text-green-400' }}">
                            @if(((float)$paidAmount - $this->totals['total_amount']) < 0)
                                Rp0 (Uang Kurang)
                            @else
                                Rp{{ number_format((float)$paidAmount - $this->totals['total_amount'], 0, ',', '.') }}
                            @endif
                        </span>
                    </div>

                    <!-- Tombol Konfirmasi Pembayaran Selesai -->
                    <button type="button"
                            wire:click="checkout"
                            wire:loading.attr="disabled"
                            class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 disabled:bg-gray-400 text-white rounded-lg font-bold text-sm uppercase tracking-widest transition shadow-md flex items-center justify-center gap-2 cursor-pointer">
                        <span wire:loading.remove>🔒 Selesaikan Transaksi</span>
                        <span wire:loading class="animate-spin inline-block w-4 h-4 border-2 border-current border-t-transparent rounded-full"></span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
