<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create category and product for testing
        $category = Category::create(['name' => 'Food']);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 10000,
            'stock' => 100
        ]);

        // Create admin
        Admin::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password')
        ]);
    }

    public function test_order_validation_fails_without_required_fields()
    {
        $response = $this->postJson('/api/order', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'order_number',
            'customer_name',
            'order_type',
            'total_amount',
            'items'
        ]);
    }

    public function test_order_validation_fails_with_invalid_order_type()
    {
        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD-001',
            'customer_name' => 'Test',
            'order_type' => 'invalid_type',
            'total_amount' => 10000,
            'items' => [
                ['product_name' => 'Test Product', 'quantity' => 1]
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('order_type');
    }

    public function test_order_validation_fails_with_negative_quantity()
    {
        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD-002',
            'customer_name' => 'Test',
            'order_type' => 'dinein',
            'total_amount' => 10000,
            'items' => [
                ['product_name' => 'Test Product', 'quantity' => -1]
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('items.0.quantity');
    }

    public function test_order_validation_fails_with_excessive_quantity()
    {
        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD-003',
            'customer_name' => 'Test',
            'order_type' => 'takeaway',
            'total_amount' => 10000,
            'items' => [
                ['product_name' => 'Test Product', 'quantity' => 150]
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('items.0.quantity');
    }

    public function test_order_status_update_validation_fails_with_invalid_status()
    {
        // Login as admin first
        $this->post('/login', [
            'username' => 'admin',
            'password' => 'password'
        ]);

        $response = $this->putJson('/api/admin/orders/ORD-001/status', [
            'status' => 'invalid_status'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('status');
    }

    public function test_customer_name_must_be_at_least_2_characters()
    {
        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD-004',
            'customer_name' => 'A',
            'order_type' => 'dinein',
            'total_amount' => 10000,
            'items' => [
                ['product_name' => 'Test Product', 'quantity' => 1]
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('customer_name');
    }
}
