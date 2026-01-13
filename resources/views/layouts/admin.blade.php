<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Warung Bali Sangeh Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Styles -->
    @stack('styles')

    <style>
        @layer theme {
            :root {
                --color-primary: #ea580c;
                --color-primary-dark: #c2410c;
                --color-primary-light: #fb923c;
            }
        }

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
            scrollbar-width: none;
        }

        /* Custom progress bar */
        .progress-bar {
            transition: width 0.3s ease;
        }

        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-duration: 200ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-200"><div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <x-admin-sidebar :active="$active ?? trim($__env->yieldContent('active')) ?: 'dashboard'" />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // CSRF Token setup for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Global fetch wrapper with CSRF token
        window.fetchWithCSRF = function(url, options = {}) {
            options.headers = {
                ...options.headers,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            };
            return fetch(url, options);
        };
    </script>

    @stack('scripts')
</body>

</html>
