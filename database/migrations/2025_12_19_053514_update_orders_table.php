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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number', 50)->unique()->after('id');
            $table->string('customer_name')->after('order_number');
            $table->enum('order_type', ['dinein', 'takeaway'])->after('customer_name');
            $table->string('table_number', 20)->nullable()->after('order_type');
            $table->decimal('discount', 10, 2)->default(0.00)->after('table_number');
            $table->decimal('total_amount', 10, 2)->default(0.00)->after('discount');
            $table->enum('status', ['pending', 'preparing', 'ready', 'completed', 'cancelled'])->default('pending')->after('total_amount');
            $table->text('notes')->nullable()->after('status');

            $table->index('order_number', 'idx_order_number');
            $table->index('status', 'idx_status');
            $table->index('order_type', 'idx_order_type');
            $table->index('created_at', 'idx_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_order_number');
            $table->dropIndex('idx_status');
            $table->dropIndex('idx_order_type');
            $table->dropIndex('idx_created_at');

            $table->dropColumn([
                'order_number',
                'customer_name',
                'order_type',
                'table_number',
                'discount',
                'total_amount',
                'status',
                'notes'
            ]);
        });
    }
};
