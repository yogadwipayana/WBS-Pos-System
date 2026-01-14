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

<body class="bg-gray-100 min-h-screen flex justify-center overscroll-y-none">
    <div class="w-full max-w-[500px] bg-white min-h-screen relative shadow-2xl pb-20 mx-auto">
        <!-- Header -->
        <div class="sticky top-0 z-50 bg-white px-4 py-3 flex items-center justify-between border-b border-gray-100">
            <div class="flex items-center gap-4">
                <button class="p-1 hover:bg-gray-100 rounded-full transition-colors" onclick="window.history.back()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <h1 class="font-bold text-lg text-gray-900">Warung Bali Sangeh</h1>
            </div>
            <button class="p-1 hover:bg-gray-100 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>
        </div>

        <!-- Store Info & Order Type -->
        <div class="p-4 space-y-4">
            <!-- Store Details -->
            <div
                class="bg-white border rounded-xl p-4 shadow-sm flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors">
                <div>
                    <h2 class="font-bold text-gray-900">Warung Bali Sangeh</h2>
                    <p class="text-sm text-gray-500 mt-1">Buka Setiap Hari, 08:00-22:00</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </div>

            <!-- Order Type Section -->
            <div class="bg-white border rounded-xl p-4 shadow-sm space-y-4">
                <div class="flex items-center justify-between relative">
                    <span class="text-gray-700 font-medium">Tipe Order</span>
                    <div class="relative" id="orderTypeDropdown">
                        <button type="button" id="orderTypeBtn"
                            class="flex items-center gap-2 px-3 py-1.5 border rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                            <span id="orderTypeLabel">Takeaway</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4 transition-transform duration-200"
                                id="dropdownArrow">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl z-[100] hidden transform origin-top-right transition-all duration-200 scale-95 opacity-0">
                            <div class="py-1">
                                <button type="button" onclick="setOrderType('takeaway')"
                                    class="w-full text-left px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4 shadow-sm">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                    Takeaway
                                </button>
                                <button type="button" onclick="setOrderType('dinein')"
                                    class="w-full text-left px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors flex items-center gap-3 border-t border-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4 shadow-sm">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18" />
                                    </svg>
                                    Dine In
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Takeaway Status -->
                <div id="takeawayStatus" class="flex items-center gap-3 py-3 border-t border-dashed border-gray-200">
                    <div class="p-2 bg-gray-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-gray-800">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                    </div>
                    <span class="font-bold text-gray-900">Ambil Sekarang</span>
                </div>

                <!-- Dine In Status -->
                <div id="dineInStatus" class="hidden border-t border-dashed border-gray-200 pt-3">
                    <div onclick="openModal()"
                        class="bg-orange-50 border border-orange-100 rounded-xl p-4 shadow-sm text-center cursor-pointer hover:bg-orange-100 transition-all active:scale-[0.98]">
                        <span id="tableDisplay" class="text-gray-900 font-bold text-lg">Nomor Meja: -</span>
                        <p class="text-xs text-orange-600 mt-1 font-medium italic">Klik untuk ubah nomor meja</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Category Nav -->
        <div class="sticky top-[50px] bg-white z-40 border-b border-gray-200 shadow-sm">
            <div class="flex overflow-x-auto no-scrollbar py-3 px-4 gap-6" id="categoryNav">
                @forelse ($categories as $category)
                    <button data-target="{{ Str::slug($category->name) }}"
                        class="nav-item whitespace-nowrap pb-2 -mb-3.5 transition-colors duration-200 {{ $loop->first ? 'font-bold text-red-600 border-b-2 border-red-600' : 'font-semibold text-gray-500 hover:text-gray-900' }}">
                        {{ strtoupper($category->name) }}
                    </button>
                @empty
                    <div class="text-sm text-gray-500 py-2">Kategori tidak tersedia</div>
                @endforelse
            </div>
        </div>

        <!-- Menu Content -->
        <div class="p-4 bg-gray-50 min-h-[800px] relative">
            <!-- Dynamic Section Header (Sticky below nav) -->
            {{-- <div class="sticky top-[115px] z-30 bg-gray-50 py-2 -mx-4 px-4 mb-2 shadow-sm opacity-95">
                <h3 id="sectionHeader"
                    class="font-bold text-gray-700 tracking-wide uppercase transition-all duration-300">MAKANAN</h3>
            </div> --}}

            <div class="space-y-8">
                @forelse ($categories as $category)
                    <section id="{{ Str::slug($category->name) }}" class="scroll-mt-[160px]">
                        <h3 class="font-bold text-gray-700 tracking-wide uppercase transition-all duration-300">
                            {{ strtoupper($category->name) }}
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            @forelse ($category->products as $product)
                                <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex flex-col"
                                    data-item-id="{{ $product->id }}" data-item-name="{{ $product->name }}"
                                    data-item-price="{{ $product->price }}">
                                    <div class="rounded-lg overflow-hidden h-32 w-full mb-3 relative">
                                        <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <h4 class="font-bold text-gray-800 text-sm mb-1 leading-tight">
                                        {{ $product->name }}
                                    </h4>
                                    <p class="text-gray-900 font-bold text-sm mb-3">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                                    <!-- Add Button -->
                                    <button
                                        class="add-btn w-full py-1.5 border border-red-500 text-red-500 rounded-full font-semibold text-sm hover:bg-red-50 transition-colors mt-auto">
                                        Add
                                    </button>

                                    <!-- Quantity Selector (Hidden by default) -->
                                    <div
                                        class="quantity-selector hidden w-full flex items-center justify-between border border-red-500 rounded-full px-3 py-1.5 mt-auto">
                                        <button
                                            class="qty-minus w-6 h-6 flex items-center justify-center text-red-500 font-bold hover:bg-red-50 rounded-full">
                                            −
                                        </button>
                                        <span class="qty-display font-semibold text-gray-900 text-sm">1</span>
                                        <button
                                            class="qty-plus w-6 h-6 flex items-center justify-center text-red-500 font-bold hover:bg-red-50 rounded-full">
                                            +
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-center text-gray-500 py-4 italic">
                                    Belum ada produk di kategori ini.
                                </div>
                            @endforelse
                        </div>
                    </section>
                @empty
                    <div class="text-center text-gray-500 py-10">
                        Menu belum tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    </div>


    <!-- Sticky Checkout Bar -->
    <div id="checkoutBar" class="fixed bottom-0 left-0 right-0 z-50 hidden">
        <div
            class="w-full max-w-[500px] mx-auto bg-[#f05a28] text-white px-4 py-3 flex items-center justify-between shadow-lg">
            <!-- Left: Cart Icon with Badge -->
            <div class="flex items-center gap-3">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                    <span id="cartBadge"
                        class="absolute -top-2 -right-2 bg-white text-[#f05a28] text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </div>
                <div>
                    <p class="text-xs opacity-90">Total</p>
                    <p id="cartTotal" class="font-bold text-lg">Rp0</p>
                </div>
            </div>
            <!-- Right: Checkout Button -->
            <button id="checkoutBtn" onclick="handleCheckout()"
                class="bg-white text-[#f05a28] px-6 py-2 rounded-full font-bold text-sm hover:bg-gray-100 transition-colors">
                LIHAT PESANAN (<span id="checkoutCount">0</span>)
            </button>
        </div>
    </div>

    <!-- Dine In Modal Overlay -->
    <div id="modalOverlay"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[60] hidden transition-opacity duration-300 opacity-0">
    </div>

    <!-- Dine In Modal Content -->
    <div id="dineInModal"
        class="fixed bottom-0 left-0 right-0 z-[70] flex justify-center translate-y-full transition-transform duration-300 ease-out pointer-events-none">
        <div class="w-full max-w-[500px] bg-white rounded-t-2xl p-4 shadow-lg pointer-events-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-900 text-lg">Dine In</h3>
                <button id="closeModalBtn" onclick="closeModal()"
                    class="p-1 hover:bg-gray-100 rounded-full transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Meja<span
                        class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" id="tableNumberInput"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-colors"
                        placeholder="Masukkan Nomor Meja">
                </div>
                <p id="tableValidationError" class="text-red-500 text-sm mt-2 hidden">Nomor meja wajib diisi!</p>
            </div>

            <!-- Footer -->
            <button id="saveTableBtn"
                class="w-full bg-gray-200 text-gray-500 font-bold py-3 rounded-xl shadow-sm transition-all text-center cursor-not-allowed"
                disabled>
                Simpan
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const mode = urlParams.get('mode');
            const table = urlParams.get('table');
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById('dineInModal');
            const closeBtn = document.getElementById('closeModalBtn');
            const saveBtn = document.getElementById('saveTableBtn');
            const input = document.getElementById('tableNumberInput');

            // New Elements for Toggle Logic
            const dineInBanner = document.getElementById('dineInBanner');
            const takewaySelector = document.getElementById('takewaySelector');
            const tableDisplay = document.getElementById('tableDisplay');

            window.openModal = function() {
                if (overlay && modal) {
                    overlay.classList.remove('hidden');
                    // Slight delay to allow display:block to apply before opacity transition
                    setTimeout(() => {
                        overlay.classList.remove('opacity-0');
                        modal.classList.remove('translate-y-full');
                    }, 10);
                }
            }

            window.closeModal = function() {
                if (overlay && modal) {
                    overlay.classList.add('opacity-0');
                    modal.classList.add('translate-y-full');

                    // Wait for transition to finish before hiding
                    setTimeout(() => {
                        overlay.classList.add('hidden');
                    }, 300);
                }
            }

            // Input Validation Logic
            if (input && saveBtn) {
                input.addEventListener('input', (e) => {
                    if (e.target.value.length > 0) {
                        saveBtn.classList.remove('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
                        saveBtn.classList.add('bg-[#f05a28]', 'text-white', 'hover:bg-[#d94a1c]',
                            'active:scale-95');
                        saveBtn.disabled = false;
                    } else {
                        saveBtn.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
                        saveBtn.classList.remove('bg-[#f05a28]', 'text-white', 'hover:bg-[#d94a1c]',
                            'active:scale-95');
                        saveBtn.disabled = true;
                    }
                });
            }

            // --- Dropdown Functionality ---
            const dropdownBtn = document.getElementById('orderTypeBtn');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownArrow = document.getElementById('dropdownArrow');

            function toggleDropdown() {
                const isHidden = dropdownMenu.classList.contains('hidden');
                if (isHidden) {
                    dropdownMenu.classList.remove('hidden');
                    setTimeout(() => {
                        dropdownMenu.classList.remove('scale-95', 'opacity-0');
                        dropdownMenu.classList.add('scale-100', 'opacity-100');
                        dropdownArrow.classList.add('rotate-180');
                    }, 10);
                } else {
                    dropdownMenu.classList.remove('scale-100', 'opacity-100');
                    dropdownMenu.classList.add('scale-95', 'opacity-0');
                    dropdownArrow.classList.remove('rotate-180');
                    setTimeout(() => {
                        dropdownMenu.classList.add('hidden');
                    }, 200);
                }
            }

            if (dropdownBtn) {
                dropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleDropdown();
                });
            }

            // Close dropdown when clicking outside
            window.addEventListener('click', () => {
                if (dropdownMenu && !dropdownMenu.classList.contains('hidden')) {
                    toggleDropdown();
                }
            });

            const orderTypeLabel = document.getElementById('orderTypeLabel');
            const takeawayStatus = document.getElementById('takeawayStatus');
            const dineInStatus = document.getElementById('dineInStatus');

            window.setOrderType = function(type) {
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('mode', type);

                // If switching to takeaway, remove table param
                if (type === 'takeaway') {
                    currentUrl.searchParams.delete('table');
                    if (input) input.value = '';
                }

                window.history.pushState({}, '', currentUrl);

                updateUIForMode(type);

                // Close dropdown if open
                if (dropdownMenu && !dropdownMenu.classList.contains('hidden')) {
                    toggleDropdown();
                }

                // If switching to dine-in and no table is set, open modal
                if (type === 'dinein') {
                    const currentInput = document.getElementById('tableNumberInput');
                    if (!currentInput || !currentInput.value) {
                        setTimeout(() => {
                            openModal();
                        }, 100);
                    }
                }
            }

            function updateUIForMode(currentMode) {
                if (currentMode === 'dinein') {
                    if (orderTypeLabel) orderTypeLabel.textContent = 'Dine In';
                    if (takeawayStatus) takeawayStatus.classList.add('hidden');
                    if (dineInStatus) dineInStatus.classList.remove('hidden');

                    const tableNum = new URLSearchParams(window.location.search).get('table');
                    if (tableNum && tableDisplay) {
                        tableDisplay.textContent = 'Nomor Meja: ' + tableNum;
                        if (input) input.value = tableNum;
                    } else if (tableDisplay) {
                        tableDisplay.textContent = 'Nomor Meja: -';
                    }
                } else {
                    if (orderTypeLabel) orderTypeLabel.textContent = 'Takeaway';
                    if (takeawayStatus) takeawayStatus.classList.remove('hidden');
                    if (dineInStatus) dineInStatus.classList.add('hidden');
                }
            }

            // Initialize UI
            updateUIForMode(mode || 'takeaway');

            // Auto open modal if in dinein mode and no table set
            if ((mode === 'dinein') && (!table)) {
                setTimeout(() => {
                    openModal();
                }, 500);
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }
            // Prevent closing modal by clicking overlay in dine-in mode without table number
            if (overlay) {
                overlay.addEventListener('click', (e) => {
                    if (mode === 'dinein' && input && !input.value) {
                        // Do nothing - prevent closing
                        e.stopPropagation();
                    } else {
                        closeModal();
                    }
                });
            }
            if (saveBtn) {
                saveBtn.addEventListener('click', () => {
                    // Update the banner with the input value
                    if (input && input.value && tableDisplay) {
                        tableDisplay.textContent = 'Nomor Meja: ' + input.value;

                        // Update URL with table number
                        const currentUrl = new URL(window.location.href);
                        currentUrl.searchParams.set('table', input.value);
                        window.history.pushState({}, '', currentUrl);
                    }
                    closeModal();
                });
            }

            // --- Cart Functionality ---
            let cart = {}; // { itemId: { name, price, quantity } }

            // Load cart from localStorage
            const savedCart = localStorage.getItem('wbs_cart');
            if (savedCart) {
                try {
                    cart = JSON.parse(savedCart);
                } catch (e) {
                    console.error('Failed to parse cart from localStorage', e);
                    cart = {};
                }
            }

            const checkoutBar = document.getElementById('checkoutBar');
            const cartBadge = document.getElementById('cartBadge');
            const cartTotal = document.getElementById('cartTotal');
            const checkoutCount = document.getElementById('checkoutCount');

            // Get all menu items
            const menuItems = document.querySelectorAll('[data-item-id]');

            // Restore cart UI for items that are already in cart
            menuItems.forEach(item => {
                const itemId = item.getAttribute('data-item-id');
                if (cart[itemId]) {
                    const addBtn = item.querySelector('.add-btn');
                    const quantitySelector = item.querySelector('.quantity-selector');
                    const qtyDisplay = item.querySelector('.qty-display');

                    if (addBtn && quantitySelector && qtyDisplay) {
                        addBtn.classList.add('hidden');
                        quantitySelector.classList.remove('hidden');
                        quantitySelector.classList.add('flex');
                        qtyDisplay.textContent = cart[itemId].quantity;
                    }
                }
            });

            // Initial cart update to show saved items
            updateCart();

            menuItems.forEach(item => {
                const itemId = item.getAttribute('data-item-id');
                const itemName = item.getAttribute('data-item-name');
                const itemPrice = parseInt(item.getAttribute('data-item-price'));

                const addBtn = item.querySelector('.add-btn');
                const quantitySelector = item.querySelector('.quantity-selector');
                const qtyDisplay = item.querySelector('.qty-display');
                const qtyMinus = item.querySelector('.qty-minus');
                const qtyPlus = item.querySelector('.qty-plus');

                // Add to cart
                if (addBtn) {
                    addBtn.addEventListener('click', () => {
                        cart[itemId] = {
                            name: itemName,
                            price: itemPrice,
                            quantity: 1
                        };
                        addBtn.classList.add('hidden');
                        quantitySelector.classList.remove('hidden');
                        quantitySelector.classList.add('flex');
                        qtyDisplay.textContent = '1';
                        updateCart();
                    });
                }

                // Increase quantity
                if (qtyPlus) {
                    qtyPlus.addEventListener('click', () => {
                        if (cart[itemId]) {
                            cart[itemId].quantity++;
                            qtyDisplay.textContent = cart[itemId].quantity;
                            updateCart();
                        }
                    });
                }

                // Decrease quantity
                if (qtyMinus) {
                    qtyMinus.addEventListener('click', () => {
                        if (cart[itemId]) {
                            cart[itemId].quantity--;
                            if (cart[itemId].quantity === 0) {
                                delete cart[itemId];
                                quantitySelector.classList.add('hidden');
                                quantitySelector.classList.remove('flex');
                                addBtn.classList.remove('hidden');
                            } else {
                                qtyDisplay.textContent = cart[itemId].quantity;
                            }
                            updateCart();
                        }
                    });
                }
            });

            // Update cart display
            function updateCart() {
                let totalItems = 0;
                let totalPrice = 0;

                for (const itemId in cart) {
                    const item = cart[itemId];
                    totalItems += item.quantity;
                    totalPrice += item.price * item.quantity;
                }

                // Update UI
                cartBadge.textContent = totalItems;
                checkoutCount.textContent = totalItems;
                cartTotal.textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;

                // Show/hide checkout bar
                if (totalItems > 0) {
                    checkoutBar.classList.remove('hidden');
                } else {
                    checkoutBar.classList.add('hidden');
                }

                // Save cart to localStorage
                localStorage.setItem('wbs_cart', JSON.stringify(cart));
            }

            // --- Sticky Nav & Scroll Spy Logic ---
            const navItems = document.querySelectorAll('.nav-item');
            const sections = document.querySelectorAll('section');
            const sectionHeader = document.getElementById('sectionHeader');

            let isManualScroll = false;
            let scrollTimeout;

            // Helper to update visual state
            function updateActiveNav(activeId) {
                navItems.forEach(nav => {
                    const target = nav.getAttribute('data-target');
                    if (target === activeId) {
                        nav.classList.remove('text-gray-500', 'hover:text-gray-900');
                        nav.classList.add('text-red-600', 'border-b-2', 'border-red-600');
                        nav.scrollIntoView({
                            behavior: 'auto',
                            block: 'nearest',
                            inline: 'center'
                        });

                        // Update Header Text
                        if (sectionHeader) {
                            sectionHeader.textContent = activeId.toUpperCase();
                        }
                    } else {
                        nav.classList.add('text-gray-500', 'hover:text-gray-900');
                        nav.classList.remove('text-red-600', 'border-b-2', 'border-red-600');
                    }
                });
            }

            // 1. Click to Scroll
            navItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = item.getAttribute('data-target');
                    const targetSection = document.getElementById(targetId);

                    if (targetSection) {
                        isManualScroll = true; // Disable observer temporarily

                        // Update Active State Immediately
                        updateActiveNav(targetId);

                        // Calculate Offset (Header ~60px + Nav ~53px + Padding)
                        const headerOffset = 115;
                        const elementPosition = targetSection.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        // Use 'auto' for instant scroll to remove "bounce" feel
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: "auto"
                        });

                        // Re-enable observer after scroll
                        if (scrollTimeout) clearTimeout(scrollTimeout);
                        scrollTimeout = setTimeout(() => {
                            isManualScroll = false;
                        }, 500); // Wait for scroll to settle
                    }
                });
            });

            // 2. Intersection Observer for Scroll Spy
            const observerOptions = {
                root: null, // viewport
                // Trigger when section hits the upper part of viewport (adjusted for sticky header)
                rootMargin: '-120px 0px -50% 0px',
                threshold: 0
            };

            const observer = new IntersectionObserver((entries) => {
                if (isManualScroll) return; // Skip if we are scrolling via click

                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const activeId = entry.target.id;
                        updateActiveNav(activeId);
                    }
                });
            }, observerOptions);

            sections.forEach(section => observer.observe(section));

            // --- Checkout Handler ---
            // Make handleCheckout available globally for the onclick handler
            window.handleCheckout = function() {
                const urlParams = new URLSearchParams(window.location.search);
                const currentMode = urlParams.get('mode') || 'takeaway';
                const tableInput = document.getElementById('tableNumberInput');
                const validationError = document.getElementById('tableValidationError');

                // Validate table number for dine-in mode
                if (currentMode === 'dinein') {
                    if (!tableInput || !tableInput.value || tableInput.value.trim() === '') {
                        // Show modal if not visible
                        openModal();

                        // Show validation error
                        if (validationError) {
                            validationError.classList.remove('hidden');
                        }

                        // Focus on input
                        if (tableInput) {
                            tableInput.focus();
                            tableInput.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                        }

                        return; // Prevent checkout
                    }
                }

                // Build query parameters
                let queryParams = `mode=${currentMode}`;

                // Add table number if in dine-in mode and table number is set
                if (currentMode === 'dinein' && tableInput && tableInput.value) {
                    queryParams += `&table=${tableInput.value}`;
                }

                window.location.href = `/view-order?${queryParams}`;
            };
        });
    </script>
</body>

</html>
