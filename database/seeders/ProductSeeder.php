<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Makanan
            ['category_id' => 1, 'name' => 'MIE IBLIS', 'price' => 10500.00, 'stock' => 100],
            ['category_id' => 1, 'name' => 'MIE ANGEL', 'price' => 10500.00, 'stock' => 100],
            ['category_id' => 1, 'name' => 'Gurami Goreng', 'price' => 45000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'Gurami Bakar', 'price' => 48000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'Pepes Gurami', 'price' => 42000.00, 'stock' => 50],
            // Minuman
            ['category_id' => 2, 'name' => 'ES TEKLEK', 'price' => 7500.00, 'stock' => 100],
            ['category_id' => 2, 'name' => 'ES SLUKU BATHOK', 'price' => 8500.00, 'stock' => 100],
            ['category_id' => 2, 'name' => 'ES GOBAK SODOR', 'price' => 9545.00, 'stock' => 100],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
