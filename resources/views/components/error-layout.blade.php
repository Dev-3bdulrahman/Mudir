@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $isRtl = $dir === 'rtl';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('Error') }} — {{ config('app.name', 'Business Suite') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&family=Inter:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: {{ $isRtl ? "'Tajawal'" : "'Inter'" }}, sans-serif; }

        .bg-grid {
            background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .glow-orb { filter: blur(80px); animation: float 8s ease-in-out infinite; }
        .glow-orb-2 { animation-delay: -4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-20px) scale(1.05); }
        }

        @keyframes pulse-ring {
            0%   { transform: scale(1);   opacity: .6; }
            100% { transform: scale(1.8); opacity: 0; }
        }
        .pulse-ring::before, .pulse-ring::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            border: 2px solid currentColor;
            animation: pulse-ring 2s ease-out infinite;
        }
        .pulse-ring::after { animation-delay: 1s; }

        @keyframes scan {
            0%   { transform: translateY(-100%); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(400%); opacity: 0; }
        }
        .scan-line { animation: scan 3s ease-in-out infinite; }

        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }
        .blink { animation: blink 1.2s step-end infinite; }
    </style>
</head>
<body class="bg-[#020817] bg-grid min-h-screen flex items-center justify-center p-4 overflow-hidden">

    {{-- Ambient Orbs --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="glow-orb absolute -top-32 -{{ $isRtl ? 'right' : 'left' }}-32 w-[500px] h-[500px] rounded-full {{ $orb1Color ?? 'bg-red-600/20' }}"></div>
        <div class="glow-orb glow-orb-2 absolute -bottom-32 -{{ $isRtl ? 'left' : 'right' }}-32 w-[500px] h-[500px] rounded-full {{ $orb2Color ?? 'bg-indigo-600/15' }}"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-slate-900/50 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-lg">

        {{-- Top Label --}}
        <div class="flex items-center justify-center gap-2 mb-6">
            <div class="h-px flex-1 bg-gradient-to-{{ $isRtl ? 'l' : 'r' }} from-transparent {{ $lineColor ?? 'to-red-500/40' }}"></div>
            <span class="text-[10px] font-bold tracking-[0.3em] {{ $labelColor ?? 'text-red-400/70' }} uppercase px-3">
                {{ $label ?? __('System Alert') }}
            </span>
            <div class="h-px flex-1 bg-gradient-to-{{ $isRtl ? 'r' : 'l' }} from-transparent {{ $lineColor ?? 'to-red-500/40' }}"></div>
        </div>

        {{-- Main Card --}}
        <div class="glass-card rounded-3xl overflow-hidden shadow-2xl shadow-black/50">

            {{-- Gradient Header --}}
            <div class="relative bg-gradient-to-br {{ $headerGradient ?? 'from-red-600 to-rose-700' }} p-8 text-center overflow-hidden">
                <div class="scan-line absolute inset-x-0 h-12 bg-gradient-to-b from-transparent via-white/5 to-transparent pointer-events-none"></div>

                {{-- Code Number --}}
                <div class="absolute top-4 {{ $isRtl ? 'left' : 'right' }}-5 font-mono text-white/10 font-black text-6xl leading-none select-none">
                    {{ $code ?? '' }}
                </div>

                {{-- Icon --}}
                <div class="relative inline-flex items-center justify-center mb-5">
                    <div class="pulse-ring relative w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center text-white/80">
                        <i data-lucide="{{ $icon ?? 'alert-triangle' }}" class="w-12 h-12 relative z-10"></i>
                    </div>
                </div>

                <h1 class="text-2xl font-black text-white tracking-tight mb-1">{{ $title ?? __('Error') }}</h1>
                <p class="text-white/50 text-sm font-mono">{{ config('app.name', 'Business Suite') }}</p>
            </div>

            {{-- Body --}}
            <div class="p-7 space-y-5">

                {{-- Status Row --}}
                <div class="flex items-center justify-between bg-slate-800/50 rounded-2xl p-4 border border-slate-700/50">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full {{ $dotColor ?? 'bg-red-500 shadow-red-500/50' }} shadow-lg blink"></div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest">
                            {{ __('Error Code') }}
                        </span>
                    </div>
                    <span class="font-mono text-xs font-black uppercase px-3 py-1.5 rounded-lg border {{ $badgeClass ?? 'bg-red-500/20 text-red-300 border-red-500/30' }}">
                        HTTP {{ $code ?? '000' }}
                    </span>
                </div>

                {{-- Message --}}
                <div class="bg-slate-800/30 rounded-2xl p-5 border border-slate-700/30">
                    <p class="text-slate-300 text-sm leading-relaxed text-center">
                        {{ $slot }}
                    </p>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between pt-2 border-t border-slate-800">
                    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/' }}"
                       class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-300 transition-colors font-medium">
                        <i data-lucide="arrow-{{ $isRtl ? 'right' : 'left' }}" class="w-3.5 h-3.5"></i>
                        {{ __('Go Back') }}
                    </a>
                    <a href="/"
                       class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-300 transition-colors font-medium">
                        <i data-lucide="home" class="w-3.5 h-3.5"></i>
                        {{ __('Home') }}
                    </a>
                </div>

            </div>
        </div>

        <p class="text-center mt-5 font-mono text-[10px] text-slate-700 tracking-widest select-all">
            ERR:0x{{ strtoupper(substr(md5(($code ?? '0') . request()->url()), 0, 8)) }}
        </p>

    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
