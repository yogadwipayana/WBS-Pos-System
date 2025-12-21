<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Warung Bali Sangeh Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    
    <!-- Theme Provider -->
    <x-theme-provider />
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Component -->
        <x-admin-sidebar active="orders" />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- Top Bar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
                <!-- Mobile Menu Button (Hidden on Desktop) -->
                <button class="md:hidden p-2 -ml-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Search -->
                <div class="flex-1 max-w-lg hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <input type="text"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:bg-white focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm transition-colors"
                            placeholder="Search by order number, customer name...">
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>
                    <div class="border-l border-gray-200 h-8 mx-2"></div>
                    <div class="font-medium text-gray-700">Today, {{ date('d M Y') }}</div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- Page Header -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
                            <p class="text-gray-500 mt-1">Manage and track all customer orders</p>
                        </div>
                        <div class="flex gap-3">
                            <button id="openFilterModal"
                                class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-xl font-semibold shadow-sm text-sm flex items-center gap-2 hover:bg-gray-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                                </svg>
                                Filter
                                @if(request()->hasAny(['status', 'order_type', 'date_from', 'date_to']))
                                    <span class="ml-1 w-2 h-2 bg-primary rounded-full"></span>
                                @endif
                            </button>
                            <button
                                class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-xl font-semibold shadow-sm text-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Export
                            </button>
                        </div>
                    </div>

                    <!-- Stats Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-xs font-medium mb-1">Total Orders</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $orders->total() }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-xs font-medium mb-1">Pending</p>
                                    <p class="text-2xl font-bold text-yellow-600">
                                        {{ $orders->where('status', 'pending')->count() }}
                                    </p>
                                </div>
                                <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5 text-yellow-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-xs font-medium mb-1">Preparing</p>
                                    <p class="text-2xl font-bold text-orange-600">
                                        {{ $orders->where('status', 'preparing')->count() }}
                                    </p>
                                </div>
                                <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5 text-orange-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-xs font-medium mb-1">Completed</p>
                                    <p class="text-2xl font-bold text-green-600">
                                        {{ $orders->where('status', 'completed')->count() }}
                                    </p>
                                </div>
                                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5 text-green-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Order Number
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Customer
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Amount
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($orders as $order)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $order->order_number }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $order->customer_name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm text-gray-900 capitalize">{{ $order->order_type }}</span>
                                                    @if($order->order_type === 'dinein' && $order->table_number)
                                                        <span class="text-xs px-2 py-0.5 bg-gray-100 rounded text-gray-600">
                                                            Table {{ $order->table_number }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'preparing' => 'bg-blue-100 text-blue-800',
                                                        'ready' => 'bg-green-100 text-green-800',
                                                        'completed' => 'bg-gray-100 text-gray-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $color }} capitalize">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $order->created_at->timezone('Asia/Singapore')->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button onclick="viewOrderDetail('{{ $order->order_number }}')" 
                                                    class="text-primary hover:text-primary-dark transition-colors font-semibold">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-300 mb-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                    </svg>
                                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">No orders found</h3>
                                                    <p class="text-gray-500">There are no orders to display at the moment.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                            <div class="bg-white px-6 py-4 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-700">
                                        Showing <span class="font-semibold">{{ $orders->firstItem() }}</span>
                                        to <span class="font-semibold">{{ $orders->lastItem() }}</span>
                                        of <span class="font-semibold">{{ $orders->total() }}</span> results
                                    </div>
                                    <div class="flex gap-2">
                                        {{-- Previous Page Link --}}
                                        @if ($orders->onFirstPage())
                                            <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                                Previous
                                            </span>
                                        @else
                                            <a href="{{ $orders->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                Previous
                                            </a>
                                        @endif

                                        {{-- Page Numbers --}}
                                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                            @if ($page == $orders->currentPage())
                                                <span class="px-4 py-2 text-sm font-medium text-white bg-primary border border-primary rounded-lg">
                                                    {{ $page }}
                                                </span>
                                            @else
                                                <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                    {{ $page }}
                                                </a>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($orders->hasMorePages())
                                            <a href="{{ $orders->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                Next
                                            </a>
                                        @else
                                            <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                                Next
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Order Detail Modal -->
    <div id="orderDetailModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-white">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Order Details</h3>
                    <p id="detailOrderNumber" class="text-sm text-gray-600 mt-1"></p>
                </div>
                <button id="closeDetailModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                
                <!-- Loading State -->
                <div id="detailLoading" class="text-center py-12">
                    <svg class="animate-spin h-12 w-12 text-primary mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-500">Loading order details...</p>
                </div>

                <!-- Content -->
                <div id="detailContent" class="hidden space-y-6">
                    
                    <!-- Customer & Order Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Customer Information</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Name:</span>
                                    <span id="detailCustomerName" class="font-semibold text-gray-900"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Phone:</span>
                                    <span id="detailCustomerPhone" class="font-semibold text-gray-900"></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Order Information</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Type:</span>
                                    <span id="detailOrderType" class="font-semibold text-gray-900"></span>
                                </div>
                                <div id="detailTableNumberRow" class="flex justify-between text-sm hidden">
                                    <span class="text-gray-600">Table:</span>
                                    <span id="detailTableNumber" class="font-semibold text-gray-900"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Date:</span>
                                    <span id="detailOrderDate" class="font-semibold text-gray-900"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Status:</span>
                                    <span id="detailOrderStatus"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-3">Order Items</h4>
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Item</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Qty</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Price</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="detailOrderItems" class="divide-y divide-gray-200">
                                    <!-- Items will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div id="detailNotesSection" class="bg-blue-50 border border-blue-100 p-4 rounded-xl hidden">
                        <h4 class="text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            Notes
                        </h4>
                        <p id="detailNotes" class="text-sm text-gray-700"></p>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-xl border-2 border-orange-200">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-700">Subtotal:</span>
                                <span id="detailSubtotal" class="font-semibold text-gray-900"></span>
                            </div>
                            <div id="detailDiscountRow" class="flex justify-between text-sm hidden">
                                <span class="text-gray-700">Discount:</span>
                                <span id="detailDiscount" class="font-semibold text-green-600"></span>
                            </div>
                            <div class="pt-3 border-t-2 border-orange-300 flex justify-between">
                                <span class="text-lg font-bold text-gray-900">Total:</span>
                                <span id="detailTotal" class="text-2xl font-bold text-primary"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end p-6 border-t border-gray-200 bg-gray-50 gap-3">
                <button id="closeDetailModalBtn"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors">
                    Close
                </button>
                <button id="printOrderBtn"
                    class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                    Print
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div id="filterModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Filter Orders</h3>
                <button id="closeFilterModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Order Status</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center p-3 border-2 rounded-xl cursor-pointer transition-all hover:border-primary hover:bg-orange-50"
                            onclick="toggleCheckbox(this)">
                            <input type="checkbox" name="status[]" value="pending" 
                                {{ in_array('pending', request()->input('status', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="ml-3 text-sm font-medium text-gray-700">Pending</span>
                        </label>
                        <label class="flex items-center p-3 border-2 rounded-xl cursor-pointer transition-all hover:border-primary hover:bg-orange-50"
                            onclick="toggleCheckbox(this)">
                            <input type="checkbox" name="status[]" value="preparing"
                                {{ in_array('preparing', request()->input('status', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="ml-3 text-sm font-medium text-gray-700">Preparing</span>
                        </label>
                        <label class="flex items-center p-3 border-2 rounded-xl cursor-pointer transition-all hover:border-primary hover:bg-orange-50"
                            onclick="toggleCheckbox(this)">
                            <input type="checkbox" name="status[]" value="ready"
                                {{ in_array('ready', request()->input('status', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="ml-3 text-sm font-medium text-gray-700">Ready</span>
                        </label>
                        <label class="flex items-center p-3 border-2 rounded-xl cursor-pointer transition-all hover:border-primary hover:bg-orange-50"
                            onclick="toggleCheckbox(this)">
                            <input type="checkbox" name="status[]" value="completed"
                                {{ in_array('completed', request()->input('status', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="ml-3 text-sm font-medium text-gray-700">Completed</span>
                        </label>
                    </div>
                </div>

                <!-- Order Type Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Order Type</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center p-3 border-2 rounded-xl cursor-pointer transition-all hover:border-primary hover:bg-orange-50"
                            onclick="toggleCheckbox(this)">
                            <input type="checkbox" name="order_type[]" value="dinein"
                                {{ in_array('dinein', request()->input('order_type', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="ml-3 text-sm font-medium text-gray-700">Dine In</span>
                        </label>
                        <label class="flex items-center p-3 border-2 rounded-xl cursor-pointer transition-all hover:border-primary hover:bg-orange-50"
                            onclick="toggleCheckbox(this)">
                            <input type="checkbox" name="order_type[]" value="takeaway"
                                {{ in_array('takeaway', request()->input('order_type', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="ml-3 text-sm font-medium text-gray-700">Take Away</span>
                        </label>
                    </div>
                </div>

                <!-- Date Range Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Date Range</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">From</label>
                            <input type="date" name="date_from" value="{{ request()->input('date_from') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">To</label>
                            <input type="date" name="date_to" value="{{ request()->input('date_to') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

                <!-- Amount Range Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Amount Range (Rp)</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Min Amount</label>
                            <input type="number" name="amount_min" value="{{ request()->input('amount_min') }}"
                                placeholder="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Max Amount</label>
                            <input type="number" name="amount_max" value="{{ request()->input('amount_max') }}"
                                placeholder="1000000"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-between p-6 border-t border-gray-200 bg-gray-50">
                <button id="clearFilters" class="text-gray-600 hover:text-gray-800 font-semibold text-sm transition-colors">
                    Clear All Filters
                </button>
                <div class="flex gap-3">
                    <button id="cancelFilter"
                        class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button id="applyFilters"
                        class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // View Order Detail Function
        async function viewOrderDetail(orderNumber) {
            const modal = document.getElementById('orderDetailModal');
            const loading = document.getElementById('detailLoading');
            const content = document.getElementById('detailContent');
            
            // Show modal with loading state
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            loading.classList.remove('hidden');
            content.classList.add('hidden');
            
            try {
                // Fetch order details
                const response = await fetch(`/api/admin/orders/${orderNumber}`);
                
                if (!response.ok) {
                    throw new Error('Failed to fetch order details');
                }
                
                const result = await response.json();
                
                if (result.success && result.data) {
                    const order = result.data;
                    
                    // Populate order details
                    document.getElementById('detailOrderNumber').textContent = `Order #${order.order_number}`;
                    document.getElementById('detailCustomerName').textContent = order.customer_name || '-';
                    document.getElementById('detailCustomerPhone').textContent = order.customer_phone || '-';
                    
                    // Order type
                    const orderType = order.order_type === 'dinein' ? 'Dine In' : 'Take Away';
                    document.getElementById('detailOrderType').textContent = orderType;
                    
                    // Table number (if dine-in)
                    if (order.order_type === 'dinein' && order.table_number) {
                        document.getElementById('detailTableNumberRow').classList.remove('hidden');
                        document.getElementById('detailTableNumber').textContent = `Table ${order.table_number}`;
                    } else {
                        document.getElementById('detailTableNumberRow').classList.add('hidden');
                    }
                    
                    // Order date (UTC+8)
                    const date = new Date(order.created_at);
                    document.getElementById('detailOrderDate').textContent = date.toLocaleString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        timeZone: 'Asia/Singapore'
                    });
                    
                    // Status badge
                    const statusColors = {
                        'pending': 'bg-yellow-100 text-yellow-800',
                        'preparing': 'bg-blue-100 text-blue-800',
                        'ready': 'bg-green-100 text-green-800',
                        'completed': 'bg-gray-100 text-gray-800',
                        'cancelled': 'bg-red-100 text-red-800'
                    };
                    const statusColor = statusColors[order.status] || 'bg-gray-100 text-gray-800';
                    document.getElementById('detailOrderStatus').innerHTML = 
                        `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ${statusColor} capitalize">${order.status}</span>`;
                    
                    // Order items
                    const itemsContainer = document.getElementById('detailOrderItems');
                    itemsContainer.innerHTML = '';
                    
                    if (order.order_items && order.order_items.length > 0) {
                        order.order_items.forEach(item => {
                            const row = document.createElement('tr');
                            row.classList.add('hover:bg-gray-50');
                            row.innerHTML = `
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div class="font-semibold">${item.product_name}</div>
                                    ${item.notes ? `<div class="text-xs text-gray-500 mt-1">Note: ${item.notes}</div>` : ''}
                                </td>
                                <td class="px-4 py-3 text-sm text-center text-gray-900 font-semibold">${item.quantity}</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-900">Rp${parseInt(item.price).toLocaleString('id-ID')}</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-900 font-semibold">Rp${parseInt(item.subtotal).toLocaleString('id-ID')}</td>
                            `;
                            itemsContainer.appendChild(row);
                        });
                    } else {
                        itemsContainer.innerHTML = `
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                    No items found
                                </td>
                            </tr>
                        `;
                    }
                    
                    // Notes
                    if (order.notes) {
                        document.getElementById('detailNotesSection').classList.remove('hidden');
                        document.getElementById('detailNotes').textContent = order.notes;
                    } else {
                        document.getElementById('detailNotesSection').classList.add('hidden');
                    }
                    
                    // Calculate subtotal
                    let subtotal = 0;
                    if (order.order_items) {
                        subtotal = order.order_items.reduce((sum, item) => sum + parseFloat(item.subtotal), 0);
                    }
                    
                    document.getElementById('detailSubtotal').textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
                    
                    // Discount
                    if (order.discount && parseFloat(order.discount) > 0) {
                        document.getElementById('detailDiscountRow').classList.remove('hidden');
                        document.getElementById('detailDiscount').textContent = `-Rp${parseFloat(order.discount).toLocaleString('id-ID')}`;
                    } else {
                        document.getElementById('detailDiscountRow').classList.add('hidden');
                    }
                    
                    // Total
                    document.getElementById('detailTotal').textContent = `Rp${parseInt(order.total_amount).toLocaleString('id-ID')}`;
                    
                    // Show content, hide loading
                    loading.classList.add('hidden');
                    content.classList.remove('hidden');
                    
                } else {
                    throw new Error('Invalid response data');
                }
                
            } catch (error) {
                console.error('Error loading order details:', error);
                alert('Failed to load order details. Please try again.');
                closeDetailModal();
            }
        }
        
        // Close detail modal
        function closeDetailModal() {
            const modal = document.getElementById('orderDetailModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Detail Modal Controls
        document.addEventListener('DOMContentLoaded', () => {
            const detailModal = document.getElementById('orderDetailModal');
            const closeDetailBtn = document.getElementById('closeDetailModal');
            const closeDetailBtnFooter = document.getElementById('closeDetailModalBtn');
            const printOrderBtn = document.getElementById('printOrderBtn');
            
            // Close buttons
            closeDetailBtn.addEventListener('click', closeDetailModal);
            closeDetailBtnFooter.addEventListener('click', closeDetailModal);
            
            // Close on background click
            detailModal.addEventListener('click', (e) => {
                if (e.target === detailModal) {
                    closeDetailModal();
                }
            });
            
            // Print order (placeholder)
            printOrderBtn.addEventListener('click', () => {
                // TODO: Implement print functionality
                alert('Print functionality will be implemented soon!');
            });
        });

        // Toggle checkbox when clicking on label
        function toggleCheckbox(label) {
            const checkbox = label.querySelector('input[type="checkbox"]');
            // Prevent double toggle (once from label click, once from checkbox click)
            if (event.target !== checkbox) {
                checkbox.checked = !checkbox.checked;
            }
            
            // Update visual state
            if (checkbox.checked) {
                label.classList.add('border-primary', 'bg-orange-50');
            } else {
                label.classList.remove('border-primary', 'bg-orange-50');
            }
        }

        // Initialize visual state on page load
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                const label = checkbox.closest('label');
                if (label) {
                    label.classList.add('border-primary', 'bg-orange-50');
                }
            });
        });

        // Modal Control
        const filterModal = document.getElementById('filterModal');
        const openFilterBtn = document.getElementById('openFilterModal');
        const closeFilterBtn = document.getElementById('closeFilterModal');
        const cancelFilterBtn = document.getElementById('cancelFilter');
        const applyFiltersBtn = document.getElementById('applyFilters');
        const clearFiltersBtn = document.getElementById('clearFilters');

        // Open modal
        openFilterBtn.addEventListener('click', () => {
            filterModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        // Close modal
        function closeModal() {
            filterModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        closeFilterBtn.addEventListener('click', closeModal);
        cancelFilterBtn.addEventListener('click', closeModal);

        // Close on background click
        filterModal.addEventListener('click', (e) => {
            if (e.target === filterModal) {
                closeModal();
            }
        });

        // Apply filters
        applyFiltersBtn.addEventListener('click', () => {
            const params = new URLSearchParams();

            // Get status filters
            const statusCheckboxes = document.querySelectorAll('input[name="status[]"]:checked');
            statusCheckboxes.forEach(checkbox => {
                params.append('status[]', checkbox.value);
            });

            // Get order type filters
            const orderTypeCheckboxes = document.querySelectorAll('input[name="order_type[]"]:checked');
            orderTypeCheckboxes.forEach(checkbox => {
                params.append('order_type[]', checkbox.value);
            });

            // Get date range
            const dateFrom = document.querySelector('input[name="date_from"]').value;
            const dateTo = document.querySelector('input[name="date_to"]').value;
            if (dateFrom) params.append('date_from', dateFrom);
            if (dateTo) params.append('date_to', dateTo);

            // Get amount range
            const amountMin = document.querySelector('input[name="amount_min"]').value;
            const amountMax = document.querySelector('input[name="amount_max"]').value;
            if (amountMin) params.append('amount_min', amountMin);
            if (amountMax) params.append('amount_max', amountMax);

            // Redirect with filters
            window.location.href = '/dashboard/orders?' + params.toString();
        });

        // Clear all filters
        clearFiltersBtn.addEventListener('click', () => {
            window.location.href = '/dashboard/orders';
        });
    </script>

</body>

</html>
