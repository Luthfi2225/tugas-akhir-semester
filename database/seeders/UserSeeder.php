<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Jayusman',
            'email' => 'jayusmansangowner@gmail.com',
            'role' => 'owner',
            'branch_id' => null,
            'password' => Hash::make('123456789'),
            'is_active' => true,
        ]);

        foreach (Branch::all() as $branch) {

            User::create([
                'name' => 'Manager ' . $branch->city,
                'email' => 'manager.' . strtolower($branch->city) . '@gmail.com',
                'role' => 'manager',
                'branch_id' => $branch->id,
                'password' => Hash::make('123456789'),
                'is_active' => true,
            ]);

            User::create([
                'name' => 'Supervisor ' . $branch->city,
                'email' => 'supervisor.' . strtolower($branch->city) . '@gmail.com',
                'role' => 'supervisor',
                'branch_id' => $branch->id,
                'password' => Hash::make('123456789'),
                'is_active' => true,
            ]);

            User::create([
                'name' => 'Cashier ' . $branch->city,
                'email' => 'cashier.' . strtolower($branch->city) . '@gmail.com',
                'role' => 'cashier',
                'branch_id' => $branch->id,
                'password' => Hash::make('123456789'),
                'is_active' => true,
            ]);

            User::create([
                'name' => 'Warehouse ' . $branch->city,
                'email' => 'warehouse.' . strtolower($branch->city) . '@gmail.com',
                'role' => 'warehouse',
                'branch_id' => $branch->id,
                'password' => Hash::make('123456789'),
                'is_active' => true,
            ]);
        }
    }
}
