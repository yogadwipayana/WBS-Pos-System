<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test successful order creation
     */
    public function test_can_create_order_with_valid_data(): void
    {
        $orderData = [
            'order_number' => 'ORD12345',
            'customer_name' => 'John Doe',
            'order_type' => 'takeaway',
            'total_amount' => 50000,
        ];

        $response = $this->postJson('/api/order', $orderData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Order created successfully',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'order_number',
                    'customer_name',
                    'order_type',
                    'total_amount',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('orders', [
            'order_number' => 'ORD12345',
            'customer_name' => 'John Doe',
            'order_type' => 'takeaway',
            'total_amount' => 50000,
            'status' => 'pending',
        ]);
    }

    /**
     * Test order creation with dine-in type and table number
     */
    public function test_can_create_dinein_order_with_table_number(): void
    {
        $orderData = [
            'order_number' => 'ORD67890',
            'customer_name' => 'Jane Smith',
            'order_type' => 'dinein',
            'table_number' => 'T05',
            'total_amount' => 75000,
            'notes' => 'Extra spicy please',
        ];

        $response = $this->postJson('/api/order', $orderData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('orders', [
            'order_number' => 'ORD67890',
            'order_type' => 'dinein',
            'table_number' => 'T05',
            'notes' => 'Extra spicy please',
        ]);
    }

    /**
     * Test order creation fails without required fields
     */
    public function test_order_creation_fails_without_required_fields(): void
    {
        $response = $this->postJson('/api/order', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'order_number',
                'customer_name',
                'order_type',
                'total_amount',
            ]);
    }

    /**
     * Test order creation fails with duplicate order number
     */
    public function test_order_creation_fails_with_duplicate_order_number(): void
    {
        // Create first order
        Order::create([
            'order_number' => 'ORD12345',
            'customer_name' => 'John Doe',
            'order_type' => 'takeaway',
            'total_amount' => 50000,
            'status' => 'pending',
        ]);

        // Try to create second order with same order number
        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD12345',
            'customer_name' => 'Jane Smith',
            'order_type' => 'dinein',
            'total_amount' => 60000,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['order_number']);
    }

    /**
     * Test order creation fails with invalid order type
     */
    public function test_order_creation_fails_with_invalid_order_type(): void
    {
        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD12345',
            'customer_name' => 'John Doe',
            'order_type' => 'delivery', // Invalid type
            'total_amount' => 50000,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['order_type']);
    }

    /**
     * Test order creation fails with negative total amount
     */
    public function test_order_creation_fails_with_negative_amount(): void
    {
        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD12345',
            'customer_name' => 'John Doe',
            'order_type' => 'takeaway',
            'total_amount' => -10000,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['total_amount']);
    }

    /**
     * Test successful order status update
     */
    public function test_can_update_order_status_to_preparing(): void
    {
        // Create an order first
        $order = Order::create([
            'order_number' => 'ORD12345',
            'customer_name' => 'John Doe',
            'order_type' => 'takeaway',
            'total_amount' => 50000,
            'status' => 'pending',
        ]);

        $response = $this->putJson("/api/order/{$order->id}", [
            'order_number' => 'ORD12345',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Order status updated to preparing',
            ])
            ->assertJsonPath('data.status', 'preparing');

        $this->assertDatabaseHas('orders', [
            'order_number' => 'ORD12345',
            'status' => 'preparing',
        ]);
    }

    /**
     * Test order status update fails without order number
     */
    public function test_order_update_fails_without_order_number(): void
    {
        $order = Order::create([
            'order_number' => 'ORD12345',
            'customer_name' => 'John Doe',
            'order_type' => 'takeaway',
            'total_amount' => 50000,
            'status' => 'pending',
        ]);

        $response = $this->putJson("/api/order/{$order->id}", []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['order_number']);
    }

    /**
     * Test order status update fails with non-existent order number
     */
    public function test_order_update_fails_with_nonexistent_order_number(): void
    {
        $order = Order::create([
            'order_number' => 'ORD12345',
            'customer_name' => 'John Doe',
            'order_type' => 'takeaway',
            'total_amount' => 50000,
            'status' => 'pending',
        ]);

        $response = $this->putJson("/api/order/{$order->id}", [
            'order_number' => 'NONEXISTENT',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['order_number']);
    }

    /**
     * Test order creation with maximum field lengths
     */
    public function test_order_creation_validates_field_lengths(): void
    {
        $response = $this->postJson('/api/order', [
            'order_number' => str_repeat('A', 256), // Over 255 limit
            'customer_name' => 'John Doe',
            'order_type' => 'takeaway',
            'total_amount' => 50000,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['order_number']);
    }

    /**
     * Test order creation with notes field
     */
    public function test_order_creation_accepts_optional_notes(): void
    {
        $longNotes = str_repeat('Test note. ', 50);

        $response = $this->postJson('/api/order', [
            'order_number' => 'ORD12345',
            'customer_name' => 'John Doe',
            'order_type' => 'takeaway',
            'total_amount' => 50000,
            'notes' => $longNotes,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('orders', [
            'order_number' => 'ORD12345',
            'notes' => $longNotes,
        ]);
    }
}
