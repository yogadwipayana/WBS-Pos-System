<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create category
        $category = Category::create([
            'name' => 'Food'
        ]);

        // Create test products
        Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 10000,
            'stock' => 10
        ]);
    }

    public function test_stock_decreases_after_order_creation()
    {
        $product = Product::first();
        $initialStock = $product->stock;

        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD-TEST-001',
            'customer_name' => 'Test Customer',
            'order_type' => 'dinein',
            'table_number' => '5',
            'total_amount' => 20000,
            'items' => [
                [
                    'product_name' => 'Test Product',
                    'quantity' => 2
                ]
            ]
        ]);

        $response->assertStatus(201);
        
        $product->refresh();
        $this->assertEquals($initialStock - 2, $product->stock);
    }

    public function test_order_fails_when_insufficient_stock()
    {
        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD-TEST-002',
            'customer_name' => 'Test Customer',
            'order_type' => 'takeaway',
            'total_amount' => 200000,
            'items' => [
                [
                    'product_name' => 'Test Product',
                    'quantity' => 100 // More than available stock
                ]
            ]
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false
        ]);
        $response->assertJsonFragment(['message']);
    }

    public function test_order_fails_when_product_not_found()
    {
        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD-TEST-003',
            'customer_name' => 'Test Customer',
            'order_type' => 'dinein',
            'total_amount' => 10000,
            'items' => [
                [
                    'product_name' => 'Non Existent Product',
                    'quantity' => 1
                ]
            ]
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'success' => false
        ]);
    }
}
