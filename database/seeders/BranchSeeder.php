<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [

            [
                'branch_code' => 'CBG001',
                'branch_name' => 'Jayusman Mart Banjar',
                'city' => 'Banjar',
                'address' => 'Jl. Letjen Suwarto No. 10',
                'phone' => '0265741111',
            ],

            [
                'branch_code' => 'CBG002',
                'branch_name' => 'Jayusman Mart Tasikmalaya',
                'city' => 'Tasikmalaya',
                'address' => 'Jl. HZ Mustofa No. 25',
                'phone' => '0265332222',
            ],

            [
                'branch_code' => 'CBG003',
                'branch_name' => 'Jayusman Mart Ciamis',
                'city' => 'Ciamis',
                'address' => 'Jl. Jenderal Sudirman No. 8',
                'phone' => '0265773333',
            ],

            [
                'branch_code' => 'CBG004',
                'branch_name' => 'Jayusman Mart Bandung',
                'city' => 'Bandung',
                'address' => 'Jl. Asia Afrika No. 15',
                'phone' => '0227444444',
            ],

            [
                'branch_code' => 'CBG005',
                'branch_name' => 'Jayusman Mart Garut',
                'city' => 'Garut',
                'address' => 'Jl. Ahmad Yani No. 12',
                'phone' => '0262555555',
            ],

        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
