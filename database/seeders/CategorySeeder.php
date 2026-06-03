<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $foodBeverage = Category::create([
            'category_name' => 'Food & Beverage (F&B)',
            'slug' => 'food-beverage-fb',
        ]);

        $nonFood = Category::create([
            'category_name' => 'Non-Food / General Merchandise (GMS)',
            'slug' => 'non-food-general-merchandise-gms',
        ]);



        Category::create([
            'category_name' => 'Makanan Pokok',
            'slug' => 'makanan-pokok',
            'parent_id' => $foodBeverage->id,
        ]);

        Category::create([
            'category_name' => 'Makanan Ringan & Manisan',
            'slug' => 'makanan-ringan-manisan',
            'parent_id' => $foodBeverage->id,
        ]);

        Category::create([
            'category_name' => 'Minuman',
            'slug' => 'minuman',
            'parent_id' => $foodBeverage->id,
        ]);



        Category::create([
            'category_name' => 'Kebutuhan Rumah Tangga',
            'slug' => 'kebutuhan-rumah-tangga',
            'parent_id' => $nonFood->id,
        ]);

        Category::create([
            'category_name' => 'Perawatan Tubuh',
            'slug' => 'perawatan-tubuh',
            'parent_id' => $nonFood->id,
        ]);

        Category::create([
            'category_name' => 'Kesehatan & Obat Bebas',
            'slug' => 'kesehatan-obat-bebas',
            'parent_id' => $nonFood->id,
        ]);

        Category::create([
            'category_name' => 'Ibu & Bayi',
            'slug' => 'ibu-bayi',
            'parent_id' => $nonFood->id,
        ]);

        Category::create([
            'category_name' => 'Kebutuhan Sehari-hari Lainnya',
            'slug' => 'kebutuhan-sehari-hari-lainnya',
            'parent_id' => $nonFood->id,
        ]);
    }
}
