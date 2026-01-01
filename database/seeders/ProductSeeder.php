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
            ['category_id' => 1, 'name' => 'AYAM GORENG', 'price' => 21000.00, 'stock' => 100, 'image' => 'ayam-goreng.webp'],
            ['category_id' => 1, 'name' => 'AYAM BAKAR', 'price' => 23000.00, 'stock' => 100, 'image' => 'ayam-bakar.webp'],
            ['category_id' => 1, 'name' => 'AYAM PENYET', 'price' => 25000.00, 'stock' => 50, 'image' => 'ayam-penyet.webp'],
            ['category_id' => 1, 'name' => 'GURAMI GORENG', 'price' => 25000.00, 'stock' => 100, 'image' => 'gurami-goreng.webp'],
            ['category_id' => 1, 'name' => 'PEPES GURAMI', 'price' => 30000.00, 'stock' => 50, 'image' => 'pepes-gurami.webp'],
            ['category_id' => 1, 'name' => 'GURAMI NYAT-NYAT', 'price' => 25000.00, 'stock' => 50, 'image' => 'gurami-nyat-nyat.webp'],
            ['category_id' => 1, 'name' => 'GURAMI BAKAR', 'price' => 30000.00, 'stock' => 50, 'image' => 'gurami-bakar.webp'],
            ['category_id' => 1, 'name' => 'GURAMI ASAM MANIS', 'price' => 30000.00, 'stock' => 50, 'image' => 'gurami-asam-manis.webp'],
            ['category_id' => 1, 'name' => 'SUP GURAMI', 'price' => 25000.00, 'stock' => 50, 'image' => 'sup-gurami.webp'],
            ['category_id' => 1, 'name' => 'SUP PATIN', 'price' => 20000.00, 'stock' => 50, 'image' => 'sup-patin.webp'],
            ['category_id' => 1, 'name' => 'NILA GORENG', 'price' => 30000.00, 'stock' => 50, 'image' => 'nila-goreng.webp'],
            ['category_id' => 1, 'name' => 'CUMI ASAM MANIS', 'price' => 25000.00, 'stock' => 50, 'image' => 'cumi-asam-manis.webp'],
            ['category_id' => 1, 'name' => 'CUMI GORENG TEPUNG', 'price' => 20000.00, 'stock' => 50, 'image' => 'cumi-goreng-tepung.webp'],
            ['category_id' => 1, 'name' => 'FUYUNG HAI', 'price' => 25000.00, 'stock' => 50, 'image' => 'fuyung-hai.webp'],
            // Minuman
            ['category_id' => 2, 'name' => 'ES TEH', 'price' => 5000.00, 'stock' => 100, 'image' => 'es-teh.webp'],
            ['category_id' => 2, 'name' => 'SODA GEMBIRA', 'price' => 8000.00, 'stock' => 100, 'image' => 'soda-gembira.webp'],
            ['category_id' => 2, 'name' => 'ES JERUK', 'price' => 5000.00, 'stock' => 100, 'image' => 'es-jeruk.webp'],
            ['category_id' => 2, 'name' => 'TEH BOTOL', 'price' => 5000.00, 'stock' => 100, 'image' => 'teh-botol.webp'],
            ['category_id' => 2, 'name' => 'ES KELAPA MUDA', 'price' => 15000.00, 'stock' => 100, 'image' => 'es-kelapa-muda.webp'],
            // Snack
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
