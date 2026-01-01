<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Admin WBS',
                'email' => 'admin@wbs.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'Kasir WBS',
                'email' => 'kasir@wbs.com',
                'password' => bcrypt('password'),
                'role' => 'cashier',
                'is_active' => true,
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
