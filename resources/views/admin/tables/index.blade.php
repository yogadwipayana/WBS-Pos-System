@extends('layouts.admin')

@section('title', 'QR Meja')

@section('content')
    <!-- Top Bar -->
    <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">QR Meja</h1>
            <p class="text-sm text-gray-500">Kelola QR code untuk setiap meja</p>
        </div>
        <div class="flex items-center gap-4">
            @if (session('admin_role') === 'admin')
                <button onclick="openAddTableModal()"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Meja
                </button>
            @endif
            <span class="text-sm text-gray-600">{{ now()->format('l, d F Y') }}</span>
        </div>
    </header>

    <!-- Content Area -->
    <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
        <x-alert />
        <div class="max-w-7xl mx-auto space-y-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Tables -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-gray-500 text-sm font-medium">Total Meja</span>
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $tables->count() }}</div>
                    <p class="text-xs text-gray-500 mt-1">Meja terdaftar</p>
                </div>

                <!-- Active Tables -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-gray-500 text-sm font-medium">Meja Aktif</span>
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $tables->where('is_active', true)->count() }}</div>
                    <p class="text-xs text-gray-500 mt-1">Siap digunakan</p>
                </div>

                <!-- QR Codes Generated -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-gray-500 text-sm font-medium">QR Code</span>
                        <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $tables->count() }}</div>
                    <p class="text-xs text-gray-500 mt-1">Siap di-scan</p>
                </div>
            </div>

            <!-- Tables List -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="font-bold text-gray-900">Daftar Meja</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola semua meja dan QR code</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">No</th>
                                <th class="px-6 py-4 font-semibold">Nomor Meja</th>
                                <th class="px-6 py-4 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse ($tables as $table)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 font-bold">
                                                {{ $table->number }}
                                            </div>
                                            <span class="font-semibold text-gray-900">Meja {{ $table->number }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <!-- Lihat QR Button -->
                                            <a href="{{ route('admin.tables.qr', $table->id) }}"
                                                class="px-3 py-1.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-xs font-semibold flex items-center gap-1 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                Lihat QR
                                            </a>

                                            <!-- Print QR Button -->
                                            <a href="{{ route('admin.tables.print', $table->id) }}" target="_blank"
                                                class="px-3 py-1.5 bg-orange-500 text-white rounded-lg hover:bg-orange-600 text-xs font-semibold flex items-center gap-1 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                                </svg>
                                                Print QR
                                            </a>

                                            @if (session('admin_role') === 'admin')
                                                <!-- Delete Button (Admin Only) -->
                                                <button onclick="confirmDelete({{ $table->id }}, {{ $table->number }})"
                                                    class="px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs font-semibold flex items-center gap-1 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="w-16 h-16 mb-4 text-gray-300">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                            </svg>
                                            <p class="text-lg font-semibold text-gray-700">Belum ada meja</p>
                                            <p class="text-sm text-gray-500 mt-1">Klik "Tambah Meja" untuk menambahkan meja
                                                baru
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if ($tables->hasPages())
                    <div class="bg-white px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-semibold">{{ $tables->firstItem() }}</span>
                                to <span class="font-semibold">{{ $tables->lastItem() }}</span>
                                of <span class="font-semibold">{{ $tables->total() }}</span> results
                            </div>
                            <div class="flex gap-2">
                                {{-- Previous Page Link --}}
                                @if ($tables->onFirstPage())
                                    <span
                                        class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $tables->previousPageUrl() }}"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        Previous
                                    </a>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach ($tables->getUrlRange(1, $tables->lastPage()) as $page => $url)
                                    @if ($page == $tables->currentPage())
                                        <span
                                            class="px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-orange-600 rounded-lg">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($tables->hasMorePages())
                                    <a href="{{ $tables->nextPageUrl() }}"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        Next
                                    </a>
                                @else
                                    <span
                                        class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
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
    <!-- Add Table Modal -->
    <div id="addTableModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background-color: rgba(0, 0, 0, 0.4); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
            <div
                class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-white">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Tambah Meja Baru</h3>
                    <p class="text-sm text-gray-600 mt-1">Buat QR code untuk meja baru</p>
                </div>
                <button onclick="closeAddTableModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="addTableForm" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Meja *</label>
                    <input type="number" id="tableNumber" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-600 focus:border-transparent"
                        placeholder="Masukkan nomor meja (contoh: 1)">
                    <p class="text-xs text-gray-500 mt-1">QR code akan otomatis dibuat untuk meja ini</p>
                </div>
            </form>
            <div class="flex items-center justify-end p-6 border-t border-gray-200 bg-gray-50 gap-3">
                <button onclick="closeAddTableModal()" type="button"
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <button onclick="submitAddTable()" type="button"
                    class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-xl transition-colors">
                    Tambah Meja
                </button>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function openAddTableModal() {
            document.getElementById('addTableModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddTableModal() {
            document.getElementById('addTableModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('addTableForm').reset();
        }

        // Submit Add Table
        async function submitAddTable() {
            const submitBtn = document.querySelector('button[onclick="submitAddTable()"]');
            const originalBtnText = submitBtn.innerHTML;

            const tableNumber = document.getElementById('tableNumber').value;

            // Validation
            if (!tableNumber || tableNumber < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nomor Meja Diperlukan',
                    text: 'Silakan masukkan nomor meja yang valid'
                });
                return;
            }

            try {
                const formData = new FormData();
                formData.append('number', tableNumber);

                // Disable button and show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="animate-spin inline-block w-4 h-4 border-[2px] border-current border-t-transparent text-white rounded-full mr-2"></span> Menyimpan...';

                const response = await fetch('{{ route('admin.tables.store') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Meja berhasil ditambahkan dengan QR code',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        closeAddTableModal();
                        window.location.reload();
                    });
                } else {
                    // Handle validation errors
                    let errorMessage = 'Gagal menambahkan meja';
                    if (result.message) {
                        errorMessage = result.message;
                    } else if (result.errors) {
                        // Laravel validation errors
                        const errors = Object.values(result.errors).flat();
                        errorMessage = errors.join(', ');
                    }

                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan: ' + error.message
                });
            } finally {
                // Reset button state
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            }
        }

        // Delete Table
        async function confirmDelete(tableId, tableNumber) {
            const result = await Swal.fire({
                title: 'Hapus Meja?',
                text: `Apakah Anda yakin ingin menghapus Meja ${tableNumber}? QR code juga akan dihapus.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/api/tables/${tableId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: 'Meja berhasil dihapus',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Gagal menghapus meja'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' + error.message
                    });
                }
            }
        }
    </script>
@endpush
