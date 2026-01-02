<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Facades\Pdf;

class OrderController extends Controller
{
    /**
     * Download customer receipt PDF
     */
    public function downloadReceipt($orderNumber)
    {
        // Find order with items and relations
        $order = Order::where('order_number', $orderNumber)
            ->with(['orderItems.product'])
            ->firstOrFail();

        // Generate PDF
        return Pdf::view('pdf.customer-receipt', ['order' => $order])
            ->format('a4') // Receipt size can be adjusted to 'a5' or custom width if needed, but a4 is safe
            ->name('receipt-' . $order->order_number . '.pdf');
    }

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

        // Use database transaction for data consistency
        DB::beginTransaction();

        try {
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
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Product '{$item['product_name']}' not found"
                    ], 404);
                }

                // Check stock availability
                if ($product->stock < $item['quantity']) {
                    DB::rollBack();
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

            // Get payment method from request (default to cash if not provided)
            $paymentMethod = $request->input('payment_method', 'cash');

            // Validate payment method
            if (!in_array($paymentMethod, ['cash', 'qris', 'transfer'])) {
                $paymentMethod = 'cash';
            }

            // Generate unique transaction number
            $transactionNumber = 'TRX' . date('Ymd') . str_pad($order->id, 6, '0', STR_PAD_LEFT);

            // Create transaction record with paid status
            $transaction = Transaction::create([
                'order_id' => $order->id,
                'transaction_number' => $transactionNumber,
                'payment_method' => $paymentMethod,
                'payment_status' => 'paid', // Automatically set as paid
                'amount' => $validated['total_amount'],
                'notes' => 'Pembayaran berhasil - Order #' . $validated['order_number'],
            ]);

            // Commit the transaction
            DB::commit();

            // Return success response with transaction data
            return response()->json([
                'success' => true,
                'message' => 'Order and transaction created successfully',
                'data' => [
                    'order' => $order->load('orderItems'),
                    'transaction' => $transaction
                ]
            ], 201);
        } catch (\Exception $e) {
            // Rollback on any error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
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
