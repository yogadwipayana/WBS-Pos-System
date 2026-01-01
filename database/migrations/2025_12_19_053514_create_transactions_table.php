<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('transaction_number', 50)->unique();
            $table->enum('payment_method', ['cash', 'qris']);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->decimal('amount', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('order_id', 'idx_order');
            $table->index('transaction_number', 'idx_transaction_number');
            $table->index('payment_status', 'idx_payment_status');
            $table->index('payment_method', 'idx_payment_method');
            $table->index('created_at', 'idx_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
