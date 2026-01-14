<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<body class="bg-gray-100 min-h-screen flex justify-center">
    <div class="w-full max-w-[500px] mx-auto bg-white min-h-screen relative shadow-2xl pb-24">
        <!-- Sticky Header -->
        <div class="sticky top-0 z-50 bg-white border-b border-gray-100 px-4 py-3 flex items-center mb-2">
            <button class="absolute left-4 p-1 hover:bg-gray-100 rounded-full transition-colors"
                onclick="window.history.back()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6 text-gray-800">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </button>
            <h1 class="font-bold text-lg text-gray-800 w-full text-center">Order</h1>
        </div>

        <!-- Content -->
        <div class="px-4 space-y-6">
            <!-- Order Type -->
            <div
                class="w-full bg-orange-50 border border-orange-400 rounded-lg px-4 py-2 flex items-center justify-between">
                <span class="text-gray-700 text-sm font-medium">Jenis Pesanann</span>
                <span id="orderTypeText" class="font-bold text-gray-900 text-sm">Ambil Sekarang</span>
            </div>

            <!-- Best Selling Menu -->
            <div>
                <h2 class="font-bold text-gray-900 mb-3">Rekomendasi Menu</h2>
                <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
                    @forelse ($bestSellingProducts as $product)
                        <div class="min-w-[160px] bg-white border border-gray-100 rounded-xl p-2 shadow-sm flex gap-2 items-center"
                            data-best-selling-id="{{ $product->id }}" data-best-selling-name="{{ $product->name }}"
                            data-best-selling-price="{{ $product->price }}">
                            <img src="/images/{{ $product->image }}"
                                class="w-14 h-14 rounded-lg object-cover bg-gray-200" alt="{{ $product->name }}">
                            <div class="flex-1">
                                <h3 class="text-xs font-bold text-gray-800 leading-tight mb-1">
                                    {{ strtoupper($product->name) }}</h3>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-xs font-bold text-gray-600">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                    <button
                                        class="text-orange-500 add-best-selling-btn hover:text-orange-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full text-center py-4 text-gray-500 text-sm italic">
                            Belum ada menu terlaris. Mulai pesan sekarang!
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Ordered Items -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-gray-900">Menu yang Dipesan (<span id="orderItemCount">0</span>)</h2>
                    <button onclick="window.history.back()"
                        class="px-3 py-1 border border-orange-400 text-orange-500 text-xs font-bold rounded-lg hover:bg-orange-50 transition-colors">
                        + Tambah Menu
                    </button>
                </div>

                <!-- Dynamic Order Items Container -->
                <div id="orderItemsContainer">
                    <!-- Items will be inserted here by JavaScript -->
                </div>

                <!-- Add Note Section -->
                <div id="openNotesBtn"
                    class="flex items-center gap-2 pt-4 cursor-pointer hover:text-orange-500 transition-colors group">
                    <div class="w-1 h-5 bg-orange-500 rounded-full"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-gray-800 group-hover:text-orange-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>
                    <span class="text-sm italic text-gray-400 group-hover:text-orange-500">Tambah Catatan</span>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="border border-gray-200 rounded-xl p-4 shadow-sm bg-white">
                <h3 class="font-bold text-gray-800 mb-3 text-center">Detail Pembayaran</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal <span id="menuCountText" class="text-gray-400">(0 menu)</span></span>
                        <span id="subtotalPrice" class="font-bold text-gray-800">Rp0</span>
                    </div>
                    <div class="flex justify-between text-gray-600 border-b border-dashed border-gray-200 pb-2">
                        <span>Pembulatan</span>
                        <span id="roundingPrice" class="font-bold text-gray-800">Rp0</span>
                    </div>
                    <div class="flex justify-between text-gray-600 pt-1 border-b border-dashed border-gray-200 pb-2">
                        <span>Pajak 10%</span>

                        <span id="otherFeesPrice" class="font-bold text-gray-800">Rp0</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="font-bold text-gray-900">Total</span>
                        <span id="totalPrice" class="font-bold text-orange-600 text-lg">Rp0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Bottom Bar -->
        <div class="fixed bottom-0 left-0 right-0 z-50 flex justify-center pointer-events-none">
            <div
                class="w-full max-w-[500px] bg-white border-t border-gray-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] pointer-events-auto rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500 font-semibold mb-0.5">Total Pembayaran</p>
                        <p id="bottomTotalPrice" class="text-xl font-bold text-gray-900 leading-none">Rp0</p>
                    </div>
                    <button onclick="goToPayment()"
                        class="bg-[#f05a28] hover:bg-[#d94a1c] text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-all active:scale-95">
                        Lanjutkan ke Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Modal Overlay -->
    <div id="notesOverlay"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[60] hidden transition-opacity duration-300 opacity-0">
    </div>

    <!-- Notes Modal Content -->
    <div id="notesModal"
        class="fixed bottom-0 left-0 right-0 z-[70] flex justify-center translate-y-full transition-transform duration-300 ease-out pointer-events-none">
        <div
            class="w-full max-w-[500px] bg-white rounded-t-2xl shadow-2xl pointer-events-auto flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-900">Tambah Catatan</h3>
                <button id="closeNotesBtn" class="p-1 hover:bg-gray-100 rounded-full transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-gray-800">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-4">
                <textarea id="notesInput"
                    class="w-full h-32 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none resize-none text-gray-700"
                    placeholder="Catatan"></textarea>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-100">
                <button id="saveNotesBtn"
                    class="w-full bg-[#f05a28] hover:bg-[#d94a1c] text-white font-bold py-3 rounded-lg shadow-md transition-all active:scale-95">
                    Tambah
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const mode = urlParams.get('mode');
            const table = urlParams.get('table');

            // Update order type display
            const orderTypeText = document.getElementById('orderTypeText');
            if (orderTypeText) {
                if (mode === 'dinein') {
                    if (table) {
                        orderTypeText.textContent = `Makan di Tempat - Meja ${table}`;
                    } else {
                        orderTypeText.textContent = 'Makan di Tempat';
                    }
                } else if (mode === 'takeaway') {
                    orderTypeText.textContent = 'Takeaway';
                } else {
                    orderTypeText.textContent = 'Takeaway'; // Default
                }
            }

            // --- Load and Display Cart Items ---
            let cart = {};
            const savedCart = localStorage.getItem('wbs_cart');
            if (savedCart) {
                try {
                    cart = JSON.parse(savedCart);
                } catch (e) {
                    console.error('Failed to parse cart from localStorage', e);
                    cart = {};
                }
            }

            // Function to render cart items
            function renderCartItems() {
                const container = document.getElementById('orderItemsContainer');
                if (!container) return;

                container.innerHTML = ''; // Clear existing items

                let totalItems = 0;
                for (const itemId in cart) {
                    const item = cart[itemId];
                    totalItems++;

                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'border-b border-gray-100 pb-4 mb-4';
                    itemDiv.innerHTML = `
                        <div class="flex justify-between items-start mb-1">
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm">${item.name}</h3>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1 text-gray-400 mb-3">
                            
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-600 text-sm">Rp${item.price.toLocaleString('id-ID')}</span>
                            <div class="flex items-center gap-3">
                                <button onclick="updateQuantity('${itemId}', -1)"
                                    class="w-6 h-6 rounded-full border border-gray-800 flex items-center justify-center text-gray-800 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                    </svg>
                                </button>
                                <span class="font-bold text-gray-900 text-sm">${item.quantity}</span>
                                <button onclick="updateQuantity('${itemId}', 1)"
                                    class="w-6 h-6 rounded-full border border-gray-800 flex items-center justify-center text-gray-800 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;
                    container.appendChild(itemDiv);
                }

                // Update order item count
                const orderItemCount = document.getElementById('orderItemCount');
                if (orderItemCount) {
                    orderItemCount.textContent = totalItems;
                }

                // Calculate and update payment details
                updatePaymentDetails();
            }

            // Store final total for payment navigation
            let finalTotal = 0;

            // Function to calculate and update payment details
            function updatePaymentDetails() {
                let subtotal = 0;
                let totalItems = 0;

                for (const itemId in cart) {
                    const item = cart[itemId];
                    subtotal += item.price * item.quantity;
                    totalItems += item.quantity;
                }

                // Calculate other fees (10% of subtotal)
                const otherFees = Math.round(subtotal * 0.1);

                // Temporary total before rounding
                const tempTotal = subtotal + otherFees;

                // Calculate rounding (Round DOWN to nearest 500)
                // If remainder is 0, no rounding.
                // If remainder > 0, subtract remainder.
                const remainder = tempTotal % 500;
                const rounding = remainder > 0 ? -remainder : 0;

                // Calculate final total
                finalTotal = tempTotal + rounding;

                // Update UI
                const menuCountText = document.getElementById('menuCountText');
                const subtotalPrice = document.getElementById('subtotalPrice');
                const roundingPrice = document.getElementById('roundingPrice');
                const otherFeesPrice = document.getElementById('otherFeesPrice');
                const totalPrice = document.getElementById('totalPrice');
                const bottomTotalPrice = document.getElementById('bottomTotalPrice');

                if (menuCountText) menuCountText.textContent = `(${totalItems} menu)`;
                if (subtotalPrice) subtotalPrice.textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
                if (roundingPrice) roundingPrice.textContent = `Rp${rounding.toLocaleString('id-ID')}`;
                if (otherFeesPrice) otherFeesPrice.textContent = `Rp${otherFees.toLocaleString('id-ID')}`;
                if (totalPrice) totalPrice.textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;
                if (bottomTotalPrice) bottomTotalPrice.textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;
            }

            // Function to update quantity
            window.updateQuantity = function(itemId, delta) {
                if (cart[itemId]) {
                    cart[itemId].quantity += delta;

                    if (cart[itemId].quantity <= 0) {
                        delete cart[itemId];
                    }

                    // Save to localStorage
                    localStorage.setItem('wbs_cart', JSON.stringify(cart));

                    // Re-render cart
                    renderCartItems();
                }
            };

            // Initial render
            renderCartItems();

            const openBtn = document.getElementById('openNotesBtn');
            const closeBtn = document.getElementById('closeNotesBtn');
            const saveBtn = document.getElementById('saveNotesBtn');
            const overlay = document.getElementById('notesOverlay');
            const modal = document.getElementById('notesModal');

            function openModal() {
                overlay.classList.remove('hidden');
                // Trigger reflow
                void overlay.offsetWidth;
                overlay.classList.remove('opacity-0');

                modal.classList.remove('translate-y-full');
            }

            function closeModal() {
                overlay.classList.add('opacity-0');
                modal.classList.add('translate-y-full');

                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }

            if (openBtn) openBtn.addEventListener('click', openModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (overlay) overlay.addEventListener('click', closeModal);
            if (saveBtn) saveBtn.addEventListener('click', closeModal);

            // --- Best Selling Products Add to Cart ---
            const bestSellingBtns = document.querySelectorAll('.add-best-selling-btn');

            bestSellingBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const productCard = this.closest('[data-best-selling-id]');
                    const itemId = productCard.getAttribute('data-best-selling-id');
                    const itemName = productCard.getAttribute('data-best-selling-name');
                    const itemPrice = parseInt(productCard.getAttribute('data-best-selling-price'));

                    // Add to cart
                    if (!cart[itemId]) {
                        cart[itemId] = {
                            name: itemName,
                            price: itemPrice,
                            quantity: 1
                        };
                    } else {
                        cart[itemId].quantity++;
                    }

                    // Save to localStorage
                    localStorage.setItem('wbs_cart', JSON.stringify(cart));

                    // Re-render cart
                    renderCartItems();

                    // Visual feedback
                    const originalIcon = this.innerHTML;
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                    `;
                    this.classList.add('text-green-500');

                    setTimeout(() => {
                        this.innerHTML = originalIcon;
                        this.classList.remove('text-green-500');
                        this.classList.add('text-orange-500');
                    }, 1000);
                });
            });

            // --- Payment Navigation ---
            window.goToPayment = function() {
                const urlParams = new URLSearchParams(window.location.search);
                const currentMode = urlParams.get('mode') || 'takeaway';
                const table = urlParams.get('table');

                // Save amount to localStorage
                localStorage.setItem('wbs_payment_amount', finalTotal);

                let queryParams = `mode=${currentMode}`;
                if (currentMode === 'dinein' && table) {
                    queryParams += `&table=${table}`;
                }
                window.location.href = `/payment?${queryParams}`;
            };
        });
    </script>
</body>

</html>
