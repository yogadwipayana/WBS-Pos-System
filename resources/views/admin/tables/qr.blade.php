@extends('layouts.admin')

@section('title', 'QR Code Meja ' . $table->number)

@section('content')
    <!-- Top Bar -->
    <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">QR Code - Meja {{ $table->number }}</h1>
            <p class="text-sm text-gray-500">Scan QR code untuk akses menu</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.tables.index') }}"
                class="px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-100 transition-colors text-sm">
                Kembali
            </a>
        </div>
    </header>

    <!-- Content Area -->
    <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Meja {{ $table->number }}</h2>
                            <p class="text-sm text-gray-600 mt-1">QR Code untuk akses menu pelanggan</p>
                        </div>
                        <div
                            class="w-16 h-16 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-2xl">
                            {{ $table->number }}
                        </div>
                    </div>
                </div>

                <!-- QR Code Display -->
                <div class="p-8">
                    <div class="flex flex-col items-center justify-center space-y-6">
                        <!-- QR Code -->
                        <div class="bg-white p-6 rounded-2xl border-4 border-orange-500 shadow-lg">
                            {!! $qrCode !!}
                        </div>

                        <!-- URL Info -->
                        <div class="w-full bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">URL Tujuan:</p>
                            <p class="text-sm text-gray-900 font-mono break-all">{{ $url }}</p>
                        </div>

                        <!-- Instructions -->
                        <div class="w-full bg-blue-50 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-6 h-6 text-blue-600 flex-shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900 mb-1">Cara Penggunaan:</p>
                                    <ol class="text-sm text-blue-800 space-y-1 list-decimal list-inside">
                                        <li>Pelanggan scan QR code menggunakan kamera smartphone</li>
                                        <li>Otomatis diarahkan ke halaman menu</li>
                                        <li>Nomor meja akan tersimpan otomatis saat order</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 w-full">
                            <a href="{{ route('admin.tables.print', $table->id) }}" target="_blank"
                                class="flex-1 px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-xl transition-colors text-center flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                </svg>
                                Print QR Code
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Table Info -->
                <div class="p-6 border-t border-gray-100 bg-gray-50">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Nomor Meja</p>
                            <p class="text-lg font-bold text-gray-900">{{ $table->number }}</p>
                        </div>
                        <!-- Status removed as requested -->
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
