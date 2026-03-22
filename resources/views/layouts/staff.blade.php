@inject('settingsService', 'App\Services\SettingsManagementService')
@php
  $siteSettings = $settingsService->getSettings();
  $darkSupported = $siteSettings['dark_mode_supported'] ?? true;
  $defaultTheme = $siteSettings['default_theme'] ?? 'light';
  $showToggle = $siteSettings['show_theme_toggle'] ?? true;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
  x-data="{ 
    darkMode: localStorage.getItem('staff_theme') === 'dark' || (!localStorage.getItem('staff_theme') && '{{ $defaultTheme }}' === 'dark') || (!localStorage.getItem('staff_theme') && '{{ $defaultTheme }}' === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('staff_theme', this.darkMode ? 'dark' : 'light');
        if (typeof applyTheme === 'function') applyTheme();
    }
}" :class="{ 'dark': darkMode }">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . ($siteSettings['favicon'] ?? 'favicon.ico')) }}">
  <title>{{ $title ?? __('Staff Panel') }} - عبدالرحمن محسن</title>

  <!-- Scripts & Styles -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

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
      const theme = localStorage.getItem('staff_theme');
      const defaultTheme = '{{ $defaultTheme }}';
      const isDark = theme === 'dark' || (!theme && defaultTheme === 'dark') || (!theme && defaultTheme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);

      if (isDark) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }

    applyTheme();
    document.addEventListener('livewire:navigated', applyTheme);
  </script>

  @livewireStyles
</head>

<body class="bg-gray-50 dark:bg-gray-950 flex h-screen overflow-hidden transition-colors duration-300">
  <!-- Sidebar -->
  <aside
    class="w-64 bg-white dark:bg-gray-900 border-l border-gray-200 dark:border-gray-800 flex-shrink-0 flex flex-col transition-colors duration-300">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
      <div
        class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold">
        ST
      </div>
      <span class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Staff Panel') }}</span>
    </div>

    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
      <a href="{{ route('staff.dashboard') }}" wire:navigate
        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('staff.dashboard') ? 'text-white bg-indigo-600' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800' }} rounded-lg transition-colors">
        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
        <span class="font-medium">{{ __('Dashboard') }}</span>
      </a>

      <a href="{{ route('staff.projects') }}" wire:navigate
        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('staff.projects*') ? 'text-white bg-indigo-600' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800' }} rounded-lg transition-colors">
        <i data-lucide="briefcase" class="w-5 h-5"></i>
        <span class="font-medium">{{ __('My Projects') }}</span>
      </a>

      <a href="{{ route('staff.tickets') }}" wire:navigate
        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('staff.tickets*') ? 'text-white bg-indigo-600' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800' }} rounded-lg transition-colors">
        <i data-lucide="ticket" class="w-5 h-5"></i>
        <span class="font-medium">{{ __('Tickets') }}</span>
      </a>

      <a href="{{ route('staff.todos') }}" wire:navigate
        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('staff.todos*') ? 'text-white bg-indigo-600' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800' }} rounded-lg transition-colors">
        <i data-lucide="check-square" class="w-5 h-5"></i>
        <span class="font-medium">{{ __('Todo List') }}</span>
      </a>

      <a href="{{ route('staff.profile') }}" wire:navigate
        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('staff.profile') ? 'text-white bg-indigo-600' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800' }} rounded-lg transition-colors">
        <i data-lucide="user-circle" class="w-5 h-5"></i>
        <span class="font-medium">{{ __('My Profile') }}</span>
      </a>
    </nav>

    <div class="p-4 border-t border-gray-100 dark:border-gray-800">
      <div class="flex items-center gap-3 p-2">
        <div
          class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase">
          {{ substr(auth()->user()->name, 0, 2) }}
        </div>
        <div class="flex-1">
          <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
          <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Employee') }}</p>
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
            class="px-3 py-1 text-xs font-bold rounded {{ app()->getLocale() == 'ar' ? 'bg-white dark:bg-gray-700 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">عربي</a>
          <a href="{{ route('lang', ['locale' => 'en', 'scope' => 'admin']) }}"
            class="px-3 py-1 text-xs font-bold rounded {{ app()->getLocale() == 'en' ? 'bg-white dark:bg-gray-700 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">EN</a>
        </div>
      </div>
    </header>

    <!-- Page Content -->
    <section class="flex-1 p-8 overflow-y-auto">
      {{ $slot }}
    </section>
  </main>

  @livewireScripts

  <script>
    document.addEventListener('livewire:navigated', () => {
      lucide.createIcons();
    });
    lucide.createIcons();
  </script>
</body>

</html>