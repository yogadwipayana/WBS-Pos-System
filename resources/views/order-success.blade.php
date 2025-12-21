<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - Warung Bali Sangeh</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    @endif
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex justify-center">
    <!-- Mobile Container Wrapper -->
    <div class="w-full max-w-[500px] bg-white min-h-screen relative shadow-2xl flex flex-col">
        <!-- Sticky Header -->
        <div class="sticky top-0 z-50 bg-white border-b border-gray-100 px-4 py-3 flex items-center mb-2">
            <h1 class="font-bold text-lg text-gray-800 w-full text-center">Order Status</h1>
        </div>

        <div class="flex-1 overflow-y-auto px-4 pb-8 no-scrollbar">
            <!-- Success Icon -->
            <div class="flex flex-col items-center justify-center mt-8 mb-6">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-12 h-12 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="font-bold text-gray-900 text-2xl mb-2 text-center">Payment Successful!</h2>
                <p class="text-gray-500 text-center">Your order has been confirmed</p>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="font-bold text-gray-900 text-lg mb-4">Order Details</h3>

                <!-- Order Number -->
                <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-100">
                    <span class="text-gray-600">Order Number</span>
                    <span id="orderNumber" class="font-semibold text-gray-900">-</span>
                </div>

                <!-- Customer Name -->
                <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-100">
                    <span class="text-gray-600">Customer Name</span>
                    <span id="customerName" class="font-semibold text-gray-900">-</span>
                </div>

                <!-- Order Type -->
                <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-100">
                    <span class="text-gray-600">Order Type</span>
                    <span id="orderType" class="font-semibold text-gray-900">-</span>
                </div>

                <!-- Table Number (if dine-in) -->
                <div id="tableNumberRow"
                    class="flex justify-between items-center mb-3 pb-3 border-b border-gray-100 hidden">
                    <span class="text-gray-600">Table Number</span>
                    <span id="tableNumber" class="font-semibold text-gray-900">-</span>
                </div>

                <!-- Status -->
                <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-100">
                    <span class="text-gray-600">Status</span>
                    <span id="orderStatus" class="font-semibold text-green-600 capitalize">-</span>
                </div>

                <!-- Total Amount -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 font-semibold">Total Amount</span>
                    <span id="totalAmount" class="font-bold text-xl text-gray-900">Rp0</span>
                </div>
            </div>

            <!-- Notes (if any) -->
            <div id="notesSection" class="bg-orange-50 rounded-xl p-4 mb-6 hidden">
                <h4 class="font-semibold text-gray-900 mb-2">Notes:</h4>
                <p id="orderNotes" class="text-gray-700 text-sm leading-relaxed"></p>
            </div>

            <!-- Status Message -->
            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-blue-600 shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <div>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            Pesanan sedang disiapkan. Silahkan klik tombol di bawah untuk mengecek status pesanan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button id="checkStatusBtn" onclick="checkOrderStatus()"
                    class="w-full bg-[#f05a28] hover:bg-[#d94a1c] text-white font-bold py-3.5 px-6 rounded-xl shadow-md transition-all active:scale-95 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span id="checkStatusText">Check Status Pesanan</span>
                </button>

                <!-- Warning Information -->
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6 text-yellow-600 shrink-0 mt-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-bold text-yellow-900 mb-1">Perhatian!</h4>
                            <p class="text-sm text-yellow-800 leading-relaxed">
                                Jika Anda keluar dari halaman ini, Anda tidak bisa mengecek status pesanan lagi.
                                <span class="font-semibold">Catat nomor pesanan Anda terlebih dahulu</span> sebelum
                                meninggalkan halaman.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Modal -->
    <div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <!-- Modal Header -->
            <div id="modalHeader" class="p-6 rounded-t-2xl">
                <div class="flex items-center justify-center mb-4">
                    <div id="statusIcon" class="w-16 h-16 rounded-full flex items-center justify-center">
                        <!-- Icon will be inserted here -->
                    </div>
                </div>
                <h3 id="modalTitle" class="text-2xl font-bold text-center mb-2"></h3>
                <p id="modalMessage" class="text-center text-gray-600"></p>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 pt-0">
                <button onclick="closeStatusModal()"
                    class="w-full bg-[#f05a28] hover:bg-[#d94a1c] text-white font-bold py-3 px-6 rounded-xl transition-all active:scale-95">
                    OK, Mengerti
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get order data from localStorage
            const orderData = localStorage.getItem('wbs_order_data');

            if (!orderData) {
                // If no order data, redirect to home
                window.location.href = '/';
                return;
            }

            try {
                const order = JSON.parse(orderData);

                // Populate order details
                document.getElementById('orderNumber').textContent = order.order_number || '-';
                document.getElementById('customerName').textContent = order.customer_name || '-';
                document.getElementById('orderType').textContent = order.order_type === 'dinein' ? 'Dine In' :
                    'Take Away';

                // Show table number if dine-in
                if (order.order_type === 'dinein' && order.table_number) {
                    document.getElementById('tableNumberRow').classList.remove('hidden');
                    document.getElementById('tableNumber').textContent = order.table_number;
                }

                // Status
                const statusElement = document.getElementById('orderStatus');
                statusElement.textContent = order.status || 'pending';

                // Set status color
                if (order.status === 'preparing') {
                    statusElement.classList.remove('text-green-600');
                    statusElement.classList.add('text-blue-600');
                } else if (order.status === 'ready') {
                    statusElement.classList.remove('text-green-600');
                    statusElement.classList.add('text-green-600');
                } else if (order.status === 'completed') {
                    statusElement.classList.remove('text-green-600');
                    statusElement.classList.add('text-gray-600');
                }

                // Total Amount
                document.getElementById('totalAmount').textContent =
                    `Rp${parseInt(order.total_amount || 0).toLocaleString('id-ID')}`;

                // Notes
                if (order.notes) {
                    document.getElementById('notesSection').classList.remove('hidden');
                    document.getElementById('orderNotes').textContent = order.notes;
                }

                // Clear cart and session data (keep only order data for checking status)
                // Clear all cart-related items
                localStorage.removeItem('wbs_cart');
                localStorage.removeItem('wbs_cart_count');
                localStorage.removeItem('wbs_customer_name');
                localStorage.removeItem('wbs_customer_phone');
                localStorage.removeItem('wbs_table_number');
                localStorage.removeItem('wbs_order_type');
                localStorage.removeItem('wbs_notes');

                // Clear session storage
                sessionStorage.clear();

            } catch (error) {
                console.error('Error parsing order data:', error);
                window.location.href = '/';
            }
        });

        // Function to check order status
        async function checkOrderStatus() {
            const orderData = localStorage.getItem('wbs_order_data');

            if (!orderData) {
                alert('No order data found');
                return;
            }

            const btn = document.getElementById('checkStatusBtn');
            const btnText = document.getElementById('checkStatusText');
            const originalText = btnText.textContent;

            // Show loading state
            btn.disabled = true;
            btnText.textContent = 'Checking...';

            try {
                const order = JSON.parse(orderData);
                const response = await fetch(`/api/order/${order.order_number}`);
                const result = await response.json();

                if (result.success && result.data) {
                    const currentOrder = result.data;
                    const status = currentOrder.status;

                    // Update status on page
                    const statusElement = document.getElementById('orderStatus');
                    statusElement.textContent = status;

                    // Update status color
                    statusElement.className = 'font-semibold capitalize';
                    if (status === 'preparing') {
                        statusElement.classList.add('text-blue-600');
                    } else if (status === 'ready') {
                        statusElement.classList.add('text-green-600');
                    } else if (status === 'completed') {
                        statusElement.classList.add('text-gray-600');
                    } else {
                        statusElement.classList.add('text-yellow-600');
                    }

                    // Show status message
                    if (status === 'ready') {
                        showStatusModal('ready', 'Pesanan Siap Diambil!',
                            'Pesanan Anda sudah READY! Silakan ambil pesanan Anda di kasir.');
                    } else if (status === 'completed') {
                        showStatusModal('completed', 'Pesanan Selesai',
                            'Pesanan Anda sudah COMPLETED! Terima kasih telah memesan di Warung Bali Sangeh.');
                    } else if (status === 'preparing') {
                        showStatusModal('preparing', 'Sedang Diproses',
                            'Pesanan Anda masih dalam proses PREPARING. Mohon tunggu sebentar ya!');
                    } else if (status === 'pending') {
                        showStatusModal('pending', 'Menunggu Proses',
                            'Pesanan Anda masih PENDING. Akan segera diproses oleh kitchen.');
                    }

                    // Update localStorage with latest data
                    localStorage.setItem('wbs_order_data', JSON.stringify(currentOrder));
                } else {
                    showStatusModal('error', 'Gagal Mengecek Status',
                        'Tidak dapat mengecek status pesanan. Silakan coba lagi.');
                }
            } catch (error) {
                console.error('Error checking order status:', error);
                showStatusModal('error', 'Terjadi Kesalahan',
                    'Gagal mengecek status pesanan. Silakan coba lagi nanti.');
            } finally {
                // Reset button state
                btn.disabled = false;
                btnText.textContent = originalText;
            }
        }

        // Function to show status modal
        function showStatusModal(status, title, message) {
            const modal = document.getElementById('statusModal');
            const modalHeader = document.getElementById('modalHeader');
            const statusIcon = document.getElementById('statusIcon');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');

            // Configure modal based on status
            let headerBg, iconBg, iconSvg;

            switch (status) {
                case 'ready':
                    headerBg = 'bg-green-50';
                    iconBg = 'bg-green-100';
                    iconSvg =
                        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-green-600"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                    break;
                case 'completed':
                    headerBg = 'bg-gray-50';
                    iconBg = 'bg-gray-100';
                    iconSvg =
                        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-gray-600"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>';
                    break;
                case 'preparing':
                    headerBg = 'bg-blue-50';
                    iconBg = 'bg-blue-100';
                    iconSvg =
                        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-blue-600"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" /></svg>';
                    break;
                case 'pending':
                    headerBg = 'bg-yellow-50';
                    iconBg = 'bg-yellow-100';
                    iconSvg =
                        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-yellow-600"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                    break;
                case 'error':
                    headerBg = 'bg-red-50';
                    iconBg = 'bg-red-100';
                    iconSvg =
                        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-red-600"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>';
                    break;
            }

            // Apply styles
            modalHeader.className = `p-6 rounded-t-2xl ${headerBg}`;
            statusIcon.className = `w-16 h-16 rounded-full flex items-center justify-center ${iconBg}`;
            statusIcon.innerHTML = iconSvg;
            modalTitle.textContent = title;
            modalMessage.textContent = message;

            // Show modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Function to close status modal
        function closeStatusModal() {
            const modal = document.getElementById('statusModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</body>

</html>
