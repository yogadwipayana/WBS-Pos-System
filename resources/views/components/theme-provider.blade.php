<style>
    :root {
        --color-primary: {{ $themeColors['primary'] }};
        --color-primary-dark: {{ $themeColors['primary_dark'] }};
        --color-primary-light: {{ $themeColors['primary_light'] }};
        --color-secondary: {{ $themeColors['secondary'] }};
    }

    /* Primary Colors */
    .text-primary {
        color: var(--color-primary) !important;
    }

    .bg-primary {
        background-color: var(--color-primary) !important;
    }

    .border-primary {
        border-color: var(--color-primary) !important;
    }

    .hover\:bg-primary-dark:hover {
        background-color: var(--color-primary-dark) !important;
    }

    .hover\:text-primary:hover {
        color: var(--color-primary) !important;
    }

    .bg-orange-50 {
        background-color: var(--color-primary-light) !important;
    }

    /* Focus states */
    .focus\:ring-orange-500:focus {
        --tw-ring-color: var(--color-primary);
    }

    .focus\:border-orange-500:focus {
        border-color: var(--color-primary);
    }

    /* Dark mode base styles */
    @if($darkMode)
    body {
        background-color: #1a202c;
        color: #e2e8f0;
    }

    .bg-gray-50 {
        background-color: #1a202c !important;
    }

    .bg-white {
        background-color: #2d3748 !important;
    }

    .text-gray-900 {
        color: #f3f4f6 !important;
    }

    .text-gray-800 {
        color: #e5e7eb !important;
    }

    .text-gray-700 {
        color: #d1d5db !important;
    }

    .text-gray-600 {
        color: #d1d5db !important;
    }

    .text-gray-500 {
        color: #9ca3af !important;
    }

    .text-gray-400 {
        color: #9ca3af !important;
    }

    .border-gray-200 {
        border-color: #4a5568 !important;
    }

    .border-gray-100 {
        border-color: #374151 !important;
    }

    .hover\:bg-gray-50:hover {
        background-color: #374151 !important;
    }

    .hover\:text-gray-900:hover {
        color: #f3f4f6 !important;
    }

    .hover\:text-gray-600:hover {
        color: #d1d5db !important;
    }

    /* Fix for specific elements that need better visibility in dark mode */
    header .text-gray-700,
    header .text-gray-600 {
        color: #e5e7eb !important;
    }

    /* Make sure badges and tags are readable */
    .bg-blue-100 {
        background-color: #1e3a8a !important;
    }

    .text-blue-800 {
        color: #93c5fd !important;
    }

    .bg-green-100 {
        background-color: #14532d !important;
    }

    .text-green-800 {
        color: #86efac !important;
    }

    .bg-yellow-100 {
        background-color: #713f12 !important;
    }

    .text-yellow-800 {
        color: #fde047 !important;
    }

    .bg-red-100 {
        background-color: #7f1d1d !important;
    }

    .text-red-800 {
        color: #fca5a5 !important;
    }

    .bg-purple-100 {
        background-color: #581c87 !important;
    }

    .text-purple-800 {
        color: #d8b4fe !important;
    }

    /* Input fields in dark mode */
    input, textarea, select {
        background-color: #374151 !important;
        color: #e5e7eb !important;
        border-color: #4b5563 !important;
    }

    input::placeholder, textarea::placeholder {
        color: #9ca3af !important;
    }

    input:focus, textarea:focus, select:focus {
        background-color: #374151 !important;
        border-color: var(--color-primary) !important;
    }

    /* Tables in dark mode */
    table thead {
        background-color: #1f2937 !important;
    }

    table tbody tr:hover {
        background-color: #374151 !important;
    }
    @endif
</style>
