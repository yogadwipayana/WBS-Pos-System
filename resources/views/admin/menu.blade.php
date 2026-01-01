@extends('layouts.admin')

@section('title', 'Menu Statistics')

@section('content')
    <!-- Top Bar -->
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
        <!-- Mobile Menu Button -->
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
                <input type="text" id="searchInput"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:bg-white focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm transition-colors"
                    placeholder="Search menu by name...">
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
            <div class="font-medium text-gray-700">Today, {{ date('d M Y') }}</div>
        </div>
    </header>

    <!-- Scrollable Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
        <x-alert />
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Statistik Menu</h1>
                    <p class="text-gray-500 mt-1">Track menu performance, sales, and inventory</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="openAddProductModal()"
                        class="bg-orange-500 hover:bg-orange-700 text-white px-4 py-2 rounded-xl font-semibold shadow-sm text-sm flex items-center gap-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Product
                    </button>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Total Products -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs font-medium mb-1">Total Menu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                </div>

                <!-- Total Stock -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs font-medium mb-1">Total Stok</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalStock }}</p>
                </div>

                <!-- Low Stock -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-yellow-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs font-medium mb-1">Stok Rendah</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $lowStockCount }}</p>
                </div>

                <!-- Out of Stock -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs font-medium mb-1">Stok Habis</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $outOfStockCount }}</p>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5 text-purple-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-500 text-xs font-medium mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-900">Rp
                        {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900">Top 5 Menu Terlaris</h2>
                    <span class="text-xs text-gray-500">Based on total quantity sold</span>
                </div>
                <div class="space-y-4">
                    @forelse($topSellingProducts as $index => $product)
                        <div class="flex items-center gap-4">
                            <!-- Rank Badge -->
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full 
                                        @if ($index === 0) bg-yellow-100 text-yellow-600
                                        @elseif($index === 1) bg-gray-100 text-gray-600
                                        @elseif($index === 2) bg-orange-100 text-orange-600
                                        @else bg-blue-50 text-blue-600 @endif
                                        flex items-center justify-center font-bold text-sm">
                                #{{ $index + 1 }}
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $product->name }}</h3>
                                    <span class="text-sm font-bold text-gray-900 ml-2">{{ $product->total_sold }}
                                        sold</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-xs text-gray-500">{{ $product->category->name ?? 'No Category' }}</span>
                                    <span class="text-gray-300">•</span>
                                    <span class="text-xs font-medium text-green-600">Rp
                                        {{ number_format($product->total_revenue, 0, ',', '.') }}
                                        revenue</span>
                                </div>
                                <!-- Progress Bar -->
                                @php
                                    $maxSold = $topSellingProducts->first()->total_sold;
                                    $percentage = $maxSold > 0 ? ($product->total_sold / $maxSold) * 100 : 0;
                                @endphp
                                <div class="mt-2 w-full bg-gray-100 rounded-full h-2">
                                    <div class="progress-bar h-2 rounded-full 
                                                @if ($index === 0) bg-yellow-500
                                                @elseif($index === 1) bg-gray-400
                                                @elseif($index === 2) bg-orange-500
                                                @else bg-blue-500 @endif"
                                        style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-2 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                            </svg>
                            <p>No sales data available yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- All Menu Products Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">All Menu Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Menu Item</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Price</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Stock</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Total Sold</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Revenue</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="menuTableBody">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors menu-row"
                                    data-name="{{ strtolower($product->name) }}">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $product->category->name ?? 'No Category' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-sm font-semibold 
                                                        @if ($product->stock == 0) text-red-600
                                                        @elseif($product->stock < 10) text-yellow-600
                                                        @else text-green-600 @endif">
                                                {{ $product->stock }}
                                            </span>
                                            @if ($product->stock < 10 && $product->stock > 0)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="w-4 h-4 text-yellow-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-sm font-semibold text-gray-900">{{ $product->total_sold }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($product->stock == 0)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Out of Stock
                                            </span>
                                        @elseif($product->stock < 10)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Low Stock
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                In Stock
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <button type="button" data-action="edit" data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-category="{{ $product->category_id }}"
                                                data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                                                data-image="{{ $product->image ?? '' }}"
                                                data-description="{{ $product->description ?? '' }}"
                                                class="edit-btn text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-1 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                                Edit
                                            </button>
                                            <button type="button" data-action="delete" data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                class="delete-btn text-red-600 hover:text-red-800 font-medium text-sm flex items-center gap-1 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-12 h-12 mx-auto mb-2 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                        </svg>
                                        <p>No menu items found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari
                                {{ $products->total() }} menu
                            </div>
                            <div class="flex gap-2">
                                {{-- Previous Button --}}
                                @if ($products->onFirstPage())
                                    <span
                                        class="px-4 py-2 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}"
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        Previous
                                    </a>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <span class="px-4 py-2 bg-primary text-white rounded-lg font-semibold">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next Button --}}
                                @if ($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}"
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        Next
                                    </a>
                                @else
                                    <span
                                        class="px-4 py-2 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed">
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
@endsection

