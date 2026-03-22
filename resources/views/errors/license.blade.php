@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $supportContact = $support_info['whatsapp'] ?? $support_info['phone'] ?? '';
    if ($supportContact && !str_starts_with($supportContact, 'http')) {
        $supportContact = "https://wa.me/" . preg_replace('/[^0-9]/', '', $supportContact);
    }
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('License Problem') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .dark .glass { background: rgba(15, 23, 42, 0.8); }
    </style>
</head>
<body class="bg-[#f8fafc] dark:bg-[#0f172a] flex items-center justify-center min-h-screen p-6 transition-colors duration-500">
    <div class="max-w-2xl w-full relative group">
        <!-- Background Decorations -->
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-red-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-700"></div>

        <div class="glass border border-white/20 dark:border-slate-800 rounded-[2.5rem] shadow-2xl overflow-hidden relative z-10 transition-all duration-500 hover:shadow-red-500/5">
            <div class="p-12 text-center">
                <!-- Icon Header -->
                <div class="relative inline-block mb-10">
                    <div class="w-32 h-32 bg-red-50 dark:bg-red-900/20 rounded-3xl flex items-center justify-center mx-auto transition-transform duration-500 hover:scale-110">
                        <i data-lucide="shield-alert" class="w-16 h-16 text-red-600 dark:text-red-400"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-white dark:bg-slate-900 rounded-full flex items-center justify-center shadow-lg">
                        <div class="w-4 h-4 bg-red-500 rounded-full animate-ping"></div>
                    </div>
                </div>

                <!-- Content -->
                <h1 class="text-4xl font-black text-slate-800 dark:text-white mb-6 tracking-tight leading-tight">
                    {{ __('License Problem') }}
                </h1>
                
                <div class="bg-slate-100/50 dark:bg-slate-800/50 rounded-2xl p-6 mb-8 border border-slate-200/50 dark:border-slate-700/50">
                    <p class="text-[10px] uppercase font-black tracking-[0.2em] text-slate-400 dark:text-slate-500 mb-2">
                        {{ __('License Status') }}
                    </p>
                    <span class="text-lg font-bold text-red-600 dark:text-red-400 uppercase tracking-widest bg-red-50 dark:bg-red-900/20 px-4 py-1 rounded-full">
                        {{ $status }}
                    </span>
                    <p class="text-slate-600 dark:text-slate-400 text-lg mt-6 leading-relaxed max-w-md mx-auto">
                        {{ __($message) }}
                    </p>
                </div>

                <!-- Support Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
                    @if($supportContact)
                        <a href="{{ $supportContact }}" target="_blank" class="flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 text-white py-4 px-6 rounded-2xl font-bold transition-all shadow-lg hover:-translate-y-1">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            {{ __('WhatsApp Support') }}
                        </a>
                    @endif
                    <a href="mailto:{{ $support_info['email'] ?? '' }}" class="flex items-center justify-center gap-3 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white py-4 px-6 rounded-2xl font-bold transition-all shadow-lg hover:-translate-y-1">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                        {{ __('Technical Support') }}
                    </a>
                </div>

                <div class="border-t border-slate-100 dark:border-slate-800 pt-8 flex items-center justify-center gap-6">
                    <a href="/" class="text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 font-bold transition-colors flex items-center gap-2">
                        <i data-lucide="arrow-{{ $dir === 'rtl' ? 'right' : 'left' }}" class="w-4 h-4"></i>
                        {{ __('Back to Home') }}
                    </a>
                </div>
            </div>
        </div>

        <p class="text-center mt-8 text-slate-400 text-xs font-medium tracking-widest">
            ERROR_CODE: 0x{{ strtoupper(substr(md5($status), 0, 8)) }}
        </p>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
