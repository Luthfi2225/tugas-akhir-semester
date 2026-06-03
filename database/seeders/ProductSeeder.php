<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            [
                'category' => 'Minuman',
                'name' => 'Aqua 600ml',
                'sku' => 'PRD000001',
                'barcode' => '899276111001',
                'purchase_price' => 2500,
                'selling_price' => 3500,
                'unit' => 'botol',
            ],

            [
                'category' => 'Minuman',
                'name' => 'Teh Botol Sosro',
                'sku' => 'PRD000002',
                'barcode' => '899276111002',
                'purchase_price' => 3500,
                'selling_price' => 5000,
                'unit' => 'botol',
            ],

            [
                'category' => 'Makanan Pokok',
                'name' => 'Indomie Goreng',
                'sku' => 'PRD000003',
                'barcode' => '899276111003',
                'purchase_price' => 2800,
                'selling_price' => 3500,
                'unit' => 'pcs',
            ],

            [
                'category' => 'Makanan Ringan & Manisan',
                'name' => 'Chitato Sapi Panggang',
                'sku' => 'PRD000004',
                'barcode' => '899276111004',
                'purchase_price' => 8000,
                'selling_price' => 10000,
                'unit' => 'pcs',
            ],

            [
                'category' => 'Perawatan Tubuh',
                'name' => 'Lifebuoy Merah 80gr',
                'sku' => 'PRD000005',
                'barcode' => '899276111005',
                'purchase_price' => 4000,
                'selling_price' => 5500,
                'unit' => 'pcs',
            ],

            [
                'category' => 'Kesehatan & Obat Bebas',
                'name' => 'Paracetamol Strip',
                'sku' => 'PRD000006',
                'barcode' => '899276111006',
                'purchase_price' => 2500,
                'selling_price' => 4000,
                'unit' => 'strip',
            ],

            [
                'category' => 'Ibu & Bayi',
                'name' => 'Sweety Silver Pants M',
                'sku' => 'PRD000007',
                'barcode' => '899276111007',
                'purchase_price' => 45000,
                'selling_price' => 55000,
                'unit' => 'pack',
            ],

            [
                'category' => 'Kebutuhan Rumah Tangga',
                'name' => 'Sunlight Jeruk Nipis',
                'sku' => 'PRD000008',
                'barcode' => '899276111008',
                'purchase_price' => 7000,
                'selling_price' => 9000,
                'unit' => 'pouch',
            ],

        ];

        foreach ($products as $item) {

            $category = Category::where(
                'category_name',
                $item['category']
            )->first();

            Product::create([
                'category_id' => $category->id,
                'product_name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'sku' => $item['sku'],
                'barcode' => $item['barcode'],
                'purchase_price' => $item['purchase_price'],
                'selling_price' => $item['selling_price'],
                'unit' => $item['unit'],
                'description' => null,
                'is_active' => true,
            ]);
        }
    }
}
