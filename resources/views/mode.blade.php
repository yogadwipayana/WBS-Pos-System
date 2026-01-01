<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulai Pesan - Warung Bali Sangeh</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    @endif
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex justify-center">
    <!-- Mobile Container Wrapper -->
    <div class="w-full max-w-[500px] bg-gray-50 min-h-screen relative shadow-2xl overflow-hidden">

        <!-- Background Top Blur/Image -->
        <div class="h-48 bg-gray-200 w-full absolute top-0 z-0 overflow-hidden">
            <!-- Placeholder for a blurry shop background looking similar to the design -->
            <img src="{{ asset('images/sawah.jpg') }}" alt="Background"
                class="w-full h-full object-cover blur-sm opacity-50">
            <div class="absolute inset-0 bg-white/30"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 w-full min-h-screen flex flex-col">
            <!-- Header -->
            <div class="p-4 flex justify-between items-center">
                <button class="bg-white p-2 rounded-full shadow-sm hover:shadow-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <div
                    class="bg-white px-3 py-1.5 rounded-lg shadow-sm flex items-center gap-2 cursor-pointer hover:shadow-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S13.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m-7.843 3.751c1.457 0 2.816-.957 3.597-2.427m-7.194 0c.781 1.47 2.14 2.427 3.597 2.427m3.562-10.463c-.888 1.159-2.072 2.016-3.412 2.43m-3.412-2.43c-1.341-.414-2.525-1.271-3.412-2.43" />
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">ID</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
            <!-- Store Card -->
            <div class="px-4 mt-8">
                <div class="bg-white rounded-2xl shadow-lg p-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <!-- Store Icon Placeholder -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900 text-lg leading-tight">Warung Bali Sangeh</h2>
                            <!-- Optional location text if needed, preserving 'Denpasar Gatsu' vibe from image or using actual location -->
                            <!-- <p class="text-sm text-gray-500">Sangeh, Bali</p> -->
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- How to Use Section -->
            <div class="px-8 mt-10 text-center">
                <h3 class="text-gray-900 font-bold text-lg mb-6">Cara Menggunakan WBS Order</h3>
                <div class="flex items-center justify-center gap-2">
                    <!-- Step 1: Order -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 mx-auto bg-orange-50 rounded-full flex items-center justify-center mb-2 shadow-sm border border-orange-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-orange-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <span class="text-gray-600 font-medium text-sm">Pesan</span>
                    </div>
                    <!-- Arrow -->
                    <div class="text-gray-300 pb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                    <!-- Step 2: Pay -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 mx-auto bg-orange-50 rounded-full flex items-center justify-center mb-2 shadow-sm border border-orange-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-orange-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>
                        </div>
                        <span class="text-gray-600 font-medium text-sm">Bayar</span>
                    </div>
                    <!-- Arrow -->
                    <div class="text-gray-300 pb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </div>
                    <!-- Step 3: Eat -->
                    <div class="text-center group">
                        <div
                            class="w-16 h-16 mx-auto bg-orange-50 rounded-full flex items-center justify-center mb-2 shadow-sm border border-orange-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-orange-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                        </div>
                        <span class="text-gray-600 font-medium text-sm">Makan</span>
                    </div>
                </div>
            </div>
            <!-- Dining Options -->
            <div class="px-4 mt-12 flex-grow">
                <h3 class="text-center text-gray-900 font-bold text-lg mb-6">Bagaimana Anda ingin makan hari ini?</h3>
                <div class="space-y-4">
                    <button onclick="window.location.href = '/order?mode=dinein';"
                        class="w-full bg-white border border-gray-200 text-gray-800 font-bold py-4 rounded-xl shadow-sm hover:border-gray-300 hover:bg-gray-50 transition active:scale-[0.99]">
                        Makan di Tempat
                    </button>
                    <button onclick="window.location.href = '/order?mode=takeaway';"
                        class="w-full bg-white border border-gray-200 text-gray-800 font-bold py-4 rounded-xl shadow-sm hover:border-gray-300 hover:bg-gray-50 transition active:scale-[0.99]">
                        Takeaway
                    </button>
                </div>
            </div>
            <!-- Footer -->
            <div class="mt-auto py-8 text-center flex items-center justify-center gap-2 text-gray-400">
                <span class="text-sm">Dibuat oleh</span>
                <!-- Logo WBS simple text or replacement -->
                <span class="font-bold text-gray-500 text-lg">WBS</span>
            </div>
        </div>
    </div>
</body>

</html>
