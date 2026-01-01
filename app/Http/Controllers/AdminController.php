<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Category;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateOrderStatusRequest;
use Spatie\LaravelPdf\Facades\Pdf;

class AdminController extends Controller
{
    /**
     * Show admin login page
     */
    public function showLogin()
    {
        if (session()->has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * Process admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors([
                'login' => 'Invalid email or password.'
            ])->withInput();
        }

        session([
            'admin_logged_in' => true,
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'admin_email' => $admin->email,
            'admin_role' => $admin->role
        ]);

        // Redirect based on role
        if ($admin->role === 'cashier') {
            return redirect()->route('admin.cashier')->with('success', 'Welcome back, ' . $admin->name);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $admin->name);
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email', 'admin_role']);
        session()->flush();
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function dashboard()
    {
        // Revenue today
        $revenueToday = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        // Revenue this week (last 7 days - for comparison/tracking)
        $revenueWeek = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->sum('total_amount');

        // Total Orders Today
        $totalOrdersToday = Order::whereDate('created_at', today())->count();

        // Active Orders (Pending + Preparing + Ready)
        $activeOrdersCount = Order::whereIn('status', ['pending', 'preparing', 'ready'])->count();

        // Top 5 favorite menu items (Keep for Bestseller logic)
        $favoriteMenu = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->selectRaw('order_items.product_name, SUM(order_items.quantity) as total_sold')
            ->groupBy('order_items.product_name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Bestseller item
        $bestseller = $favoriteMenu->first();

        // Get sales data for the last 7 days
        $salesData = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total_amount) as total_sales')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Fill in missing dates with zero values
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayData = $salesData->firstWhere('date', $date);

            $chartData[] = [
                'date' => $date,
                'label' => now()->subDays($i)->format('D, M j'),
                'total_orders' => $dayData ? $dayData->total_orders : 0,
                'total_sales' => $dayData ? $dayData->total_sales : 0,
            ];
        }

        return view('admin.dashboard', compact(
            'revenueToday',
            'revenueWeek',
            'totalOrdersToday',
            'activeOrdersCount',
            'bestseller',
            'chartData'
        ))->with('active', 'dashboard');
    }

    public function cashier()
    {
        return view('admin.cashier')->with('active', 'cashier');
    }

    public function orders(Request $request)
    {
        // Start with base query
        $query = Order::query();

        // Filter by status
        if ($request->has('status') && is_array($request->status)) {
            $query->whereIn('status', $request->status);
        }

        // Filter by order type
        if ($request->has('order_type') && is_array($request->order_type)) {
            $query->whereIn('order_type', $request->order_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by amount range
        if ($request->filled('amount_min')) {
            $query->where('total_amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('total_amount', '<=', $request->amount_max);
        }

        // Calculate stats before pagination to get totals for all matching records
        $orderStats = (clone $query)->selectRaw('
            count(*) as total,
            sum(case when status = "pending" then 1 else 0 end) as pending,
            sum(case when status = "preparing" then 1 else 0 end) as preparing,
            sum(case when status = "completed" then 1 else 0 end) as completed
        ')->first();

        // Order by created_at descending (newest first) and paginate
        $orders = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.orders', compact('orders', 'orderStats'))->with('active', 'orders');
    }

    public function getOrderDetail($orderNumber)
    {
        // Find order by order_number with order items
        $order = Order::where('order_number', $orderNumber)
            ->with(['orderItems.product'])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function updateOrderStatus(UpdateOrderStatusRequest $request, $orderNumber)
    {
        // Find and update order
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $order->status = $request->validated()['status'];
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'data' => $order
        ]);
    }

    public function menu()
    {
        // Calculate totals for summary cards
        $allProducts = Product::all();
        $totalProducts = $allProducts->count();
        $totalStock = $allProducts->sum('stock');
        $lowStockCount = $allProducts->where('stock', '<', 10)->count();
        $outOfStockCount = $allProducts->where('stock', '=', 0)->count();

        // Calculate total revenue from all orders
        $totalRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->sum('order_items.subtotal');


        // Get top selling products (top 5)
        $topSellingProducts = Product::leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'products.*',
                DB::raw('COALESCE(SUM(CASE WHEN orders.status != "cancelled" THEN order_items.quantity ELSE 0 END), 0) as total_sold'),
                DB::raw('COALESCE(SUM(CASE WHEN orders.status != "cancelled" THEN order_items.subtotal ELSE 0 END), 0) as total_revenue')
            )
            ->groupBy('products.id', 'products.category_id', 'products.name', 'products.price', 'products.stock', 'products.image', 'products.description', 'products.created_at', 'products.updated_at')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Get categories with their products and stats
        $categories = Category::with(['products' => function ($query) {
            $query->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
                ->select(
                    'products.*',
                    DB::raw('COALESCE(SUM(CASE WHEN orders.status != "cancelled" THEN order_items.quantity ELSE 0 END), 0) as total_sold'),
                    DB::raw('COALESCE(SUM(CASE WHEN orders.status != "cancelled" THEN order_items.subtotal ELSE 0 END), 0) as total_revenue')
                )
                ->groupBy('products.id', 'products.category_id', 'products.name', 'products.price', 'products.stock', 'products.image', 'products.description', 'products.created_at', 'products.updated_at')
                ->orderBy('total_sold', 'desc');
        }])->get();

        return view('admin.menu', compact(
            'categories',
            'totalProducts',
            'totalStock',
            'lowStockCount',
            'outOfStockCount',
            'totalRevenue',
            'topSellingProducts'
        ))->with('active', 'menu');
    }

    public function storeProduct(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            // Create product
            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $request->image,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product->load('category')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product: ' . $e->getMessage()
            ], 500);
        }
    }

    public function transactions(Request $request)
    {
        // ... existing logic ...
        // To reuse logic, we could refactor filters into a scope or repository,
        // but for now, we keep it here for the view view.
        // THE EXPORT LOGIC IS HANDLED IN A SEPARATE METHOD using the Export class which DUPLICATES logic for now,
        // or re-uses a shared query builder if we refactored.
        // Since TransactionExport constructs its own query based on request, we just pass request.

        // Start with base query with relationships
        $query = Transaction::with(['order']);

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by amount range
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        // Search by transaction number or order number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                    ->orWhereHas('order', function ($q) use ($search) {
                        $q->where('order_number', 'like', "%{$search}%");
                    });
            });
        }

        // Order by created_at descending (newest first) and paginate
        $transactions = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Calculate statistics
        $totalTransactions = Transaction::count();
        $totalAmount = Transaction::where('payment_status', 'paid')->sum('amount');
        $pendingTransactions = Transaction::where('payment_status', 'pending')->count();
        $todayTransactions = Transaction::whereDate('created_at', today())->count();

        return view('admin.transactions', compact(
            'transactions',
            'totalTransactions',
            'totalAmount',
            'pendingTransactions',
            'todayTransactions'
        ))->with('active', 'transactions');
    }

    public function exportTransactions(Request $request)
    {
        return Excel::download(new TransactionExport($request), 'transactions-' . now()->format('Y-m-d_H-i') . '.xlsx');
    }

    /**
     * Generate kitchen receipt PDF for an order
     */
    public function printKitchenReceipt($orderNumber)
    {
        // Find order with items and relations
        $order = Order::where('order_number', $orderNumber)
            ->with(['orderItems.product.category'])
            ->firstOrFail();

        // Generate PDF
        return Pdf::view('pdf.kitchen-receipt', ['order' => $order])
            ->format('a4')
            ->name('kitchen-receipt-' . $order->order_number . '.pdf');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
