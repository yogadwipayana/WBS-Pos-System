<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all orders
        $orders = Order::all();

        if ($orders->isEmpty()) {
            $this->command->info('No orders found. Please run OrderSeeder first.');
            return;
        }

        $paymentMethods = ['cash', 'qris'];
        $paymentStatuses = ['pending', 'paid', 'failed'];

        foreach ($orders as $order) {
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];

            // Generate unique transaction number
            $transactionNumber = 'TRX' . date('Ymd') . str_pad($order->id, 6, '0', STR_PAD_LEFT);

            Transaction::create([
                'order_id' => $order->id,
                'transaction_number' => $transactionNumber,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'amount' => $order->total_amount,
                'notes' => $paymentStatus === 'pending' ? 'Menunggu konfirmasi pembayaran' : ($paymentStatus === 'paid' ? 'Pembayaran berhasil' : 'Pembayaran gagal'),
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        }

        $this->command->info('Transactions seeded successfully!');
    }
}
