<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('No products found. Please run ProductSeeder first.');
            return;
        }

        // Create 30 sample orders
        for ($i = 1; $i <= 30; $i++) {
            $orderType = rand(0, 1) ? 'dinein' : 'takeaway';
            $tableNumber = $orderType === 'dinein' ? rand(1, 20) : null;
            $status = ['pending', 'preparing', 'ready', 'completed', 'cancelled'][rand(0, 4)];

            // Random date within last 30 days
            $createdAt = now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            #$order_number = "ORD01B1M";
            $order = Order::create([
                'order_number' => 'ORD' . strtoupper(Str::random(5)),
                'customer_name' => 'Customer ' . $i,
                'order_type' => $orderType,
                'table_number' => $tableNumber,
                'status' => $status,
                'notes' => rand(0, 1) ? 'Catatan pesanan ' . $i : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Add 1-5 random items to order
            $itemCount = rand(1, 5);
            $totalAmount = 0;

            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $subtotal = $product->price * $quantity;
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);
            }

            // Update order total
            $order->update(['total_amount' => $totalAmount]);
        }

        $this->command->info('Orders seeded successfully!');
    }
}
