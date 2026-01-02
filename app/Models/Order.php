<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'order_type',
        'table_number',
        'discount',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get order items for this order
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the transaction for this order
     */
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }
}
