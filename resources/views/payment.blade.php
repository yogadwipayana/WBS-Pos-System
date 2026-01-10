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
    <div class="w-full max-w-[500px] bg-white min-h-screen relative shadow-2xl pb-32">
        <!-- Sticky Header -->
        <div class="sticky top-0 z-50 bg-white border-b border-gray-100 px-4 py-3 flex items-center mb-2">
            <button onclick="window.history.back()"
                class="absolute left-4 p-1 hover:bg-gray-100 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6 text-gray-800">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </button>
            <h1 class="font-bold text-lg text-gray-800 w-full text-center">Pembayaran</h1>
        </div>

        <!-- Content -->
        <div class="px-4 space-y-6">
            <!-- Order Type -->
            <div
                class="w-full bg-orange-50 border border-orange-400 rounded-lg px-4 py-2 flex items-center justify-between">
                <span class="text-gray-700 text-sm font-medium">Jenis Pesanan</span>
                <div class="flex items-center gap-1">
                    <span id="orderTypeText" class="font-bold text-gray-900 text-sm">Pick Up</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4 text-gray-800">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>

            <!-- Customer Information -->
            <div>
                <h2 class="font-bold text-gray-900 mb-4">Informasi Pelanggan</h2>
                <form class="space-y-4">
                    <!-- Full Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama<span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <input id="fullNameInput" type="text"
                                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 placeholder-gray-400 transition-colors"
                                placeholder="Nama">
                        </div>
                    </div>

                    <!-- Phone Number -->
                    {{-- <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Telepon (untuk fitur
                            mendatang
                            promos)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                            </div>
                            <input type="tel"
                                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 placeholder-gray-400 transition-colors"
                                placeholder="Phone Number">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Send Receipt to Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input type="email"
                                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 placeholder-gray-400 transition-colors"
                                placeholder="Email">
                        </div>
                    </div> --}}

                    <!-- Table Number -->
                    <div id="tableNumberField">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Meja<span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </svg>
                            </div>
                            <input id="tableNumberInput" type="text"
                                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 placeholder-gray-400 transition-colors"
                                value="">
                        </div>
                    </div>
                </form>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Payment Method -->
            <div>
                <h2 class="font-bold text-gray-900 mb-3">Metode Pembayaran</h2>
                <div class="flex gap-3">
                    <!-- Online Payment Button -->
                    <button id="btnOnline"
                        class="flex-1 border rounded-xl p-3 flex items-center justify-center gap-2 transition-all relative overflow-hidden border-orange-500 bg-orange-50 text-orange-600">
                        <div class="w-8 h-8 rounded bg-yellow-100 flex items-center justify-center">
                            <!-- Placeholder Icon for Card/Online -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-yellow-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                        </div>
                        <span class="font-semibold text-sm">Bayar Online</span>
                        <!-- Checkmark for selected state -->
                        <div class="absolute -bottom-1 -right-1 bg-green-500 rounded-full p-0.5 border-2 border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-3 h-3 text-white">
                                <path fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <!-- Cashier Payment Button -->
                    <button id="btnCashier" onclick="handleCashierPayment()"
                        class="flex-1 border rounded-xl p-3 flex items-center justify-center gap-2 transition-all relative overflow-hidden border-gray-200 bg-white text-gray-600 hover:bg-gray-50">
                        <div class="w-8 h-8 rounded bg-green-100 flex items-center justify-center">
                            <!-- Placeholder Icon for Cash -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="font-semibold text-sm">Bayar di Kasir</span>
                    </button>
                </div>
            </div>


            <!-- Complete Payment Section (Online Only) -->
            <div id="onlinePaymentSection">
                <h2 class="font-bold text-gray-900 mb-3">Pembayaran Online</h2>
                <div id="qrisOption"
                    class="border rounded-xl p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75zM16.5 19.5h.75v.75h-.75v-.75z" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">QRIS</span>
                    </div>
                    <input type="radio" id="qrisRadio" name="paymentMethod"
                        class="w-5 h-5 text-orange-500 focus:ring-orange-500 border-gray-300 cursor-pointer">
                </div>
            </div>

            <!-- Illustration & Instruction (Cashier Only) -->
            <div id="cashierInstructionSection" class="hidden flex-col items-center justify-center pt-4 pb-4">
                <div class="w-48 h-48 mb-4 relative">
                    <!-- Placeholder for the flat illustration in the reference -->
                    <img src="https://esborder.qs.esb.co.id/assets/images/cashier.png" alt="Pay at Cashier"
                        class="w-full h-full object-contain">
                </div>
                <p class="text-gray-800 text-sm text-center font-medium">
                    Klik '<strong>Bayar di Kasir</strong>' dan tunjukkan kode QR ke kasir.
                </p>
            </div>

            <!-- Promo Section -->
            {{-- <div
                class="bg-orange-50 border border-orange-100 rounded-xl p-4 flex items-center justify-between cursor-pointer hover:bg-orange-100 transition-colors">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-orange-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v2.25c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                    </svg>
                    <span class="font-bold text-orange-600">Add Promos or Vouchers</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4 text-orange-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </div> --}}
        </div>

        <!-- Validation Modal Overlay -->
        <div id="validationModalOverlay"
            class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[60] hidden transition-opacity duration-300 opacity-0">
        </div>

        <!-- Validation Modal Content -->
        <div id="validationModal" class="fixed inset-0 z-[70] flex justify-center items-center pointer-events-none">
            <div
                class="w-full max-w-[350px] bg-white rounded-3xl p-6 shadow-2xl pointer-events-auto flex flex-col items-center text-center m-4 transform transition-transform duration-300 translate-y-[100vh]">
                <!-- Illustration -->
                <div class="w-40 h-40 mb-2">
                    <img src="https://img.freepik.com/free-vector/warning-concept-illustration_114360-1551.jpg"
                        alt="Alert" class="w-full h-full object-contain">
                </div>
                <!-- Text -->
                <p class="text-gray-800 font-medium mb-6 leading-relaxed px-4">
                    Tambahkan nama Anda, ini membantu kami mengkonfirmasi pesanan Anda dengan mudah.
                </p>
                <!-- Button -->
                <button id="closeValidationBtn"
                    class="w-full bg-[#f05a28] hover:bg-[#d94a1c] text-white font-bold py-3 rounded-xl shadow-md transition-all active:scale-95">
                    Ok
                </button>
            </div>
        </div>

        <!-- Sticky Bottom Bar -->
        <div class="fixed bottom-0 left-0 right-0 z-50 flex justify-center pointer-events-none">
            <div
                class="w-full max-w-[500px] bg-white border-t border-gray-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] pointer-events-auto rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2 cursor-pointer">
                        <div>
                            <div class="flex items-center gap-1">
                                <p class="text-sm text-gray-700 font-semibold">Total Pembayaran</p>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-700">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                </svg>
                            </div>
                            <p id="paymentTotalAmount" class="text-xl font-bold text-gray-900 leading-tight">Rp0</p>
                        </div>
                    </div>
                    <button id="mainPayBtn"
                        class="bg-[#f05a28] hover:bg-[#d94a1c] text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all active:scale-95 flex-1 ml-8 text-center">
                        Bayar
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const mode = urlParams.get('mode');
            const table = urlParams.get('table');
            const amount = localStorage.getItem('wbs_payment_amount') || 0;

            // Update order type display
            const orderTypeText = document.getElementById('orderTypeText');
            const tableNumberField = document.getElementById('tableNumberField');
            const tableNumberInput = document.getElementById('tableNumberInput');
            const paymentTotalAmount = document.getElementById('paymentTotalAmount');

            // Update amount display
            if (paymentTotalAmount && amount) {
                paymentTotalAmount.textContent = `Rp${parseInt(amount).toLocaleString('id-ID')}`;
            }

            if (orderTypeText && tableNumberField) {
                if (mode === 'dinein') {
                    // Show table number field for dine-in
                    tableNumberField.classList.remove('hidden');

                    // Set order type text
                    if (table) {
                        orderTypeText.textContent = `Makan di Tempat - Meja ${table}`;
                        tableNumberInput.value = table;
                    } else {
                        orderTypeText.textContent = 'Makan di Tempat';
                    }
                } else {
                    // Hide table number field for other modes
                    tableNumberField.classList.add('hidden');

                    if (mode === 'takeaway') {
                        orderTypeText.textContent = 'Takeaway';
                    } else {
                        orderTypeText.textContent = 'Takeaway'; // Default
                    }
                }
            }

            const btnOnline = document.getElementById('btnOnline');
            const btnCashier = document.getElementById('btnCashier');
            const onlineSection = document.getElementById('onlinePaymentSection');
            const cashierSection = document.getElementById('cashierInstructionSection');
            const mainPayBtn = document.getElementById('mainPayBtn');
            const qrisOption = document.getElementById('qrisOption');
            const qrisRadio = document.getElementById('qrisRadio');

            // Track current payment type
            let currentPaymentType = 'online'; // 'online' or 'cashier'

            // Function to update Pay button state
            function updatePayButtonState() {
                if (currentPaymentType === 'online') {
                    // For online payment, enable only if QRIS is selected
                    if (qrisRadio && qrisRadio.checked) {
                        mainPayBtn.disabled = false;
                        mainPayBtn.classList.remove('bg-gray-300', 'cursor-not-allowed', 'hover:bg-gray-300');
                        mainPayBtn.classList.add('bg-[#f05a28]', 'hover:bg-[#d94a1c]');
                    } else {
                        mainPayBtn.disabled = true;
                        mainPayBtn.classList.add('bg-gray-300', 'cursor-not-allowed', 'hover:bg-gray-300');
                        mainPayBtn.classList.remove('bg-[#f05a28]', 'hover:bg-[#d94a1c]');
                    }
                } else {
                    // For cashier payment, always enable
                    mainPayBtn.disabled = false;
                    mainPayBtn.classList.remove('bg-gray-300', 'cursor-not-allowed', 'hover:bg-gray-300');
                    mainPayBtn.classList.add('bg-[#f05a28]', 'hover:bg-[#d94a1c]');
                }
            }

            // Helper to set active styles
            function setActive(btn, isActive) {
                if (isActive) {
                    btn.classList.remove('border-gray-200', 'bg-white', 'text-gray-600', 'hover:bg-gray-50');
                    btn.classList.add('border-orange-500', 'bg-orange-50', 'text-orange-600');

                    // Add checkmark if not exists
                    if (!btn.querySelector('.absolute')) {
                        const checkmark = document.createElement('div');
                        checkmark.className =
                            'absolute -bottom-1 -right-1 bg-green-500 rounded-full p-0.5 border-2 border-white';
                        checkmark.innerHTML =
                            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 text-white"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>`;
                        btn.appendChild(checkmark);
                    }
                } else {
                    btn.classList.add('border-gray-200', 'bg-white', 'text-gray-600', 'hover:bg-gray-50');
                    btn.classList.remove('border-orange-500', 'bg-orange-50', 'text-orange-600');

                    // Remove checkmark
                    const checkmark = btn.querySelector('.absolute');
                    if (checkmark) checkmark.remove();
                }
            }

            // QRIS option click handler
            if (qrisOption && qrisRadio) {
                qrisOption.addEventListener('click', (e) => {
                    // Toggle radio if clicking on the container (not the radio itself)
                    if (e.target !== qrisRadio) {
                        qrisRadio.checked = !qrisRadio.checked;
                    }
                    updatePayButtonState();
                });

                // Handle radio change
                qrisRadio.addEventListener('change', () => {
                    updatePayButtonState();
                });
            }

            btnOnline.addEventListener('click', () => {
                currentPaymentType = 'online';
                setActive(btnOnline, true);
                setActive(btnCashier, false);
                onlineSection.classList.remove('hidden');
                cashierSection.classList.add('hidden');
                cashierSection.classList.remove('flex');
                mainPayBtn.textContent = 'Bayar';

                // Uncheck QRIS when switching to online (user must select it)
                if (qrisRadio) {
                    qrisRadio.checked = false;
                }
                updatePayButtonState();
            });

            btnCashier.addEventListener('click', () => {
                currentPaymentType = 'cashier';
                setActive(btnOnline, false);
                setActive(btnCashier, true);
                onlineSection.classList.add('hidden');
                cashierSection.classList.remove('hidden');
                cashierSection.classList.add('flex');
                mainPayBtn.textContent = 'Bayar di Kasir';
                updatePayButtonState();
            });

            // Validation Elements
            const fullNameInput = document.getElementById('fullNameInput');
            const validationModalOverlay = document.getElementById('validationModalOverlay');
            const validationModal = document.getElementById('validationModal');
            const closeValidationBtn = document.getElementById('closeValidationBtn');
            const validationCard = validationModal ? validationModal.firstElementChild : null;

            function closeValidationModal() {
                if (!validationModalOverlay || !validationCard) return;
                validationModalOverlay.classList.remove('opacity-100');
                validationModalOverlay.classList.add('opacity-0');
                validationCard.classList.remove('translate-y-0');
                validationCard.classList.add('translate-y-[100vh]');
                setTimeout(() => {
                    validationModalOverlay.classList.add('hidden');
                }, 300);
            }

            if (closeValidationBtn) {
                closeValidationBtn.addEventListener('click', closeValidationModal);
                validationModalOverlay.addEventListener('click', closeValidationModal);
            }

            // Handle Pay button click
            mainPayBtn.addEventListener('click', async () => {
                if (mainPayBtn.disabled) return;

                // Validation: Check if name is empty
                if (fullNameInput && !fullNameInput.value.trim()) {
                    if (validationModalOverlay && validationCard) {
                        validationModalOverlay.classList.remove('hidden');
                        requestAnimationFrame(() => {
                            validationModalOverlay.classList.remove('opacity-0');
                            validationModalOverlay.classList.add('opacity-100');
                            validationCard.classList.remove('translate-y-[100vh]');
                            validationCard.classList.add('translate-y-0');
                        });
                    } else {
                        alert('Please fill in your name.');
                    }
                    return;
                }

                const urlParams = new URLSearchParams(window.location.search);
                const currentMode = urlParams.get('mode') || 'takeaway';
                const table = urlParams.get('table');
                const amount = localStorage.getItem('wbs_payment_amount') || 0;

                // Generate 8-digit order number (format: ORD + 5 random alphanumeric uppercase)
                // Example: ORDRYJD4
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                let randomCode = '';
                for (let i = 0; i < 5; i++) {
                    randomCode += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                const orderNumber = `ORD${randomCode}`;


                // Get cart from localStorage
                const cart = JSON.parse(localStorage.getItem('wbs_cart')) || {};

                // Convert cart to items array for order_items table
                const orderItems = [];
                for (const itemId in cart) {
                    const item = cart[itemId];
                    orderItems.push({
                        product_name: item.name,
                        quantity: item.quantity,
                    });
                }

                // Prepare request body
                const orderData = {
                    order_number: orderNumber,
                    customer_name: fullNameInput.value.trim(),
                    order_type: currentMode,
                    table_number: currentMode === 'dinein' ? (tableNumberInput?.value || table ||
                        null) : null,
                    total_amount: parseFloat(amount),
                    notes: null, // You can add a notes field if needed
                    items: orderItems // Add cart items to request
                };


                try {
                    // Disable button to prevent double submission
                    mainPayBtn.disabled = true;
                    mainPayBtn.textContent = 'Memproses...';

                    // Send POST request to /api/order
                    const response = await fetch('/api/order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || ''
                        },
                        body: JSON.stringify(orderData)
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        // Store order number for confirmation page
                        localStorage.setItem('wbs_order_number', orderNumber);

                        // Navigate to confirmation page
                        let queryParams = `mode=${currentMode}`;
                        if (currentMode === 'dinein' && table) {
                            queryParams += `&table=${table}`;
                        }

                        if (currentPaymentType === 'cashier') {
                            window.location.href = `/cashier-confirmation?${queryParams}`;
                        } else {
                            window.location.href = `/qris-confirmation?${queryParams}`;
                        }
                    } else {
                        // Handle error
                        alert(result.message || 'Gagal membuat pesanan. Silakan coba lagi.');
                        mainPayBtn.disabled = false;
                        mainPayBtn.textContent = currentPaymentType === 'cashier' ? 'Pay at Cashier' :
                            'Pay';
                    }
                } catch (error) {
                    console.error('Error creating order:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    mainPayBtn.disabled = false;
                    mainPayBtn.textContent = currentPaymentType === 'cashier' ? 'Pay at Cashier' :
                        'Pay';
                }
            });

            // Initial state: Online is active by default, so disable Pay button
            updatePayButtonState();
        });
    </script>
</body>

</html>
