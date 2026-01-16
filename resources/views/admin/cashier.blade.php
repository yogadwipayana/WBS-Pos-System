@extends('layouts.admin')
@section('active', 'cashier')

@section('title', 'Cashier')

@section('content')
    <!-- Header -->
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
        <!-- Mobile Menu Button (Hidden on Desktop) -->
        <button class="md:hidden p-2 -ml-2 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <!-- Search -->
        <div class="flex-1 max-w-lg hidden md:block">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-gray-400">
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
        <x-alert />

        <!-- Search Section -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Process Payment</h2>
                <p class="text-gray-500 mb-6">Enter the customer's Order Number to verify and process payment.
                </p>

                <div class="flex max-w-md mx-auto relative group">
                    <input type="text" id="orderSearchInput"
                        class="w-full pl-5 pr-14 py-4 border-2 border-gray-200 rounded-2xl text-lg focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 transition-all uppercase placeholder-gray-300"
                        placeholder="ex. MBSS9150">
                    <button id="searchBtn"
                        class="absolute right-2 top-2 bottom-2 bg-orange-600 hover:bg-orange-700 text-white rounded-xl px-4 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Recent Orders List -->
            @if (isset($recentOrders) && $recentOrders->count() > 0)
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-500 mb-3 px-1">Recent Active Orders</h3>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach ($recentOrders as $recent)
                            <div onclick="document.getElementById('orderSearchInput').value = '{{ $recent->order_number }}'; searchOrder();"
                                class="bg-white border shadow-sm border-gray-100 hover:border-orange-500 hover:shadow-md rounded-xl p-4 cursor-pointer transition-all flex items-center justify-between group">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-sm">
                                        {{ substr($recent->order_number, -3) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $recent->order_number }}</h4>
                                        <p class="text-xs text-gray-500">
                                            @if ($recent->order_type === 'dinein' && $recent->table_number)
                                                Table {{ $recent->table_number }}
                                            @else
                                                {{ $recent->customer_name }}
                                            @endif
                                            • {{ $recent->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'preparing' => 'bg-blue-100 text-blue-800',
                                            'ready' => 'bg-green-100 text-green-800',
                                        ];
                                        $color = $statusColors[$recent->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium {{ $color }} capitalize">
                                        {{ $recent->status }}
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor"
                                        class="w-4 h-4 text-gray-400 group-hover:text-orange-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Order Result (Hidden by default) -->
            <div id="orderResult" class="hidden animate-fade-in-up">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Order Header -->
                    <div class="bg-orange-50 px-6 py-4 border-b border-orange-100 flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Order Number</p>
                            <h3 class="text-xl font-bold text-gray-900" id="resultOrderNumber"></h3>
                        </div>
                        <div class="text-right">
                            <span id="resultOrderStatus"
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"></span>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Order Info -->
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Customer Name</p>
                                <p class="font-semibold text-gray-900" id="resultCustomerName"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Order Type</p>
                                <p class="font-semibold text-gray-900 flex items-center gap-2" id="resultOrderType"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Date & Time</p>
                                <p class="font-semibold text-gray-900" id="resultOrderDate"></p>
                            </div>
                            <div id="resultNotesContainer" class="hidden">
                                <p class="text-sm text-gray-500 mb-1">Notes</p>
                                <p class="font-semibold text-gray-900" id="resultNotes"></p>
                            </div>
                        </div>

                        <!-- Items List -->
                        <div class="border rounded-xl mb-6 overflow-hidden">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-gray-500">
                                    <tr>
                                        <th class="px-4 py-3 font-medium">Item</th>
                                        <th class="px-4 py-3 font-medium text-center">Qty</th>
                                        <th class="px-4 py-3 font-medium text-right">Price</th>
                                        <th class="px-4 py-3 font-medium text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="resultOrderItems" class="divide-y divide-gray-100">
                                    <!-- Items will be inserted here -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals -->
                        <div class="flex justify-end mb-8">
                            <div class="w-64 space-y-2">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span id="resultSubtotal"></span>
                                </div>
                                <div id="resultDiscountRow" class="flex justify-between text-gray-600 hidden">
                                    <span>Discount</span>
                                    <span id="resultDiscount"></span>
                                </div>
                                <div
                                    class="border-t pt-2 flex justify-between items-center text-lg font-bold text-gray-900">
                                    <span>Total</span>
                                    <span id="resultTotal" class="text-orange-600"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Status Update Section -->
                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5 text-orange-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                Update Order Status
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <button onclick="updateStatus('preparing')"
                                    class="px-4 py-3 bg-white border-2 border-blue-200 text-blue-700 rounded-xl font-semibold hover:bg-blue-50 transition-colors">
                                    Preparing
                                </button>
                                <button onclick="updateStatus('ready')"
                                    class="px-4 py-3 bg-white border-2 border-green-200 text-green-700 rounded-xl font-semibold hover:bg-green-50 transition-colors">
                                    Ready
                                </button>
                                <button onclick="updateStatus('completed')"
                                    class="px-4 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-100 transition-colors">
                                    Completed
                                </button>
                                <button onclick="updateStatus('cancelled')"
                                    class="px-4 py-3 bg-white border-2 border-red-200 text-red-700 rounded-xl font-semibold hover:bg-red-50 transition-colors">
                                    Cancelled
                                </button>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-4">
                            <button id="cancelBtn"
                                class="flex-1 border border-gray-300 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button id="confirmPaymentBtn"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl shadow-md transition-colors flex justify-center items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                Mark as Paid
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        let currentOrderNumber = null;

        // Search order function
        async function searchOrder() {
            const orderNumber = document.getElementById('orderSearchInput').value.trim().toUpperCase();

            if (!orderNumber) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Field',
                    text: 'Please enter an order number'
                });
                return;
            }

            try {
                // Hide previous result
                document.getElementById('orderResult').classList.add('hidden');

                // Fetch order details
                const response = await fetch(`/api/admin/orders/${orderNumber}`);

                if (!response.ok) {
                    if (response.status === 404) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Not Found',
                            text: 'Order not found. Please check the order number.'
                        });
                    } else {
                        throw new Error('Failed to fetch order');
                    }
                    return;
                }

                const result = await response.json();

                if (result.success && result.data) {
                    displayOrderResult(result.data);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load order details'
                    });
                }

            } catch (error) {
                console.error('Error searching order:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while searching for the order. Please try again.'
                });
            }
        }

        // Display order result
        // ... (displayOrderResult implementation remains largely the same, but checking if it has internal alerts)
        function displayOrderResult(order) {
            // ... (no alerts inside this function typically, but checking context)
            currentOrderNumber = order.order_number;

            // Order number
            document.getElementById('resultOrderNumber').textContent = order.order_number;

            // ... (rest of display logic) ...

            // Status badge
            const statusColors = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'preparing': 'bg-blue-100 text-blue-800',
                'ready': 'bg-green-100 text-green-800',
                'completed': 'bg-gray-100 text-gray-800',
                'cancelled': 'bg-red-100 text-red-800'
            };
            const statusBadge = document.getElementById('resultOrderStatus');
            statusBadge.className =
                `inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[order.status]} capitalize`;
            statusBadge.textContent = order.status;

            // Customer info
            document.getElementById('resultCustomerName').textContent = order.customer_name || '-';

            // Order type
            const orderType = order.order_type === 'dinein' ? 'Dine In' : 'Take Away';
            let orderTypeHtml = orderType;
            if (order.order_type === 'dinein' && order.table_number) {
                orderTypeHtml +=
                    ` <span class="text-xs px-2 py-0.5 bg-gray-100 rounded text-gray-600">Table ${order.table_number}</span>`;
            }
            document.getElementById('resultOrderType').innerHTML = orderTypeHtml;

            // Date
            const date = new Date(order.created_at);
            document.getElementById('resultOrderDate').textContent = date.toLocaleString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                timeZone: 'Asia/Singapore'
            });

            // Notes
            if (order.notes) {
                document.getElementById('resultNotesContainer').classList.remove('hidden');
                document.getElementById('resultNotes').textContent = order.notes;
            } else {
                document.getElementById('resultNotesContainer').classList.add('hidden');
            }

            // Order items
            const itemsContainer = document.getElementById('resultOrderItems');
            itemsContainer.innerHTML = '';

            let subtotal = 0;
            if (order.order_items && order.order_items.length > 0) {
                order.order_items.forEach(item => {
                    subtotal += parseFloat(item.subtotal);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-3 text-gray-900">${item.product_name}</td>
                        <td class="px-4 py-3 text-center">${item.quantity}</td>
                        <td class="px-4 py-3 text-right">Rp${parseInt(item.price).toLocaleString('id-ID')}</td>
                        <td class="px-4 py-3 text-right font-medium">Rp${parseInt(item.subtotal).toLocaleString('id-ID')}</td>
                    `;
                    itemsContainer.appendChild(row);
                });
            }

            // Totals
            document.getElementById('resultSubtotal').textContent = `Rp${subtotal.toLocaleString('id-ID')}`;

            if (order.discount && parseFloat(order.discount) > 0) {
                document.getElementById('resultDiscountRow').classList.remove('hidden');
                document.getElementById('resultDiscount').textContent =
                    `-Rp${parseFloat(order.discount).toLocaleString('id-ID')}`;
            } else {
                document.getElementById('resultDiscountRow').classList.add('hidden');
            }

            document.getElementById('resultTotal').textContent =
                `Rp${parseInt(order.total_amount).toLocaleString('id-ID')}`;

            // Show result
            document.getElementById('orderResult').classList.remove('hidden');

            // Scroll to result
            document.getElementById('orderResult').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        // Update order status
        async function updateStatus(newStatus) {
            if (!currentOrderNumber) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Selection',
                    text: 'No order selected'
                });
                return;
            }

            Swal.fire({
                title: 'Update Status?',
                text: `Are you sure you want to update status to "${newStatus}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/api/admin/orders/${currentOrderNumber}/status`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        });

                        if (!response.ok) {
                            throw new Error('Failed to update status');
                        }

                        const result = await response.json();

                        if (result.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'Order status updated successfully!',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            // Refresh order display
                            displayOrderResult(result.data);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update order status'
                            });
                        }

                    } catch (error) {
                        console.error('Error updating status:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while updating the order status. Please try again.'
                        });
                    }
                }
            });
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', () => {
            const searchBtn = document.getElementById('searchBtn');
            const searchInput = document.getElementById('orderSearchInput');
            const cancelBtn = document.getElementById('cancelBtn');
            const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');

            // Search button
            searchBtn.addEventListener('click', searchOrder);

            // Enter key on search input
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    searchOrder();
                }
            });

            // Cancel button
            cancelBtn.addEventListener('click', () => {
                document.getElementById('orderResult').classList.add('hidden');
                document.getElementById('orderSearchInput').value = '';
                currentOrderNumber = null;
            });

            // Confirm payment (change status to preparing)
            confirmPaymentBtn.addEventListener('click', () => {
                if (!currentOrderNumber) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Selection',
                        text: 'No order selected'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Confirm Payment?',
                    text: 'Are you sure you want to mark this order as paid?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10B981', // green-500
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm Payment!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateStatus('preparing');
                    }
                });
            });
        });
    </script>
@endpush
