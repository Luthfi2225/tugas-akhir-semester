<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();
        $products = Product::all();

        foreach ($branches as $branch) {

            foreach ($products as $product) {

                DB::table('inventories')->insert([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,

                    'stock' => rand(20, 150),

                    'minimum_stock' => 5,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