@push('scripts')
    <!-- Add Product Modal -->
    <div id="addProductModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <div
                class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-white">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Add New Product</h3>
                    <p class="text-sm text-gray-600 mt-1">Create a new menu item for your restaurant</p>
                </div>
                <button onclick="closeAddProductModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="addProductForm" class="p-6 space-y-4 overflow-y-auto max-h-[calc(90vh-180px)]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Product Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                        <input type="text" id="productName" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g. Nasi Goreng Spesial">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                        <select id="productCategory" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Select Category</option>
                            @foreach ($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price (Rp) *</label>
                        <input type="number" id="productPrice" required min="0" step="1000"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="25000">
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Initial Stock *</label>
                        <input type="number" id="productStock" required min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="50">
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Image Filename</label>
                        <input type="text" id="productImage"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="product.jpg">
                        <p class="text-xs text-gray-500 mt-1">Place image in public/images/ folder</p>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea id="productDescription" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Brief description of the product..."></textarea>
                    </div>
                </div>

                <div class="text-xs text-gray-500 bg-gray-50 p-3 rounded-lg">
                    <strong>Note:</strong> Fields marked with * are required
                </div>
            </form>
            <div class="flex items-center justify-end p-6 border-t border-gray-200 bg-gray-50 gap-3">
                <button onclick="closeAddProductModal()" type="button"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors">
                    Cancel
                </button>
                <button onclick="submitAddProduct()" type="button"
                    class="px-6 py-2.5 bg-primary hover:bg-orange-700 text-white font-semibold rounded-xl transition-colors">
                    Add Product
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <div
                class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Edit Product</h3>
                    <p class="text-sm text-gray-600 mt-1">Update menu item details</p>
                </div>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="editProductForm" class="p-6 space-y-4 overflow-y-auto max-h-[calc(90vh-180px)]">
                <input type="hidden" id="editProductId">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Product Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                        <input type="text" id="editProductName" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g. Nasi Goreng Spesial">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                        <select id="editProductCategory" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Select Category</option>
                            @foreach ($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price (Rp) *</label>
                        <input type="number" id="editProductPrice" required min="0" step="1000"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="25000">
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stock *</label>
                        <input type="number" id="editProductStock" required min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="50">
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Image Filename</label>
                        <input type="text" id="editProductImage"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="product.jpg">
                        <p class="text-xs text-gray-500 mt-1">Place image in public/images/ folder</p>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea id="editProductDescription" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Brief description of the product..."></textarea>
                    </div>
                </div>

                <div class="text-xs text-gray-500 bg-gray-50 p-3 rounded-lg">
                    <strong>Note:</strong> Fields marked with * are required
                </div>
            </form>
            <div class="flex items-center justify-end p-6 border-t border-gray-200 bg-gray-50 gap-3">
                <button onclick="closeEditModal()" type="button"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors">
                    Cancel
                </button>
                <button onclick="submitEditProduct()" type="button"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                    Update Product
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-red-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Delete Menu Item</h3>
                <p class="text-gray-600 text-center mb-6">
                    Are you sure you want to delete <strong id="deleteProductName"></strong>? This action cannot be
                    undone.
                </p>
                <input type="hidden" id="deleteProductId">
            </div>
            <div class="flex items-center justify-end p-6 border-t border-gray-200 bg-gray-50 gap-3">
                <button onclick="closeDeleteModal()" type="button"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors">
                    Cancel
                </button>
                <button onclick="submitDeleteProduct()" type="button"
                    class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-colors">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        // Event Listeners for Edit and Delete Buttons (using event delegation)
        document.addEventListener('DOMContentLoaded', function() {
            // Use event delegation for better reliability
            document.addEventListener('click', function(e) {
                // Handle edit button clicks
                if (e.target.closest('.edit-btn')) {
                    const button = e.target.closest('.edit-btn');
                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const categoryId = button.dataset.category;
                    const price = button.dataset.price;
                    const stock = button.dataset.stock;
                    const image = button.dataset.image;
                    const description = button.dataset.description;

                    openEditModal(id, name, categoryId, price, stock, image, description);
                }

                // Handle delete button clicks
                if (e.target.closest('.delete-btn')) {
                    const button = e.target.closest('.delete-btn');
                    const id = button.dataset.id;
                    const name = button.dataset.name;

                    confirmDelete(id, name);
                }
            });
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.menu-row');

            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                if (name.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Add Product Modal Functions
        function openAddProductModal() {
            document.getElementById('addProductModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddProductModal() {
            document.getElementById('addProductModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('addProductForm').reset();
        }

        async function submitAddProduct() {
            const name = document.getElementById('productName').value;
            const categoryId = document.getElementById('productCategory').value;
            const price = document.getElementById('productPrice').value;
            const stock = document.getElementById('productStock').value;
            const image = document.getElementById('productImage').value;
            const description = document.getElementById('productDescription').value;

            // Validation
            if (!name || !categoryId || !price || !stock) {
                alert('Please fill all required fields');
                return;
            }

            const data = {
                name: name,
                category_id: parseInt(categoryId),
                price: parseInt(price),
                stock: parseInt(stock),
                image: image || null,
                description: description || null
            };

            try {
                const response = await fetch('/api/products', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert('Product added successfully!');
                    closeAddProductModal();
                    window.location.reload();
                } else {
                    alert('Failed to add product: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to add product: ' + error.message);
            }
        }

        // Edit Product Modal Functions
        function openEditModal(id, name, categoryId, price, stock, image, description) {
            document.getElementById('editProductId').value = id;
            document.getElementById('editProductName').value = name;
            document.getElementById('editProductCategory').value = categoryId;
            document.getElementById('editProductPrice').value = price;
            document.getElementById('editProductStock').value = stock;
            document.getElementById('editProductImage').value = image || '';
            document.getElementById('editProductDescription').value = description || '';

            document.getElementById('editProductModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editProductModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('editProductForm').reset();
        }

        async function submitEditProduct() {
            const id = document.getElementById('editProductId').value;
            const name = document.getElementById('editProductName').value;
            const categoryId = document.getElementById('editProductCategory').value;
            const price = document.getElementById('editProductPrice').value;
            const stock = document.getElementById('editProductStock').value;
            const image = document.getElementById('editProductImage').value;
            const description = document.getElementById('editProductDescription').value;

            // Validation
            if (!name || !categoryId || !price || !stock) {
                alert('Please fill all required fields');
                return;
            }

            const data = {
                name: name,
                category_id: parseInt(categoryId),
                price: parseInt(price),
                stock: parseInt(stock),
                image: image || null,
                description: description || null
            };

            try {
                const response = await fetch(`/api/products/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert('Product updated successfully!');
                    closeEditModal();
                    window.location.reload();
                } else {
                    alert('Failed to update product: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to update product: ' + error.message);
            }
        }

        // Delete Product Modal Functions
        function confirmDelete(id, name) {
            document.getElementById('deleteProductId').value = id;
            document.getElementById('deleteProductName').textContent = name;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        async function submitDeleteProduct() {
            const id = document.getElementById('deleteProductId').value;

            try {
                const response = await fetch(`/api/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert('Product deleted successfully!');
                    closeDeleteModal();
                    window.location.reload();
                } else {
                    alert('Failed to delete product: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to delete product: ' + error.message);
            }
        }
    </script>
@endpush
