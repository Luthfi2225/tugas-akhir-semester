<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryHistorySeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();
        $products = Product::all();

        foreach ($branches as $branch) {

            foreach ($products as $product) {

                $qty = rand(50, 100);

                DB::table('inventory_histories')->insert([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,

                    'user_id' => User::inRandomOrder()->first()?->id,

                    'quantity' => $qty,

                    'beginning_stock' => 0,

                    'ending_stock' => $qty,

                    'type' => 'stock_in',

                    'reference_number' => 'STIN-' . now()->format('Ymd') . '-' . rand(1000, 9999),

                    'notes' => '',

                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
