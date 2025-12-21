<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin::truncate();
        // User::truncate();
        // Category::truncate();
        // Product::truncate();
        // Order::truncate();
        // OrderItem::truncate();

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
        ]);
    }
}
