<div>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $cards = [
                ['key' => 'services', 'label' => __('Total Services'), 'icon' => 'briefcase', 'color' => 'blue'],
                ['key' => 'products', 'label' => __('Total Products'), 'icon' => 'package', 'color' => 'purple'],
                ['key' => 'portfolio', 'label' => __('Portfolio Items'), 'icon' => 'layers', 'color' => 'orange'],
                ['key' => 'clients', 'label' => __('Total Clients'), 'icon' => 'users', 'color' => 'pink'],
                ['key' => 'projects', 'label' => __('Active Projects'), 'icon' => 'folder-kanban', 'color' => 'indigo'],
                ['key' => 'contracts', 'label' => __('Contracts'), 'icon' => 'file-signature', 'color' => 'emerald'],
                ['key' => 'invoices', 'label' => __('Invoices'), 'icon' => 'credit-card', 'color' => 'amber'],
                ['key' => 'tickets', 'label' => __('Support Tickets'), 'icon' => 'ticket', 'color' => 'red'],
            ];
        @endphp

        @foreach($cards as $card)
            <div
                class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-{{ $card['color'] }}-50 dark:bg-{{ $card['color'] }}-900/20 flex items-center justify-center text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400 group-hover:scale-110 transition-transform">
                        <i data-lucide="{{ $card['icon'] }}" class="w-6 h-6"></i>
                    </div>
                    @if(($stats[$card['key']]['trend'] ?? 0) != 0)
                        <span
                            class="text-xs font-bold px-2 py-1 rounded-full {{ $stats[$card['key']]['trend'] > 0 ? 'text-green-600 bg-green-50 dark:bg-green-900/20' : 'text-red-600 bg-red-50 dark:bg-red-900/20' }}">
                            {{ $stats[$card['key']]['trend'] > 0 ? '+' : '' }}{{ $stats[$card['key']]['trend'] }}%
                        </span>
                    @endif
                </div>
                <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ $card['label'] }}</h3>
                <p class="text-3xl font-black text-gray-900 dark:text-white mt-1">
                    {{ number_format($stats[$card['key']]['count'] ?? 0) }}
                </p>
            </div>
        @endforeach
    </div>

    <!-- Recent Activity / Content -->
    <div class="mt-8 grid lg:grid-cols-3 gap-8">
        <div
            class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8 transition-colors">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="zap" class="w-6 h-6 text-yellow-500"></i>
                    {{ __('Recent System Activity') }}
                </h3>
                <button wire:click="toggleAllActivity"
                    class="text-sm text-blue-600 hover:underline font-bold">{{ __('View All History') }}</button>
            </div>

            <div class="space-y-6">
                @forelse($recentActivity as $activity)
                    <div
                        class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-transparent hover:border-gray-200 dark:hover:border-gray-700 transition-all group">
                        <div
                            class="mt-1 w-10 h-10 rounded-xl bg-white dark:bg-gray-900 shadow-sm flex items-center justify-center flex-shrink-0">
                            @php
                                $icons = [
                                    'Project' => 'folder-kanban',
                                    'Contract' => 'file-signature',
                                    'Ticket' => 'ticket',
                                    'Invoice' => 'credit-card',
                                    'Client' => 'user-plus',
                                ];
                                $icon = $icons[$activity['type']] ?? 'activity';
                            @endphp
                            <i data-lucide="{{ $icon }}"
                                class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $activity['title'] }}</p>
                                <span
                                    class="text-[10px] uppercase font-black tracking-widest text-gray-400">{{ $activity['time_ago'] }}</span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Action performed on') }} {{ $activity['date']->format('Y-m-d H:i') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i data-lucide="inbox" class="w-12 h-12 text-gray-200 dark:text-gray-800 mx-auto mb-4"></i>
                        <p class="text-gray-500">{{ __('No recent activity found.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- All Activity Modal --}}
        @if($showAllActivity)
            <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-data
                x-on:click.self="$wire.toggleAllActivity()">
                <div
                    class="bg-white dark:bg-gray-900 w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-800 animate-in fade-in zoom-in duration-300">
                    <div
                        class="p-6 border-b border-gray-50 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/50">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white flex items-center gap-2">
                            <i data-lucide="history" class="w-6 h-6 text-blue-600"></i>
                            {{ __('Activity History') }}
                        </h3>
                        <button wire:click="toggleAllActivity"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    <div class="p-6 overflow-y-auto max-h-[70vh] custom-scrollbar">
                        <div class="space-y-4">
                            @foreach($allActivities as $activity)
                                <div
                                    class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-2xl transition-colors border border-transparent hover:border-gray-100 dark:hover:border-gray-700">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
                                        @php
                                            $icons = [
                                                'Project' => 'folder-kanban',
                                                'Contract' => 'file-signature',
                                                'Ticket' => 'ticket',
                                                'Invoice' => 'credit-card',
                                                'Client' => 'user-plus',
                                            ];
                                            $icon = $icons[$activity['type']] ?? 'activity';
                                        @endphp
                                        <i data-lucide="{{ $icon }}" class="w-5 h-5 text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $activity['title'] }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $activity['date']->format('Y-m-d H:i') }}
                                            ({{ $activity['time_ago'] }})</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="space-y-8">
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8 transition-colors">
                <h3 class="text-lg font-black text-gray-900 dark:text-white mb-8 flex items-center gap-2">
                    <i data-lucide="signal" class="w-5 h-5 text-green-500"></i>
                    {{ __('Server Health') }}
                </h3>
                <div class="space-y-8">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ __('Application Core') }}</span>
                            <span
                                class="flex items-center gap-1.5 text-[10px] font-black uppercase text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg animate-pulse">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                {{ __('Healthy') }}
                            </span>
                        </div>
                        <div
                            class="w-full h-3 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden transition-colors">
                            <div class="w-[98%] h-full bg-gradient-to-r from-green-500 to-emerald-400"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ __('Database Engine') }}</span>
                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ __('Optimal') }}</span>
                        </div>
                        <div
                            class="w-full h-3 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden transition-colors">
                            <div class="w-[92%] h-full bg-gradient-to-r from-blue-500 to-indigo-400"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ __('Process Speed') }}</span>
                            <span class="text-xs font-bold text-purple-600 dark:text-purple-400">85ms</span>
                        </div>
                        <div
                            class="w-full h-3 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden transition-colors">
                            <div class="w-[88%] h-full bg-gradient-to-r from-purple-500 to-pink-400"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-gray-900 to-blue-900 p-8 rounded-2xl shadow-xl text-white overflow-hidden relative group">
                <i data-lucide="shield-check"
                    class="absolute -right-4 -bottom-4 w-32 h-32 text-white/5 group-hover:scale-110 transition-transform"></i>
                <h4 class="text-xl font-black mb-4 relative z-10">{{ __('Security Advisor') }}</h4>

                @if($auditResults)
                    <div class="space-y-4 mb-6 relative z-10">
                        @foreach($auditResults as $res)
                            <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/10">
                                <div>
                                    <p class="text-xs font-bold">{{ $res['title'] }}</p>
                                    <p class="text-[10px] text-blue-200/60">{{ $res['desc'] }}</p>
                                </div>
                                <div
                                    class="w-2 h-2 rounded-full {{ $res['status'] == 'success' ? 'bg-green-400' : 'bg-amber-400' }} shadow-[0_0_8px_rgba(74,222,128,0.5)]">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-blue-100/80 text-sm leading-relaxed mb-6 relative z-10">
                        {{ __('Your system has been scanned for vulnerabilities. All protocols are active and firewall is shielding incoming connections.') }}
                    </p>
                @endif

                <button wire:click="runAudit" wire:loading.attr="disabled"
                    class="w-full py-3 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-xs font-black uppercase tracking-widest transition-all backdrop-blur-sm relative z-10 flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="runAudit">{{ __('Run Security Audit') }}</span>
                    <span wire:loading wire:target="runAudit" class="flex items-center gap-2">
                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                        {{ __('Scanning...') }}
                    </span>
                </button>
            </div>

            <!-- Visitor Quick Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div
                    class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <i data-lucide="user-round" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-500">{{ __('Visitors Today') }}</span>
                    </div>
                    <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $visitorStats['total_today'] }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                            <i data-lucide="fingerprint" class="w-4 h-4 text-purple-600"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-500">{{ __('Unique Visitors') }}</span>
                    </div>
                    <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $visitorStats['unique_today'] }}</p>
                </div>
            </div>

            <!-- Top Pages -->
            <div
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                <h4 class="text-sm font-black mb-6 flex items-center gap-2">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-blue-600"></i>
                    {{ __('Top Visited Pages') }}
                </h4>
                <div class="space-y-4">
                    @foreach($visitorStats['top_pages'] as $page)
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span
                                    class="text-gray-600 dark:text-gray-400 truncate max-w-[150px]">{{ str_replace(url('/'), '', $page->url) ?: '/' }}</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $page->count }}
                                    {{ __('Visits') }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-600 rounded-full"
                                    style="width: {{ min(100, ($page->count / max(1, $visitorStats['total_today'])) * 100) }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
```