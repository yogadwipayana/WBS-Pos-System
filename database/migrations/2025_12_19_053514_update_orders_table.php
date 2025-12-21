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
            $table->foreignId('user_id')->nullable()->after('order_number')->constrained()->onDelete('set null');
            $table->string('customer_name')->after('user_id');
            $table->string('customer_phone', 20)->nullable()->after('customer_name');
            $table->enum('order_type', ['dinein', 'takeaway'])->after('customer_phone');
            $table->string('table_number', 20)->nullable()->after('order_type');
            $table->decimal('discount', 10, 2)->default(0.00)->after('table_number');
            $table->decimal('total_amount', 10, 2)->default(0.00)->after('discount');
            $table->enum('status', ['pending', 'preparing', 'ready', 'completed', 'cancelled'])->default('pending')->after('total_amount');
            $table->text('notes')->nullable()->after('status');
            
            $table->index('order_number', 'idx_order_number');
            $table->index('user_id', 'idx_user');
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
            $table->dropIndex('idx_user');
            $table->dropIndex('idx_status');
            $table->dropIndex('idx_order_type');
            $table->dropIndex('idx_created_at');
            
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'order_number',
                'user_id',
                'customer_name',
                'customer_phone',
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
