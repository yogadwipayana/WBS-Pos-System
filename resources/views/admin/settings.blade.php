<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Settings - Warung Bali Sangeh Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    
    <!-- Theme Provider -->
    <x-theme-provider />
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        /* Hide scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Toggle Switch */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #f05a28;
        }
        
        .toggle-checkbox:checked + .toggle-label {
            background-color: #f05a28;
        }

        /* Theme preview animation */
        .theme-card {
            transition: all 0.3s ease;
        }

        .theme-card:hover {
            transform: translateY(-4px);
        }

        .theme-card.selected {
            border-width: 2px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Dark mode styles */
        .dark-mode {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        .dark-mode .bg-white {
            background-color: #2d3748;
        }

        .dark-mode .text-gray-900 {
            color: #e2e8f0;
        }

        .dark-mode .text-gray-600 {
            color: #cbd5e0;
        }

        .dark-mode .text-gray-500 {
            color: #a0aec0;
        }

        .dark-mode .border-gray-200 {
            border-color: #4a5568;
        }

        .dark-mode .border-gray-100 {
            border-color: #374151;
        }

        .dark-mode .bg-gray-50 {
            background-color: #1a202c;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Component -->
        <x-admin-sidebar active="settings" />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- Top Bar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 -ml-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Title -->
                <div class="flex-1">
                    <h2 class="text-lg font-semibold text-gray-900">Pengaturan Aplikasi</h2>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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
                <div class="max-w-5xl mx-auto space-y-6">

                    <!-- Page Header -->
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Pengaturan</h1>
                        <p class="text-gray-500 mt-1">Sesuaikan tampilan dashboard admin Anda</p>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Mode Gelap</h3>
                                <p class="text-sm text-gray-500">Beralih antara tema terang dan gelap</p>
                            </div>
                            <div class="relative inline-block w-16 mr-2 align-middle select-none">
                                <input type="checkbox" id="darkModeToggle" 
                                    class="toggle-checkbox absolute block w-8 h-8 rounded-full bg-white border-4 appearance-none cursor-pointer transition-all duration-300 ease-in-out"
                                    {{ $darkMode ? 'checked' : '' }}
                                    style="right: 2rem; top: 0.125rem;">
                                <label for="darkModeToggle"
                                    class="toggle-label block overflow-hidden h-10 rounded-full bg-gray-300 cursor-pointer transition-colors duration-300"></label>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Selection -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Tema Warna</h3>
                            <p class="text-sm text-gray-500">Pilih skema warna yang Anda sukai</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($themes as $theme)
                                <div class="theme-card cursor-pointer border-2 rounded-xl p-4 transition-all {{ $currentTheme === $theme['id'] ? 'selected' : 'border-gray-200' }}"
                                    data-theme="{{ $theme['id'] }}"
                                    data-primary="{{ $theme['primary'] }}"
                                    data-secondary="{{ $theme['secondary'] }}"
                                    style="{{ $currentTheme === $theme['id'] ? 'border-color: ' . $theme['primary'] : '' }}">
                                    
                                    <!-- Theme Preview -->
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="flex gap-2">
                                            <div class="w-8 h-8 rounded-lg shadow-sm" 
                                                style="background-color: {{ $theme['primary'] }}"></div>
                                            <div class="w-8 h-8 rounded-lg shadow-sm" 
                                                style="background-color: {{ $theme['secondary'] }}"></div>
                                        </div>
                                        @if($currentTheme === $theme['id'])
                                            <div class="ml-auto">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                                    stroke-width="2" stroke="currentColor" class="w-6 h-6" 
                                                    style="color: {{ $theme['primary'] }}">
                                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Theme Info -->
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-1">{{ $theme['name'] }}</h4>
                                        <p class="text-xs text-gray-500">{{ $theme['description'] }}</p>
                                    </div>

                                    <!-- Mini Preview -->
                                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="w-3 h-3 rounded-full" 
                                                style="background-color: {{ $theme['primary'] }}"></div>
                                            <div class="h-2 bg-gray-200 rounded flex-1"></div>
                                        </div>
                                        <div class="flex gap-1">
                                            <div class="h-8 bg-gray-200 rounded flex-1"></div>
                                            <div class="h-8 rounded px-3 flex items-center text-xs text-white font-medium" 
                                                style="background-color: {{ $theme['primary'] }}">
                                                Button
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-end gap-3">
                        <button id="resetBtn"
                            class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                            Reset ke Default
                        </button>
                        <button id="saveBtn"
                            class="px-6 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>

                    <!-- Success Message -->
                    <div id="successMessage" class="hidden fixed bottom-6 right-6 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 z-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Pengaturan berhasil disimpan!</span>
                    </div>

                </div>
            </main>

        </div>
    </div>

    <script>
        // Current settings
        let selectedTheme = '{{ $currentTheme }}';
        let darkModeEnabled = {{ $darkMode ? 'true' : 'false' }};

        // Theme selection
        document.querySelectorAll('.theme-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all
                document.querySelectorAll('.theme-card').forEach(c => {
                    c.classList.remove('selected');
                    c.style.borderColor = '';
                });

                // Add selected class to clicked
                this.classList.add('selected');
                const primary = this.dataset.primary;
                this.style.borderColor = primary;
                selectedTheme = this.dataset.theme;

                // Update colors preview
                updateThemePreview(primary);
            });
        });

        // Dark mode toggle
        document.getElementById('darkModeToggle').addEventListener('change', function() {
            darkModeEnabled = this.checked;
            if (this.checked) {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
        });

        // Initialize dark mode on load
        if (darkModeEnabled) {
            document.body.classList.add('dark-mode');
        }

        // Save button
        document.getElementById('saveBtn').addEventListener('click', async function() {
            try {
                const response = await fetch('/api/admin/settings', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        theme: selectedTheme,
                        dark_mode: darkModeEnabled
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Show success message
                    const successMsg = document.getElementById('successMessage');
                    successMsg.classList.remove('hidden');
                    
                    setTimeout(() => {
                        successMsg.classList.add('hidden');
                        // Reload page to apply changes
                        window.location.reload();
                    }, 1500);
                }
            } catch (error) {
                console.error('Error saving settings:', error);
                alert('Failed to save settings. Please try again.');
            }
        });

        // Reset button
        document.getElementById('resetBtn').addEventListener('click', function() {
            if (confirm('Are you sure you want to reset to default settings?')) {
                selectedTheme = 'orange';
                darkModeEnabled = false;
                
                // Reset UI
                document.getElementById('darkModeToggle').checked = false;
                document.body.classList.remove('dark-mode');
                
                // Reset theme selection
                document.querySelectorAll('.theme-card').forEach(card => {
                    card.classList.remove('selected');
                    card.style.borderColor = '';
                    if (card.dataset.theme === 'orange') {
                        card.classList.add('selected');
                        card.style.borderColor = card.dataset.primary;
                    }
                });

                updateThemePreview('#f05a28');
            }
        });

        function updateThemePreview(primaryColor) {
            // Update any primary color elements
            document.querySelectorAll('.text-primary').forEach(el => {
                el.style.color = primaryColor;
            });
            document.querySelectorAll('.bg-primary').forEach(el => {
                el.style.backgroundColor = primaryColor;
            });
        }
    </script>

</body>

</html>
