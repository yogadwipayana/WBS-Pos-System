<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Makanan
            ['category_id' => 1, 'name' => 'AYAM GORENG', 'price' => 10500.00, 'stock' => 100],
            ['category_id' => 1, 'name' => 'AYAM BAKAR', 'price' => 10500.00, 'stock' => 100],
            ['category_id' => 1, 'name' => 'AYAM PENYET', 'price' => 42000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'GURAMI GORENG', 'price' => 10500.00, 'stock' => 100],
            ['category_id' => 1, 'name' => 'PEPES GURAMI', 'price' => 45000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'GURAMI NYAT-NYAT', 'price' => 48000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'GURAMI BAKAR', 'price' => 42000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'SUP GURAMI', 'price' => 42000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'SUP PATIN', 'price' => 42000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'NILA GORENG', 'price' => 42000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'CUMI ASAM MANIS', 'price' => 42000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'FUYUNG HAI', 'price' => 42000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'CUMI GORENG TEPUNG', 'price' => 42000.00, 'stock' => 50],
            ['category_id' => 1, 'name' => 'GURAMI ASAM MANIS', 'price' => 42000.00, 'stock' => 50],
            // Minuman
            ['category_id' => 2, 'name' => 'ES TEH', 'price' => 7500.00, 'stock' => 100],
            ['category_id' => 2, 'name' => 'SODA GEMBIRA', 'price' => 7500.00, 'stock' => 100],
            ['category_id' => 2, 'name' => 'ES JERUK', 'price' => 7500.00, 'stock' => 100],
            ['category_id' => 2, 'name' => 'TEH BOTOL', 'price' => 7500.00, 'stock' => 100],
            ['category_id' => 2, 'name' => 'ES KELAPA MUDA', 'price' => 7500.00, 'stock' => 100],
            // Snack
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
