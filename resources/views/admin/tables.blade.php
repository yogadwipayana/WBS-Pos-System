@extends('admin.layout.app') <!-- Layout utama admin -->

@section('title', 'QR Meja #' . $table->number)

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">QR Code Meja #{{ $table->number }}</h1>

    <div class="bg-white rounded-xl p-6 shadow-md flex flex-col items-center gap-6">

        <!-- QR Code -->
        <div class="border p-4 rounded-lg bg-gray-50">
            {!! $qr !!} <!-- QR code SVG -->
        </div>

        <p class="text-gray-600 text-center">
            Scan QR ini untuk mengakses menu pelanggan di meja ini.
        </p>

        <!-- Tombol kembali -->
        <div class="flex gap-4">
            <a href="{{ url('/dashboard/tables') }}" 
               class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-500 transition-colors">
               Kembali ke Daftar Meja
            </a>

            <!-- Tombol print -->
            <button onclick="window.print()" 
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 transition-colors">
                Print QR
            </button>
        </div>
    </div>
</div>

<!-- Optional: hide buttons saat print -->
<style>
    @media print {
        button, a[href] { display: none !important; }
    }
</style>
@endsection
