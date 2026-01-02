<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Summary - Warung Bali Sangeh</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex justify-center">
    <!-- Mobile Container Wrapper -->
    <div class="w-full max-w-[500px] bg-white min-h-screen relative shadow-2xl pb-24 mx-auto">
        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-50 bg-white border-b border-gray-100 px-4 py-3 flex items-center justify-center mb-2">
            <h1 class="font-bold text-lg text-gray-800">Detail Pesanan</h1>
        </div>

        <!-- Content -->
        <div class="px-4 space-y-6">
            <!-- Order Type -->
            <div
                class="w-full bg-orange-50 border border-orange-400 rounded-lg px-4 py-2 flex items-center justify-between">
                <span class="text-gray-700 text-sm font-medium">Jenis Pesanan</span>
                <div class="flex items-center gap-1">
                    <span id="orderTypeText" class="font-bold text-gray-900 text-sm">Takeaway</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-green-600">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <!-- Order Number & QR -->
            <div class="flex flex-col items-center">
                <p class="text-gray-600 text-sm mb-2">Nomor Pesanan</p>
                <div class="flex bg-gray-100 rounded-lg p-1 mb-6">
                    <button id="orderNumberDisplay"
                        class="px-4 py-1.5 bg-white text-gray-900 font-bold text-sm rounded-md shadow-sm">LOADING...</button>
                </div>

                <!-- QR Code Wrapper -->
                <div class="w-48 h-48 mb-6">
                    <img id="qrCodeImage" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=LOADING"
                        alt="Order QR Code" class="w-full h-full">
                </div>

                <!-- Warning Box -->
                <div class="w-full bg-[#fff8de] rounded-lg p-3 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-orange-600 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <p class="text-sm font-bold text-gray-800 leading-tight">
                        Tunjukkan QR code atau <span class="text-gray-900">8-digit nomor pesanan</span> kepada kasir.
                    </p>
                </div>
            </div>

            <!-- Ordered Items -->
            <div>
                <h2 class="font-bold text-gray-900 mb-3 text-sm">Menu yang Dipesan</h2>
                <div id="orderItemsContainer" class="space-y-3">
                    <!-- Items will be dynamically inserted here -->
                </div>

                <!-- Payment Summary -->
                <div class="space-y-1 text-sm pb-4 border-b border-dashed border-gray-200 mt-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal <span id="menuCountText" class="text-gray-400">(0 menu)</span></span>
                        <span id="subtotalPrice" class="font-semibold text-gray-800">Rp0</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Pembulatan</span>
                        <span id="roundingPrice" class="font-semibold text-gray-800">Rp0</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Pajak 10% <span class="inline-block align-middle"><svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 text-gray-400">
                                    {{-- <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" /> --}}
                                </svg></span></span>
                        <span id="otherFeesPrice" class="font-bold text-gray-800">Rp0</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-3">
                    <span class="font-bold text-gray-900 text-sm">Total</span>
                    <span id="totalPrice" class="font-bold text-orange-600 text-sm">Rp0</span>
                </div>
            </div>

            <!-- Check Payment Status Button -->
            <div class="pt-4 pb-8">
                <button id="checkPaymentBtn"
                    class="w-full bg-[#f05a28] hover:bg-[#d94a1c] text-white font-bold py-3 rounded-lg shadow-md transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                    Cek Status Pembayaran
                </button>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const mode = urlParams.get('mode') || 'takeaway';
            const table = urlParams.get('table');

            // Get cart from localStorage
            const cart = JSON.parse(localStorage.getItem('wbs_cart')) || {};
            const amount = localStorage.getItem('wbs_payment_amount') || 0;

            // ============================================
            // IDEMPOTENCY SYSTEM
            // ============================================
            // Generate or retrieve order token to ensure idempotency
            // This prevents duplicate orders if user refreshes the page
            let orderToken = sessionStorage.getItem('wbs_order_token');

            if (!orderToken) {
                // Generate a new unique order token only if one doesn't exist
                const timestamp = Date.now();
                const random = Math.random().toString(36).substr(2, 5).toUpperCase();
                orderToken = `${timestamp}-${random}`;
                sessionStorage.setItem('wbs_order_token', orderToken);

                // Store order creation timestamp
                sessionStorage.setItem('wbs_order_created_at', new Date().toISOString());
            }

            // Generate order number from localStorage or fallback to 8-char format
            let orderNumber = localStorage.getItem('wbs_order_number');
            if (!orderNumber) {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                let code = '';
                for (let i = 0; i < 5; i++) code += chars.charAt(Math.floor(Math.random() * chars.length));
                orderNumber = `ORD${code}`;
                localStorage.setItem('wbs_order_number', orderNumber);
            }

            // Update QR Code
            const qrCodeImage = document.getElementById('qrCodeImage');
            if (qrCodeImage) {
                qrCodeImage.src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${orderNumber}`;
            }

            // Update Order Number Display
            const orderNumberDisplay = document.getElementById('orderNumberDisplay');
            if (orderNumberDisplay) {
                orderNumberDisplay.textContent = orderNumber;
            }

            // Update Order Type
            const orderTypeText = document.getElementById('orderTypeText');
            if (orderTypeText) {
                if (mode === 'dinein') {
                    orderTypeText.textContent = table ? `Dine In - Table ${table}` : 'Dine In';
                } else {
                    orderTypeText.textContent = 'Takeaway';
                }
            }

            // Render Cart Items
            const orderItemsContainer = document.getElementById('orderItemsContainer');
            let subtotal = 0;
            let totalItems = 0;

            if (orderItemsContainer) {
                orderItemsContainer.innerHTML = '';

                for (const itemId in cart) {
                    const item = cart[itemId];
                    subtotal += item.price * item.quantity;
                    totalItems += item.quantity;

                    const itemElement = document.createElement('div');
                    itemElement.className = 'border-b border-gray-100 pb-3';
                    itemElement.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-1">
                                    <span class="font-bold text-gray-900 text-sm">${item.quantity}x</span>
                                    <h3 class="font-normal text-gray-700 text-sm">${item.name}</h3>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Rp${(item.price * item.quantity).toLocaleString('id-ID')}</span>
                        </div>
                    `;
                    orderItemsContainer.appendChild(itemElement);
                }
            }

            // Calculate payment details
            const otherFees = Math.round(subtotal * 0.1);
            const tempTotal = subtotal + otherFees;
            const remainder = tempTotal % 500;
            const rounding = remainder > 0 ? -remainder : 0;
            const finalTotal = tempTotal + rounding;

            // Update UI
            const menuCountText = document.getElementById('menuCountText');
            const subtotalPrice = document.getElementById('subtotalPrice');
            const roundingPrice = document.getElementById('roundingPrice');
            const otherFeesPrice = document.getElementById('otherFeesPrice');
            const totalPrice = document.getElementById('totalPrice');

            if (menuCountText) menuCountText.textContent = `(${totalItems} menu)`;
            if (subtotalPrice) subtotalPrice.textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
            if (roundingPrice) {
                if (rounding < 0) {
                    roundingPrice.textContent = `-Rp${Math.abs(rounding).toLocaleString('id-ID')}`;
                } else {
                    roundingPrice.textContent = `Rp${rounding.toLocaleString('id-ID')}`;
                }
            }
            if (otherFeesPrice) otherFeesPrice.textContent = `Rp${otherFees.toLocaleString('id-ID')}`;
            if (totalPrice) totalPrice.textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;

            // --- Check Payment Status Logic ---
            const checkPaymentBtn = document.getElementById('checkPaymentBtn');

            if (checkPaymentBtn) {
                checkPaymentBtn.addEventListener('click', async () => {
                    if (!orderNumber) {
                        alert('Order number not found. Please try again.');
                        return;
                    }

                    // Disable button and show loading state
                    checkPaymentBtn.disabled = true;
                    const originalText = checkPaymentBtn.textContent;
                    checkPaymentBtn.textContent = 'Checking...';

                    try {
                        // Fetch order status from API
                        const response = await fetch(`/api/order/${orderNumber}`);

                        if (!response.ok) {
                            throw new Error('Failed to fetch order status');
                        }

                        const result = await response.json();

                        if (result.success && result.data) {
                            // Update order status to 'preparing' if still 'pending'
                            if (result.data.status === 'pending') {
                                const updateResponse = await fetch(`/api/order/${result.data.id}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]')?.getAttribute(
                                            'content') || ''
                                    },
                                    body: JSON.stringify({
                                        order_number: orderNumber
                                    })
                                });

                                if (!updateResponse.ok) {
                                    console.error('Failed to update order status');
                                } else {
                                    const updateResult = await updateResponse.json();
                                    // Update local data with new status
                                    result.data = updateResult.data;
                                }
                            }

                            // Store order data in localStorage
                            localStorage.setItem('wbs_order_data', JSON.stringify(result.data));

                            // Redirect to success page
                            window.location.href = '/order-success';
                        } else {
                            alert('Failed to retrieve order information. Please try again.');
                            checkPaymentBtn.disabled = false;
                            checkPaymentBtn.textContent = originalText;
                        }
                    } catch (error) {
                        console.error('Error checking payment status:', error);
                        alert('An error occurred while checking payment status. Please try again.');
                        checkPaymentBtn.disabled = false;
                        checkPaymentBtn.textContent = originalText;
                    }
                });
            }
        });
    </script>
</body>

</html>
