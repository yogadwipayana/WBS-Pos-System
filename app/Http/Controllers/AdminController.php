<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateOrderStatusRequest;

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
            'admin_email' => $admin->email
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $admin->name);
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_name', 'admin_email']);
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
        // Fetch recent orders (latest 5) with eager loading to avoid N+1
        $orders = Order::with('orderItems')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Calculate dynamic statistics from database
        $stats = [
            // Total revenue from completed orders
            'total_revenue' => Order::where('status', 'completed')
                ->sum('total_amount'),

            // Count of active orders (not completed/cancelled)
            'active_orders' => Order::whereIn('status', ['pending', 'preparing', 'ready'])
                ->count(),

            // Total orders created today
            'total_orders_today' => Order::whereDate('created_at', today())
                ->count(),

            // Find bestselling product
            'bestseller' => OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'))
                ->groupBy('product_name')
                ->orderBy('total_sold', 'desc')
                ->first()
        ];

        return view('admin.dashboard', compact('orders', 'stats'));
    }

    public function cashier()
    {
        return view('admin.cashier');
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

        // Order by created_at descending (newest first) and paginate
        $orders = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.orders', compact('orders'));
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
        // Get products with their categories and calculate sales statistics
        $products = Product::with('category')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'products.*',
                DB::raw('COALESCE(SUM(CASE WHEN orders.status != "cancelled" THEN order_items.quantity ELSE 0 END), 0) as total_sold'),
                DB::raw('COALESCE(SUM(CASE WHEN orders.status != "cancelled" THEN order_items.subtotal ELSE 0 END), 0) as total_revenue')
            )
            ->groupBy('products.id', 'products.category_id', 'products.name', 'products.price', 'products.stock', 'products.created_at', 'products.updated_at')
            ->orderBy('total_sold', 'desc')
            ->get();

        // Calculate summary statistics
        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');
        $lowStockCount = $products->where('stock', '<', 10)->count();
        $outOfStockCount = $products->where('stock', '=', 0)->count();
        $totalRevenue = $products->sum('total_revenue');

        // Get top selling products (top 5)
        $topSellingProducts = $products->take(5);

        return view('admin.menu', compact(
            'products',
            'totalProducts',
            'totalStock',
            'lowStockCount',
            'outOfStockCount',
            'totalRevenue',
            'topSellingProducts'
        ));
    }

    public function settings()
    {
        // Available theme options
        $themes = [
            [
                'id' => 'orange',
                'name' => 'Orange Classic',
                'description' => 'Warm and energetic orange theme',
                'primary' => '#f05a28',
                'secondary' => '#ff8c42'
            ],
            [
                'id' => 'blue',
                'name' => 'Ocean Blue',
                'description' => 'Cool and professional blue theme',
                'primary' => '#2563eb',
                'secondary' => '#3b82f6'
            ],
            [
                'id' => 'green',
                'name' => 'Nature Green',
                'description' => 'Fresh and natural green theme',
                'primary' => '#16a34a',
                'secondary' => '#22c55e'
            ],
            [
                'id' => 'purple',
                'name' => 'Royal Purple',
                'description' => 'Elegant and luxurious purple theme',
                'primary' => '#9333ea',
                'secondary' => '#a855f7'
            ],
            [
                'id' => 'red',
                'name' => 'Bold Red',
                'description' => 'Strong and passionate red theme',
                'primary' => '#dc2626',
                'secondary' => '#ef4444'
            ],
            [
                'id' => 'monochrome',
                'name' => 'Monochrome',
                'description' => 'Clean and minimal grayscale theme',
                'primary' => '#374151',
                'secondary' => '#6b7280'
            ]
        ];

        // Get current settings from session or use defaults
        $currentTheme = session('admin_theme', 'orange');
        $darkMode = session('admin_dark_mode', false);

        return view('admin.settings', compact('themes', 'currentTheme', 'darkMode'));
    }

    public function updateSettings(Request $request)
    {
        // Validate request
        $request->validate([
            'theme' => 'required|in:orange,blue,green,purple,red,monochrome',
            'dark_mode' => 'required|boolean'
        ]);

        // Store settings in session
        session([
            'admin_theme' => $request->theme,
            'admin_dark_mode' => $request->dark_mode
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'data' => [
                'theme' => $request->theme,
                'dark_mode' => $request->dark_mode
            ]
        ]);
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
