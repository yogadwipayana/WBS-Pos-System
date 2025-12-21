<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getting order by order number successfully.
     */
    public function test_can_get_order_by_order_number(): void
    {
        // Create a test order
        $order = Order::create([
            'order_number' => 'TEST-001',
            'customer_name' => 'John Doe',
            'order_type' => 'dinein',
            'table_number' => '5',
            'total_amount' => 150000,
            'notes' => 'Extra spicy',
            'status' => 'preparing'
        ]);

        // Make GET request to retrieve order
        $response = $this->getJson("/api/order/{$order->order_number}");

        // Assert response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Order retrieved successfully',
                'data' => [
                    'order_number' => 'TEST-001',
                    'customer_name' => 'John Doe',
                    'order_type' => 'dinein',
                    'table_number' => '5',
                    'total_amount' => 150000,
                    'notes' => 'Extra spicy',
                    'status' => 'preparing'
                ]
            ]);
    }

    /**
     * Test getting non-existent order returns 404.
     */
    public function test_get_non_existent_order_returns_404(): void
    {
        // Make GET request with non-existent order number
        $response = $this->getJson('/api/order/NON-EXISTENT-001');

        // Assert 404 response
        $response->assertStatus(404);
    }

    /**
     * Test order status flow from pending to preparing.
     */
    public function test_order_status_flow(): void
    {
        // Create a test order with pending status
        $order = Order::create([
            'order_number' => 'TEST-002',
            'customer_name' => 'Jane Smith',
            'order_type' => 'takeaway',
            'total_amount' => 85000,
            'status' => 'pending'
        ]);

        // Get order and verify it's pending
        $response = $this->getJson("/api/order/{$order->order_number}");
        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'pending');

        // Directly update order in database to simulate payment confirmation
        $order->update(['status' => 'preparing']);

        // Get order again and verify it's preparing
        $response = $this->getJson("/api/order/{$order->order_number}");
        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'preparing');
    }

    /**
     * Test order retrieval with all fields populated.
     */
    public function test_order_retrieval_with_all_fields(): void
    {
        $order = Order::create([
            'order_number' => 'TEST-003',
            'customer_name' => 'Bob Johnson',
            'order_type' => 'dinein',
            'table_number' => '12',
            'total_amount' => 275000,
            'notes' => 'Birthday celebration',
            'status' => 'preparing'
        ]);

        $response = $this->getJson("/api/order/{$order->order_number}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'order_number',
                    'customer_name',
                    'order_type',
                    'table_number',
                    'total_amount',
                    'notes',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
}
