@extends('layouts.admin')

@section('title', 'Transaksi')

@section('content')
    <!-- Top Bar -->
    <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Transaksi</h1>
            <p class="text-sm text-gray-500">Kelola dan pantau semua transaksi pembayaran</p>
        </div>
        <div class="flex items-center gap-4">
            <button onclick="exportTransactions()"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Export Excel
            </button>
            <span class="text-sm text-gray-600">{{ now()->format('l, d F Y') }}</span>
        </div>
    </header>

    <!-- Content Area -->
    <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
        <x-alert />
        <div class="max-w-7xl mx-auto space-y-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Transactions -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-gray-500 text-sm font-medium">Total Transaksi</span>
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($totalTransactions) }}</div>
                    <p class="text-xs text-gray-500 mt-1">Semua waktu</p>
                </div>

                <!-- Total Amount -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-gray-500 text-sm font-medium">Total Pendapatan</span>
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">Rp{{ number_format($totalAmount, 0, ',', '.') }}</div>
                    <p class="text-xs text-gray-500 mt-1">Transaksi berhasil</p>
                </div>

                <!-- Pending Transactions -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-gray-500 text-sm font-medium">Pending</span>
                        <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($pendingTransactions) }}</div>
                    <p class="text-xs text-gray-500 mt-1">Menunggu pembayaran</p>
                </div>

                <!-- Today's Transactions -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-gray-500 text-sm font-medium">Hari Ini</span>
                        <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($todayTransactions) }}</div>
                    <p class="text-xs text-gray-500 mt-1">Transaksi hari ini</p>
                </div>
            </div>

            <!-- Filter & Search Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <form method="GET" action="{{ route('admin.transactions') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Transaksi</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nomor transaksi atau order..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                            <select name="payment_method"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Semua</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS
                                </option>
                                <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>
                                    Transfer</option>
                            </select>
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="payment_status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Semua</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed
                                </option>
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <!-- Amount Min -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Min</label>
                            <input type="number" name="amount_min" value="{{ request('amount_min') }}" placeholder="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <!-- Amount Max -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Max</label>
                            <input type="number" name="amount_max" value="{{ request('amount_max') }}"
                                placeholder="999999999"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex gap-3 justify-end">
                        <a href="{{ route('admin.transactions') }}"
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors">
                            Reset
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-primary hover:bg-orange-700 text-white font-semibold rounded-xl transition-colors">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="font-bold text-gray-900">Daftar Transaksi</h2>
                    <p class="text-sm text-gray-500 mt-1">Menampilkan {{ $transactions->count() }} dari
                        {{ $transactions->total() }} transaksi</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">No. Transaksi</th>
                                <th class="px-6 py-4 font-semibold">No. Order</th>
                                <th class="px-6 py-4 font-semibold">Metode</th>
                                <th class="px-6 py-4 font-semibold">Jumlah</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold">Tanggal</th>
                                <th class="px-6 py-4 font-semibold">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $transaction->transaction_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="/dashboard/orders?view={{ $transaction->order->order_number ?? '' }}"
                                            class="text-primary hover:underline font-medium">
                                            #{{ $transaction->order->order_number ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $methodClasses = [
                                                'cash' => 'bg-green-100 text-green-800',
                                                'qris' => 'bg-blue-100 text-blue-800',
                                                'transfer' => 'bg-purple-100 text-purple-800',
                                            ];
                                            $methodText = strtoupper($transaction->payment_method);
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $methodClasses[$transaction->payment_method] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $methodText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'paid' => 'bg-green-100 text-green-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'failed' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusText = ucfirst($transaction->payment_status);
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$transaction->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                        {{ $transaction->notes ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="w-16 h-16 mb-4 text-gray-300">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                            </svg>
                                            <p class="text-lg font-semibold text-gray-700">Tidak ada transaksi</p>
                                            <p class="text-sm text-gray-500 mt-1">Belum ada transaksi yang ditemukan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($transactions->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Menampilkan {{ $transactions->firstItem() }} - {{ $transactions->lastItem() }} dari
                                {{ $transactions->total() }} transaksi
                            </div>
                            <div class="flex gap-2">
                                {{-- Previous Button --}}
                                @if ($transactions->onFirstPage())
                                    <span
                                        class="px-4 py-2 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $transactions->previousPageUrl() }}"
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        Previous
                                    </a>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                    @if ($page == $transactions->currentPage())
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
                                @if ($transactions->hasMorePages())
                                    <a href="{{ $transactions->nextPageUrl() }}"
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
    <script>
        function exportTransactions() {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);

            // Construct export URL with current parameters
            const exportUrl = "{{ route('admin.transactions.export') }}?" + urlParams.toString();

            // Redirect to trigger download
            window.location.href = exportUrl;
        }
    </script>
@endpush
