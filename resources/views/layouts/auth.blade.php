@inject('settingsService', 'App\Services\SettingsManagementService')
@php
    $siteSettings = $settingsService->getSettings();
    $defaultTheme = $siteSettings['default_theme'] ?? 'light';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . ($siteSettings['favicon'] ?? 'favicon.ico')) }}">
    <title>{{ $title ?? __('Login') }} - {{ __('Dashboard') }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    <script>
        function applyTheme() {
            const theme = localStorage.getItem('admin_theme');
            const defaultTheme = '{{ $defaultTheme }}';
            const isDark = theme === 'dark' || (!theme && defaultTheme === 'dark') || (!theme && defaultTheme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        // Apply theme immediately
        applyTheme();

        // Re-apply on Livewire navigation
        document.addEventListener('livewire:navigated', applyTheme);
    </script>

    @livewireStyles
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition-colors duration-300">
    {{ $slot }}

    @livewireScripts
</body>

</html>