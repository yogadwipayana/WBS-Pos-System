<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        // Get validated data
        $validated = $request->validated();

        // Create new order
        $order = Order::create([
            'order_number' => $validated['order_number'],
            'customer_name' => $validated['customer_name'],
            'order_type' => $validated['order_type'],
            'table_number' => $validated['table_number'] ?? null,
            'total_amount' => $validated['total_amount'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending', // Default status
        ]);

        // Bulk load products to avoid N+1 query problem
        $productNames = array_column($validated['items'], 'product_name');
        $products = Product::whereIn('name', $productNames)->get()->keyBy('name');

        // Enrich items with product data and validate stock
        foreach ($validated['items'] as $key => $item) {
            $product = $products->get($item['product_name']);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => "Product '{$item['product_name']}' not found"
                ], 404);
            }

            // Check stock availability
            if ($product->stock < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Insufficient stock for '{$product->name}'. Available: {$product->stock}, Requested: {$item['quantity']}"
                ], 400);
            }

            $validated['items'][$key]['product_id'] = $product->id;
            $validated['items'][$key]['price'] = $product->price;
            $validated['items'][$key]['subtotal'] = $product->price * $item['quantity'];
        }

        // Create order items and reduce stock
        foreach ($validated['items'] as $item) {
            // Create order item
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);

            // Reduce product stock
            $product = Product::find($item['product_id']);
            $product->decrement('stock', $item['quantity']);
        }

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order->load('orderItems') // Include order items in response
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($orderNumber)
    {
        // Find order by order_number with eager loading
        $order = Order::where('order_number', $orderNumber)
            ->with(['orderItems.product'])
            ->firstOrFail();

        // Return order data
        return response()->json([
            'success' => true,
            'message' => 'Order retrieved successfully',
            'data' => $order
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $orderNumber)
    {
        // Validate incoming request
        $validated = $request->validate([
            'customer_name' => 'sometimes|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'order_type' => 'sometimes|in:dinein,takeaway',
            'status' => 'sometimes|in:pending,preparing,ready,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Find order by order_number
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Update order with validated data
        $order->update($validated);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $order->fresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($orderNumber)
    {
        try {
            // Find order by order_number
            $order = Order::where('order_number', $orderNumber)->firstOrFail();
            // Delete associated order items first (cascade delete)
            $order->orderItems()->delete();

            // Delete the order
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order: ' . $e->getMessage()
            ], 500);
        }
    }
}
