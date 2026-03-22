@inject('settingsService', 'App\Services\SettingsManagementService')
@php
    $siteSettings = $settingsService->getLocalizedSettings();
    $rawSettings = $settingsService->getSettings();
    $darkSupported = $siteSettings['dark_mode_supported'] ?? true;
    $defaultTheme = $siteSettings['default_theme'] ?? 'light';
    $showToggle = $siteSettings['show_theme_toggle'] ?? true;

    $logoLight = $rawSettings['logo_light'] ?? null;
    $logoDark = $rawSettings['logo_dark'] ?? null;
    $siteName = $siteSettings['site_name'] ?? config('app.name');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    x-data="{ 
    darkMode: localStorage.getItem('admin_theme') === 'dark' || (!localStorage.getItem('admin_theme') && '{{ $defaultTheme }}' === 'dark') || (!localStorage.getItem('admin_theme') && '{{ $defaultTheme }}' === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('admin_theme', this.darkMode ? 'dark' : 'light');
        if (typeof applyTheme === 'function') applyTheme();
    }
}" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . ($siteSettings['favicon'] ?? 'favicon.ico')) }}">
    <title>{{ $title ?? __('Dashboard') }} - {{ $siteName }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <style>
        body {
            font-family: 'tajawal', 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

<body class="bg-gray-50 dark:bg-gray-950 flex h-screen overflow-hidden transition-colors duration-300">
    <!-- Sidebar -->
    <aside
        class="w-64 bg-white dark:bg-gray-900 border-l border-gray-200 dark:border-gray-800 flex-shrink-0 flex flex-col transition-colors duration-300">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
            @if($logoLight || $logoDark)
                <div class="w-10 h-10 flex items-center justify-center">
                    @if($logoLight)
                        <img src="{{ asset('storage/' . $logoLight) }}" x-show="!darkMode"
                            class="max-w-full max-h-full object-contain" alt="Logo">
                    @endif
                    @if($logoDark)
                        <img src="{{ asset('storage/' . $logoDark) }}" x-show="darkMode"
                            class="max-w-full max-h-full object-contain" alt="Logo">
                    @else
                        <img src="{{ asset('storage/' . $logoLight) }}" x-show="darkMode"
                            class="max-w-full max-h-full object-contain" alt="Logo">
                    @endif
                </div>
            @else
                <div
                    class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center text-white font-bold">
                    {{ substr($siteName, 0, 2) }}
                </div>
            @endif
            <span class="text-xl font-bold text-gray-900 dark:text-white truncate"
                title="{{ $siteName }}">{{ $siteName }}</span>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <div class="pt-4 pb-2">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4">{{ __('Core') }}</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Home') }}</span>
            </a>

            <a href="{{ route('admin.services') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.services') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="briefcase" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Services') }}</span>
            </a>

            <a href="{{ route('admin.products') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.products') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="package" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Products') }}</span>
            </a>

            <div class="pt-6 pb-2">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4">{{ __('Management') }}
                </p>
            </div>

            <a href="{{ route('admin.clients') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.clients') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Clients') }}</span>
            </a>

            <a href="{{ route('admin.projects') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.projects*') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="folder-kanban" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Projects') }}</span>
            </a>

            <a href="{{ route('admin.employees') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.employees') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="user-check" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Employees') }}</span>
            </a>

            <a href="{{ route('admin.tickets') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.tickets*') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="ticket" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Support Tickets') }}</span>
            </a>

            <a href="{{ route('admin.invoices') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.invoices') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Invoices') }}</span>
            </a>

            <a href="{{ route('admin.quotations') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.quotations') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Quotations') }}</span>
            </a>

            <a href="{{ route('admin.todos') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.todos') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="check-square" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Staff Tasks') }}</span>
            </a>

            <div class="pt-6 pb-2">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4">{{ __('Licensing') }}</p>
            </div>

            <a href="{{ route('admin.licensed-products') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.licensed-products') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Licensed Products') }}</span>
            </a>

            <a href="{{ route('admin.subscribers') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.subscribers') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Subscribers') }}</span>
            </a>

            <div class="pt-6 pb-2">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4">{{ __('System') }}</p>
            </div>

            <a href="{{ route('admin.leads') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.leads') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="message-square" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Messages') }}</span>
            </a>

            <a href="{{ route('admin.portfolio') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.portfolio') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="layers" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Portfolio') }}</span>
            </a>

            <a href="{{ route('admin.contracts') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.contracts*') || request()->routeIs('admin.contract_templates*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                <i data-lucide="file-signature" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Contracts') }}</span>
            </a>

            <a href="{{ route('admin.project_types') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.project_types') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                <i data-lucide="tag" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Project Types') }}</span>
            </a>

            <a href="{{ route('admin.visitors') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.visitors') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                <i data-lucide="footprints" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Visitor Log') }}</span>
            </a>

            <a href="{{ route('admin.settings') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.settings') ? 'text-white bg-blue-600 shadow-md shadow-blue-500/20' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-all duration-200">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('Settings') }}</span>
            </a>

            <a href="{{ route('admin.profile') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.profile') ? 'text-white bg-blue-600' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }} rounded-lg transition-colors border-t border-gray-100 dark:border-gray-800 pt-5 mt-5">
                <i data-lucide="user-circle" class="w-5 h-5"></i>
                <span class="font-medium">{{ __('My Profile') }}</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3 p-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Manager') }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Header -->
        <header
            class="h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-8 flex-shrink-0 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">{{ $title ?? __('Home') }}</h2>
            </div>

            <div class="flex items-center gap-4">
                @if($darkSupported && $showToggle)
                    <button @click="toggleTheme()"
                        class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                        <i x-show="!darkMode" data-lucide="moon" class="w-5 h-5"></i>
                        <i x-show="darkMode" data-lucide="sun" class="w-5 h-5"></i>
                    </button>
                @endif
                <livewire:common.notifications />
                <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg transition-colors">
                    <a href="{{ route('lang', ['locale' => 'ar', 'scope' => 'admin']) }}"
                        class="px-3 py-1 text-xs font-bold rounded {{ app()->getLocale() == 'ar' ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">عربي</a>
                    <a href="{{ route('lang', ['locale' => 'en', 'scope' => 'admin']) }}"
                        class="px-3 py-1 text-xs font-bold rounded {{ app()->getLocale() == 'en' ? 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">EN</a>
                </div>
                <div class="h-8 w-px bg-gray-200 dark:bg-gray-700"></div>
                <a href="/" target="_blank"
                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                    <span>{{ __('View Site') }}</span>
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <section class="flex-1 p-8 overflow-y-auto">
            {{ $slot }}
        </section>
    </main>

    @livewireScripts

    <!-- Notifications -->
    <div x-data="{ 
            show: false, 
            message: '', 
            type: 'success' 
         }" @notify.window="
            message = $event.detail[0].message;
            type = $event.detail[0].type;
            show = true;
            setTimeout(() => show = false, 3000);
         " x-show="show" x-cloak x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-8 left-8 z-50 max-w-sm w-full bg-white dark:bg-gray-900 shadow-2xl rounded-xl border-t-4 border-blue-600 p-4 pointer-events-auto transition-colors duration-300"
        :class="{ 'border-blue-600': type === 'success', 'border-red-600': type === 'error' }">
        <div class="flex items-start gap-4">
            <template x-if="type === 'success'">
                <div class="flex-shrink-0 text-green-500">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
            </template>
            <template x-if="type === 'error'">
                <div class="flex-shrink-0 text-red-500">
                    <i data-lucide="alert-circle" class="w-6 h-6"></i>
                </div>
            </template>
            <div class="flex-1">
                <p class="text-sm font-bold text-gray-900 dark:text-white" x-text="message"></p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', ({ el, component }) => {
                if (window.initLucide) window.initLucide();
            });
        });
    </script>
</body>

</html>