<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Warung Bali Sangeh</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Theme Provider -->
    <x-theme-provider />

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .text-orange-600 {
            color: #ea580c;
        }

        .bg-green-100 {
            background-color: #dcfce7;
        }

        .text-green-600 {
            color: #16a34a;
        }

        .bg-blue-100 {
            background-color: #dbeafe;
        }

        .text-blue-600 {
            color: #2563eb;
        }

        .bg-red-100 {
            background-color: #fee2e2;
        }

        .text-red-600 {
            color: #dc2626;
        }

        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Component -->
        <x-admin-sidebar active="dashboard" />


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
                            placeholder="Search orders, menu items...">
                    </div>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>
                    <div class="border-l border-gray-200 h-8 mx-2"></div>
                    <div class="font-medium text-gray-700">Hari ini, {{ date('d M Y') }}</div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- Page Header -->
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold text-gray-900">Dasbor</h1>
                        <button
                            class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-xl font-semibold shadow-sm text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            New Order
                        </button>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Revenue -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-gray-500 text-sm font-medium">Total Pendapatan</span>
                                <div
                                    class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mb-1">
                                Rp{{ number_format($stats['total_revenue'], 0, ',', '.') }}
                            </div>
                            <div class="text-gray-500 text-xs">
                                From completed orders
                            </div>
                        </div>

                        <!-- Active Orders -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-gray-500 text-sm font-medium">Active Orders</span>
                                <div
                                    class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mb-1">
                                {{ $stats['active_orders'] }}
                            </div>
                            <div class="text-orange-600 text-xs font-semibold">
                                Pending + Preparing + Ready
                            </div>
                        </div>

                        <!-- Total Orders -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-gray-500 text-sm font-medium">Total Pesanan (Hari Ini)</span>
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mb-1">
                                {{ $stats['total_orders_today'] }}
                            </div>
                            <div class="text-gray-500 text-xs">
                                Orders created today
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-gray-500 text-sm font-medium">Bestseller</span>
                                <div
                                    class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl font-bold text-gray-900 mb-1">
                                {{ $stats['bestseller']->product_name ?? 'N/A' }}
                            </div>
                            <div class="text-gray-500 text-xs">
                                @if ($stats['bestseller'])
                                    {{ $stats['bestseller']->total_sold }} sold
                                @else
                                    No sales data
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders Table -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                            <h2 class="font-bold text-gray-900">Recent Orders</h2>
                            <a href="#" class="text-primary text-sm font-semibold hover:text-orange-700">View
                                All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                        <th class="px-6 py-4 font-semibold">Order ID</th>
                                        <th class="px-6 py-4 font-semibold">Customer</th>
                                        <th class="px-6 py-4 font-semibold">Type</th>
                                        <th class="px-6 py-4 font-semibold">Total</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm">
                                    @forelse($orders as $order)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->order_number }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">{{ $order->customer_name }}</td>
                                            <td class="px-6 py-4">
                                                @if ($order->order_type === 'dinein')
                                                    <span
                                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-orange-50 text-primary border border-orange-100">
                                                        Dine In @if ($order->table_number)
                                                            • T-{{ $order->table_number }}
                                                        @endif
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                        Takeaway
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 font-medium text-gray-900">Rp
                                                {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $statusClasses = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'preparing' => 'bg-yellow-100 text-yellow-800',
                                                        'ready' => 'bg-green-100 text-green-800',
                                                        'completed' => 'bg-gray-100 text-gray-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $statusText = ucfirst($order->status);
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $statusText }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <button onclick="viewOrder('{{ $order->order_number }}')"
                                                        class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                        title="View Details">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </button>
                                                    <button onclick="editOrder('{{ $order->order_number }}')"
                                                        class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                        title="Edit Order">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </button>
                                                    <button onclick="deleteOrder('{{ $order->order_number }}')"
                                                        class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Delete Order">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                                No recent orders found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Edit Order Modal -->
    <div id="editModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <div
                class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Edit Order</h3>
                    <p id="editOrderNumber" class="text-sm text-gray-600 mt-1"></p>
                </div>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4 overflow-y-auto max-h-[calc(90vh-180px)]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Customer Name</label>
                        <input type="text" id="editCustomerName"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Customer Phone</label>
                        <input type="text" id="editCustomerPhone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Order Type</label>
                        <select id="editOrderType"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="dinein">Dine In</option>
                            <option value="takeaway">Take Away</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select id="editStatus"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="pending">Pending</option>
                            <option value="preparing">Preparing</option>
                            <option value="ready">Ready</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                    <textarea id="editNotes" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end p-6 border-t border-gray-200 bg-gray-50 gap-3">
                <button onclick="closeEditModal()"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors">Cancel</button>
                <button onclick="saveEdit()"
                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors">Save
                    Changes</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Delete Order</h3>
                        <p class="text-sm text-gray-500 mt-1">This action cannot be undone</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-700">Are you sure you want to delete order <span id="deleteOrderNumber"
                        class="font-bold text-gray-900"></span>? This will permanently remove all order data.</p>
            </div>
            <div class="flex items-center justify-end p-6 border-t border-gray-200 bg-gray-50 gap-3">
                <button onclick="closeDeleteModal()"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors">Cancel</button>
                <button onclick="confirmDelete()"
                    class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-colors">Delete
                    Order</button>
            </div>
        </div>
    </div>

    <script>
        let currentOrderNumber = null;

        function viewOrder(orderNumber) {
            window.location.href = `/dashboard/orders?view=${orderNumber}`;
        }

        async function editOrder(orderNumber) {
            currentOrderNumber = orderNumber;
            try {
                const response = await fetch(`/api/admin/orders/${orderNumber}`);
                const result = await response.json();
                if (result.success && result.data) {
                    const order = result.data;
                    document.getElementById('editOrderNumber').textContent = `Order #${order.order_number}`;
                    document.getElementById('editCustomerName').value = order.customer_name || '';
                    document.getElementById('editCustomerPhone').value = order.customer_phone || '';
                    document.getElementById('editOrderType').value = order.order_type;
                    document.getElementById('editStatus').value = order.status;
                    document.getElementById('editNotes').value = order.notes || '';
                    document.getElementById('editModal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    alert('Failed to load order details');
                }
            } catch (error) {
                console.error('Error loading order:', error);
                alert('Failed to load order details');
            }
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        async function saveEdit() {
            if (!currentOrderNumber) return;
            const data = {
                customer_name: document.getElementById('editCustomerName').value,
                customer_phone: document.getElementById('editCustomerPhone').value,
                order_type: document.getElementById('editOrderType').value || '',
                status: document.getElementById('editStatus').value,
                notes: document.getElementById('editNotes').value || ''
            };
            try {
                const response = await fetch(`/api/order/${currentOrderNumber}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                // console.log('Update response:', result); // Debug log
                if (result.success) {
                    alert('Order updated successfully!');
                    closeEditModal();
                    window.location.reload();
                } else {
                    const errorMsg = result.message || 'Failed to update order';
                    alert(`Failed to update order: ${errorMsg}`);
                    console.error('Server error:', result);
                }
            } catch (error) {
                console.error('Error:', error);
                alert(`Failed to update order: ${error.message}`);
            }
        }

        function deleteOrder(orderNumber) {
            currentOrderNumber = orderNumber;
            document.getElementById('deleteOrderNumber').textContent = `#${orderNumber}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        async function confirmDelete() {
            if (!currentOrderNumber) return;
            try {
                const response = await fetch(`/api/order/${currentOrderNumber}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();
                if (result.success) {
                    alert('Order deleted successfully!');
                    closeDeleteModal();
                    window.location.reload();
                } else {
                    alert('Failed to delete order');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to delete order');
            }
        }
    </script>

</body>

</html>
