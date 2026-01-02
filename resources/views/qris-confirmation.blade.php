<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Start Order - Warung Bali Sangeh</title>
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
    <div class="w-full max-w-[500px] bg-white min-h-screen relative shadow-2xl flex flex-col">
        <!-- Sticky Header -->
        <div class="sticky top-0 z-50 bg-white border-b border-gray-100 px-4 py-3 flex items-center mb-2">
            <button class="absolute left-4 p-1 hover:bg-gray-100 rounded-full transition-colors"
                onclick="window.history.back()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6 text-gray-800">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </button>
            <h1 class="font-bold text-lg text-gray-800 w-full text-center">QRIS</h1>
        </div>

        <div class="flex-1 overflow-y-auto px-4 pb-8 no-scrollbar">
            <!-- Timer Section -->
            <div class="text-center mb-6 mt-2">
                <p class="text-gray-600 font-semibold mb-1">Selesaikan pembayaran dalam</p>
                <div class="text-3xl font-bold text-gray-900" id="countdownTimer">09:37</div>
            </div>

            <!-- QR Section -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center mb-6 relative overflow-hidden">
                <!-- Logos -->
                <div class="flex items-center justify-between w-full mb-4 px-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png"
                        alt="QRIS" class="h-8 object-contain">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_GPN_Baru.svg/2560px-Logo_GPN_Baru.svg.png"
                        alt="GPN" class="h-8 object-contain">
                </div>

                <h2 class="font-bold text-gray-900 text-lg mb-4 text-center">Warung Bali Sangeh</h2>

                <!-- QR Code Container -->
                <div class="relative w-64 h-64 bg-gray-50 mb-6 p-2">
                    <!-- Decorative Corners -->
                    <div class="absolute top-0 left-0 w-16 h-16 border-l-4 border-t-4 border-red-500 rounded-tl-3xl">
                    </div>
                    <div
                        class="absolute bottom-0 right-0 w-16 h-16 border-r-4 border-b-4 border-red-500 rounded-br-3xl">
                    </div>

                    <!-- QR Image Placeholder -->
                    <img id="qrisImage"
                        src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg"
                        alt="QR Code" class="w-full h-full object-contain z-10 relative bg-white">
                </div>

                <div class="text-center w-full">
                    <p class="text-gray-500 text-sm mb-1">Total Pembayaran</p>
                    <p id="totalPaymentDisplay" class="text-2xl font-bold text-gray-900">Rp0</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 mb-8">
                <button id="checkPaymentBtn"
                    class="flex-1 bg-[#f05a28] hover:bg-[#d94a1c] text-white font-bold py-3 px-4 rounded-xl shadow-md transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                    Cek Status Pembayaran
                </button>
                <button id="downloadQrisBtn"
                    class="px-4 py-3 border border-orange-200 rounded-xl text-[#f05a28] hover:bg-orange-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </button>
            </div>

            <!-- How to Pay Section -->
            <div class="mb-8">
                <h3 class="font-bold text-gray-900 text-lg mb-4">Cara Pembayaran:</h3>

                <!-- Tabs -->
                <div class="flex border-b border-gray-200 mb-6">
                    <button
                        class="flex-1 pb-3 text-[#f05a28] border-b-2 border-[#f05a28] font-semibold flex items-center justify-center gap-2 tab-btn"
                        data-target="same-phone">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                        Bayar dengan HP ini
                    </button>
                    <button class="flex-1 pb-3 text-gray-400 font-medium flex items-center justify-center gap-2 tab-btn"
                        data-target="other-phone">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                        Bayar dengan HP Lain
                    </button>
                </div>

                <!-- Tab Panels -->
                <div id="same-phone" class="tab-panel space-y-6">
                    <!-- Step 1 -->
                    <div class="flex items-start gap-4">
                        <div class="bg-orange-50 p-2 rounded-lg shrink-0">
                            <!-- Icon Download -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#f05a28]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-800 leading-snug"><span class="font-bold">1. Klik</span> tombol download
                                untuk menyimpan gambar / layar QRIS code</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex items-start gap-4">
                        <div class="bg-orange-50 p-2 rounded-lg shrink-0">
                            <!-- Icon Mobile Pay -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#f05a28]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-800 leading-snug"><span class="font-bold">2. Buka QR payment</span> di
                                m-banking atau e-wallet</p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex items-start gap-4">
                        <div class="bg-orange-50 p-2 rounded-lg shrink-0">
                            <!-- Icon Upload -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#f05a28]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-800 leading-snug"><span class="font-bold">3. Upload</span> QR Code
                                foto/layar tangkapan</p>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="flex items-start gap-4">
                        <div class="bg-orange-50 p-2 rounded-lg shrink-0">
                            <!-- Icon Check -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#f05a28]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.25v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-800 leading-snug"><span class="font-bold">4. Cek</span> menu transaksi
                                QRIS lalu
                                lakukan pembayaran</p>
                        </div>
                    </div>
                    <!-- Step 5 -->
                    <div class="flex items-start gap-4">
                        <div class="bg-orange-50 p-2 rounded-lg shrink-0">
                            <!-- Icon Status -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#f05a28]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-800 leading-snug">5. <span class="font-bold">Klik</span> tombol
                                "Cek Status Pembayaran"</p>
                        </div>
                    </div>
                </div>

                <div id="other-phone" class="tab-panel hidden space-y-6">
                    <div class="p-4 bg-gray-50 rounded-xl text-center text-gray-500">
                        Scan QRIS code di layar dengan HP yang lain
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired Session Overlay -->
        <div id="expiredOverlay"
            class="absolute inset-0 z-[60] bg-white flex-col items-center justify-center p-6 hidden">
            <div class="w-40 h-40 mb-6 relative">
                <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-536.jpg"
                    alt="Session Expired" class="w-full h-full object-contain">
            </div>
            <h2 class="font-bold text-gray-900 text-lg mb-2 text-center">Sorry, payment session expired</h2>
            <p class="text-gray-500 text-center mb-8 px-4 leading-relaxed">
                Your payment session has expired, please try again.
            </p>
            <button onclick="window.history.back()"
                class="w-full bg-[#f05a28] hover:bg-[#d94a1c] text-white font-bold py-3.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                Change Payment Method
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Get amount and order number from local storage
                const amount = localStorage.getItem('wbs_payment_amount') || 0;
                const orderNumber = localStorage.getItem('wbs_order_number');

                // Update amount display
                const totalPaymentDisplay = document.getElementById('totalPaymentDisplay');
                if (totalPaymentDisplay && amount) {
                    totalPaymentDisplay.textContent = `Rp${parseInt(amount).toLocaleString('id-ID')}`;
                }

                // --- Timer Logic ---
                // For demo purposes, you might want to set this lower to test
                let timeLeft = 10 * 60; // 10 minutes
                const timerElement = document.getElementById('countdownTimer');
                const expiredOverlay = document.getElementById('expiredOverlay');

                function updateTimer() {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;

                    timerElement.textContent =
                        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    if (timeLeft > 0) {
                        timeLeft--;
                    } else {
                        clearInterval(timerInterval);
                        // Show expired overlay
                        if (expiredOverlay) {
                            expiredOverlay.classList.remove('hidden');
                            expiredOverlay.classList.add('flex');
                        }
                    }
                }

                updateTimer(); // Initial call
                const timerInterval = setInterval(updateTimer, 1000);

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
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

                // --- Tab Logic ---
                const tabBtns = document.querySelectorAll('.tab-btn');
                const tabPanels = document.querySelectorAll('.tab-panel');

                tabBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        // Update buttons
                        tabBtns.forEach(b => {
                            b.classList.remove('text-[#f05a28]', 'border-b-2',
                                'border-[#f05a28]', 'font-semibold');
                            b.classList.add('text-gray-400', 'font-medium');
                        });
                        btn.classList.add('text-[#f05a28]', 'border-b-2', 'border-[#f05a28]',
                            'font-semibold');
                        btn.classList.remove('text-gray-400', 'font-medium');

                        // Show content
                        const targetId = btn.getAttribute('data-target');
                        tabPanels.forEach(panel => {
                            if (panel.id === targetId) {
                                panel.classList.remove('hidden');
                            } else {
                                panel.classList.add('hidden');
                            }
                        });
                    });
                });
            });

            // Download QRIS Image Function
            document.getElementById('downloadQrisBtn').addEventListener('click', function() {
                const qrisImage = document.getElementById('qrisImage');
                const orderNumber = localStorage.getItem('wbs_order_number') || 'QRIS';

                // Create a canvas to convert the image
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Create a new image to handle cross-origin
                const img = new Image();
                img.crossOrigin = 'anonymous';

                img.onload = function() {
                    // Set canvas size to match image
                    canvas.width = img.width;
                    canvas.height = img.height;

                    // Draw image on canvas
                    ctx.drawImage(img, 0, 0);

                    // Convert to blob and download
                    canvas.toBlob(function(blob) {
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = `QRIS-${orderNumber}.png`;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);
                    });
                };

                // If cross-origin fails, try direct download
                img.onerror = function() {
                    const link = document.createElement('a');
                    link.href = qrisImage.src;
                    link.download = `QRIS-${orderNumber}.png`;
                    link.target = '_blank';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                };

                img.src = qrisImage.src;
            });
        </script>
    </div>
</body>

</html>
