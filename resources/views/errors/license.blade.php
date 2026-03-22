@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $isRtl = $dir === 'rtl';
    $supportContact = $support_info['whatsapp'] ?? $support_info['phone'] ?? '';
    if ($supportContact && !str_starts_with($supportContact, 'http')) {
        $supportContact = "https://wa.me/" . preg_replace('/[^0-9]/', '', $supportContact);
    }
    $statusColors = [
        'expired'        => ['bg' => 'from-orange-600 to-red-600',   'badge' => 'bg-orange-500/20 text-orange-300 border-orange-500/30', 'icon' => 'clock'],
        'invalid'        => ['bg' => 'from-red-600 to-rose-700',     'badge' => 'bg-red-500/20 text-red-300 border-red-500/30',         'icon' => 'shield-x'],
        'suspended'      => ['bg' => 'from-yellow-600 to-orange-600','badge' => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30','icon' => 'ban'],
        'not_configured' => ['bg' => 'from-slate-600 to-slate-700',  'badge' => 'bg-slate-500/20 text-slate-300 border-slate-500/30',  'icon' => 'settings'],
        'unreachable'    => ['bg' => 'from-blue-600 to-indigo-700',  'badge' => 'bg-blue-500/20 text-blue-300 border-blue-500/30',     'icon' => 'wifi-off'],
        'error'          => ['bg' => 'from-purple-600 to-indigo-700','badge' => 'bg-purple-500/20 text-purple-300 border-purple-500/30','icon' => 'alert-triangle'],
    ];
    $theme = $statusColors[$status] ?? $statusColors['invalid'];
    $errorCode = strtoupper(substr(md5($status . ($message ?? '')), 0, 8));
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('License Problem') }}</title>
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

        .glow-orb {
            filter: blur(80px);
            animation: float 8s ease-in-out infinite;
        }
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
        .scan-line {
            animation: scan 3s ease-in-out infinite;
        }

        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }
        .blink { animation: blink 1.2s step-end infinite; }

        .status-badge {
            letter-spacing: 0.15em;
        }
    </style>
</head>
<body class="bg-[#020817] bg-grid min-h-screen flex items-center justify-center p-4 overflow-hidden">

    {{-- Ambient Orbs --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="glow-orb absolute -top-32 -{{ $isRtl ? 'right' : 'left' }}-32 w-[500px] h-[500px] bg-red-600/20 rounded-full"></div>
        <div class="glow-orb glow-orb-2 absolute -bottom-32 -{{ $isRtl ? 'left' : 'right' }}-32 w-[500px] h-[500px] bg-indigo-600/15 rounded-full"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-slate-900/50 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-lg">

        {{-- Top Label --}}
        <div class="flex items-center justify-center gap-2 mb-6">
            <div class="h-px flex-1 bg-gradient-to-{{ $isRtl ? 'l' : 'r' }} from-transparent to-red-500/40"></div>
            <span class="text-[10px] font-bold tracking-[0.3em] text-red-400/70 uppercase px-3">
                {{ __('System Alert') }}
            </span>
            <div class="h-px flex-1 bg-gradient-to-{{ $isRtl ? 'r' : 'l' }} from-transparent to-red-500/40"></div>
        </div>

        {{-- Main Card --}}
        <div class="glass-card rounded-3xl overflow-hidden shadow-2xl shadow-black/50">

            {{-- Gradient Header --}}
            <div class="relative bg-gradient-to-br {{ $theme['bg'] }} p-8 text-center overflow-hidden">
                {{-- Scan line effect --}}
                <div class="scan-line absolute inset-x-0 h-12 bg-gradient-to-b from-transparent via-white/5 to-transparent pointer-events-none"></div>

                {{-- Icon --}}
                <div class="relative inline-flex items-center justify-center mb-5">
                    <div class="pulse-ring relative w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center text-white/80">
                        <i data-lucide="{{ $theme['icon'] }}" class="w-12 h-12 relative z-10"></i>
                    </div>
                </div>

                <h1 class="text-2xl font-black text-white tracking-tight mb-2">
                    {{ __('License Problem') }}
                </h1>
                <p class="text-white/60 text-sm">{{ config('app.name', 'Business Suite') }}</p>
            </div>

            {{-- Body --}}
            <div class="p-7 space-y-5">

                {{-- Status Badge --}}
                <div class="flex items-center justify-between bg-slate-800/50 rounded-2xl p-4 border border-slate-700/50">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-red-500 shadow-lg shadow-red-500/50 blink"></div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest">
                            {{ __('License Status') }}
                        </span>
                    </div>
                    <span class="status-badge text-xs font-black uppercase px-3 py-1.5 rounded-lg border {{ $theme['badge'] }}">
                        {{ $status }}
                    </span>
                </div>

                {{-- Message --}}
                <div class="bg-slate-800/30 rounded-2xl p-5 border border-slate-700/30">
                    <p class="text-slate-300 text-sm leading-relaxed text-center">
                        {{ __($message) }}
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="grid gap-3 {{ $supportContact ? 'grid-cols-2' : 'grid-cols-1' }}">
                    @if($supportContact)
                    <a href="{{ $supportContact }}" target="_blank"
                       class="group flex items-center justify-center gap-2.5 bg-green-500 hover:bg-green-400 text-white text-sm font-bold py-3.5 px-5 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-green-500/25 hover:-translate-y-0.5">
                        <i data-lucide="message-circle" class="w-4 h-4 transition-transform group-hover:scale-110"></i>
                        {{ __('WhatsApp') }}
                    </a>
                    @endif
                    <a href="mailto:{{ $support_info['email'] ?? '' }}"
                       class="group flex items-center justify-center gap-2.5 bg-slate-700 hover:bg-slate-600 text-white text-sm font-bold py-3.5 px-5 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-slate-500/20 hover:-translate-y-0.5">
                        <i data-lucide="mail" class="w-4 h-4 transition-transform group-hover:scale-110"></i>
                        {{ __('Email Support') }}
                    </a>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between pt-2 border-t border-slate-800">
                    <a href="/" class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-300 transition-colors font-medium">
                        <i data-lucide="arrow-{{ $isRtl ? 'right' : 'left' }}" class="w-3.5 h-3.5"></i>
                        {{ __('Back to Home') }}
                    </a>
                    <span class="font-mono text-[10px] text-slate-600 tracking-widest select-all">
                        ERR:0x{{ $errorCode }}
                    </span>
                </div>

            </div>
        </div>

        {{-- Bottom hint --}}
        <p class="text-center mt-5 text-slate-600 text-[11px] tracking-wide">
            {{ __('Contact your system administrator if this issue persists.') }}
        </p>

    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
