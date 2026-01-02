@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@push('styles')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
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
@endpush

@section('content')
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
                <x-alert />
                <div class="max-w-7xl mx-auto space-y-6">

                    <!-- Page Header -->
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold text-gray-900">Dasbor</h1>
                        <button
                            class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-xl font-semibold shadow-sm text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            New Order
                        </button>
                    </div>

                    <!-- Charts Grid -->
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Card 1: Total Pendapatan (Hari Ini) -->
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                                    <p class="text-xs text-green-600 mt-1">Pendapatan Hari Ini</p>
                                </div>
                                <div class="p-2 bg-green-50 rounded-lg group-hover:bg-green-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                Rp{{ number_format($revenueToday, 0, ',', '.') }}</h3>
                            <p class="text-xs text-gray-400 mt-2">From completed orders</p>
                        </div>

                        <!-- Card 2: Pendapatan Minggu Ini -->
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Pendapatan Minggu Ini</p>
                                    <p class="text-xs text-orange-600 mt-1">7 Hari Terakhir</p>
                                </div>
                                <div class="p-2 bg-orange-50 rounded-lg group-hover:bg-orange-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                Rp{{ number_format($revenueWeek, 0, ',', '.') }}</h3>
                        </div>

                        <!-- Card 3: Active Orders -->
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Active Orders</p>
                                </div>
                                <div class="p-2 bg-orange-50 rounded-lg group-hover:bg-orange-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $activeOrdersCount }}</h3>
                            <p class="text-xs text-orange-500 font-bold mt-2">Pending + Preparing + Ready</p>
                        </div>


                        <!-- Card 4: Bestseller -->
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Bestseller</p>
                                </div>
                                <div class="p-2 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                            </div>
                            @if ($bestseller)
                                <h3 class="text-xl font-bold text-gray-900 uppercase truncate"
                                    title="{{ $bestseller->product_name }}">
                                    {{ Str::limit($bestseller->product_name, 15) }}</h3>
                                <p class="text-xs text-gray-400 mt-2">{{ $bestseller->total_sold }} sold</p>
                            @else
                                <h3 class="text-lg font-bold text-gray-500">-</h3>
                                <p class="text-xs text-gray-400 mt-2">No sales yet</p>
                            @endif
                        </div>

                    </div>



                    <!-- Sales Chart -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                            <div>
                                <h2 class="font-bold text-gray-900">Penjualan 7 Hari Terakhir</h2>
                                <p class="text-sm text-gray-500 mt-1">Data penjualan dan jumlah pesanan harian</p>
                            </div>
                            <div class="flex gap-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                                    <span class="text-gray-600">Pendapatan</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-gray-600">Pesanan</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <canvas id="salesChart" height="80"></canvas>
                        </div>
                    </div>

                </div>
            </main>
@endsection

@push('scripts')
    <script>
        // Initialize All Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Main Sales Chart
            const ctx = document.getElementById('salesChart').getContext('2d');

            // Data from Laravel
            const chartData = @json($chartData);
            const labels = chartData.map(item => item.label);
            const salesData = chartData.map(item => item.total_sales);
            const ordersData = chartData.map(item => item.total_orders);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: salesData,
                            borderColor: '#f05a28',
                            backgroundColor: 'rgba(240, 90, 40, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            yAxisID: 'y',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#f05a28',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                        },
                        {
                            label: 'Jumlah Pesanan',
                            data: ordersData,
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            yAxisID: 'y1',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#2563eb',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.dataset.yAxisID === 'y') {
                                        label += 'Rp ' + Number(context.parsed.y).toLocaleString(
                                            'id-ID');
                                    } else {
                                        label += context.parsed.y + ' pesanan';
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6b7280'
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6b7280',
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID', {
                                        maximumFractionDigits: 0
                                    });
                                }
                            },
                            title: {
                                display: true,
                                text: 'Pendapatan (Rp)',
                                color: '#f05a28',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false,
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6b7280',
                                stepSize: 1
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Pesanan',
                                color: '#2563eb',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
