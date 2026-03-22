@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
@endphp
<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100 dark:border-slate-800 transition-all duration-500" dir="{{ $dir }}">
    {{-- Header --}}
    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-10 text-white text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>
        
        <h2 class="text-3xl font-black mb-3 relative z-10">{{ __('System Installation') }}</h2>
        <p class="opacity-90 font-medium relative z-10">{{ __('Setup your environment and activate your license') }}</p>
        
        <div class="flex items-center justify-center gap-3 mt-10 relative z-10">
            @foreach([1, 2, 3, 4] as $s)
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-sm transition-all duration-500 {{ $step >= $s ? 'bg-white text-indigo-600 scale-110 shadow-xl' : 'bg-white/20 text-white/50 border border-white/10' }}">
                        {{ $s }}
                    </div>
                </div>
                @if($s < 4)
                    <div class="w-6 h-1 rounded-full {{ $step > $s ? 'bg-white' : 'bg-white/10' }} transition-colors duration-500"></div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Content --}}
    <div class="p-10">
        @if($error_message)
            <div class="mb-8 p-5 bg-red-50 dark:bg-red-900/10 border-s-4 border-red-500 text-red-700 dark:text-red-400 text-sm rounded-2xl flex items-center gap-4 animate-in fade-in slide-in-from-top-4">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span class="font-bold">{{ $error_message }}</span>
            </div>
        @endif

        <div class="min-h-[350px]">
            @if($step === 1)
                {{-- Step 1: Database Setup --}}
                <div class="space-y-8 animate-in fade-in slide-in-from-inline-4">
                    <div class="text-{{ $dir === 'rtl' ? 'right' : 'left' }}">
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-2">{{ __('Database Setup') }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('Configure your local database connection parameters') }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Database Host') }}</label>
                            <input wire:model="db_host" type="text" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-900 focus:border-indigo-500 outline-none transition-all font-mono">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Database Port') }}</label>
                            <input wire:model="db_port" type="text" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-900 focus:border-indigo-500 outline-none transition-all font-mono">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Database Name') }}</label>
                            <input wire:model="db_database" type="text" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-900 focus:border-indigo-500 outline-none transition-all font-mono">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Database Username') }}</label>
                            <input wire:model="db_username" type="text" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-900 focus:border-indigo-500 outline-none transition-all font-mono">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Database Password') }}</label>
                            <input wire:model="db_password" type="password" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-900 focus:border-indigo-500 outline-none transition-all font-mono">
                        </div>
                    </div>

                    <button wire:click="testDatabaseConnection" wire:loading.attr="disabled" class="w-full py-4 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 hover:border-indigo-500 hover:text-indigo-600 text-slate-400 font-bold transition-all flex items-center justify-center gap-3">
                        <i data-lucide="{{ $db_connection_status === 'success' ? 'check-circle' : 'database' }}" class="w-5 h-5"></i>
                        {{ $db_connection_status === 'success' ? __('Connected Successfully') : __('Test Connection') }}
                    </button>
                </div>

            @elseif($step === 2)
                {{-- Step 2: Requirements --}}
                <div class="space-y-8 animate-in fade-in slide-in-from-inline-4">
                    <div class="text-{{ $dir === 'rtl' ? 'right' : 'left' }}">
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-2">{{ __('System Requirements') }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('Verifying your server environment') }}</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-6 bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 flex items-center justify-center text-indigo-600 shadow-sm">
                                    <i data-lucide="code-2" class="w-6 h-6"></i>
                                </div>
                                <div class="text-{{ $dir === 'rtl' ? 'right' : 'left' }}">
                                    <p class="font-black text-slate-700 dark:text-white uppercase text-[10px] tracking-widest">{{ __('PHP Version') }}</p>
                                    <p class="text-sm font-bold text-slate-400">{{ __('Required') }}: 8.2+</p>
                                </div>
                            </div>
                            <span class="px-4 py-2 rounded-xl font-black text-xs {{ phpversion() >= '8.2' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ phpversion() }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-6 bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 flex items-center justify-center text-indigo-600 shadow-sm">
                                    <i data-lucide="folder-open" class="w-6 h-6"></i>
                                </div>
                                <div class="text-{{ $dir === 'rtl' ? 'right' : 'left' }}">
                                    <p class="font-black text-slate-700 dark:text-white uppercase text-[10px] tracking-widest">{{ __('Storage Writable') }}</p>
                                    <p class="text-sm font-bold text-slate-400">{{ __('Required for caching') }}</p>
                                </div>
                            </div>
                            <i data-lucide="{{ is_writable(storage_path('app')) ? 'check-circle-2' : 'x-circle' }}" class="w-6 h-6 {{ is_writable(storage_path('app')) ? 'text-green-500' : 'text-red-500' }}"></i>
                        </div>
                    </div>
                </div>

            @elseif($step === 3)
                {{-- Step 3: Product & Identity --}}
                <div class="space-y-8 animate-in fade-in slide-in-from-inline-4 text-{{ $dir === 'rtl' ? 'right' : 'left' }}">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-2">{{ __('Identity') }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('Who is activating this license?') }}</p>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Select Product') }}</label>
                            <select wire:model="selected_product_id" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-900 focus:border-indigo-500 outline-none transition-all">
                                <option value="">-- {{ __('Select Product') }} --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product['id'] }}">
                                        {{ is_array($product['name']) ? ($product['name'][app()->getLocale()] ?? array_shift($product['name'])) : $product['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Full Name') }}</label>
                                <input wire:model="name" type="text" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-900 focus:border-indigo-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Email Address') }}</label>
                                <input wire:model="email" type="email" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-900 focus:border-indigo-500 outline-none transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Domain') }}</label>
                            <input wire:model="domain" type="text" readonly class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-50 dark:text-slate-400 outline-none font-mono">
                        </div>
                    </div>
                </div>

            @elseif($step === 4)
                {{-- Step 4: License Activation --}}
                <div class="space-y-8 animate-in fade-in slide-in-from-inline-4 text-{{ $dir === 'rtl' ? 'right' : 'left' }}">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-2">{{ __('License Activation') }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('Authenticate with the parent server') }}</p>
                    </div>

                    <div class="bg-indigo-50 dark:bg-indigo-900/10 p-4 rounded-2xl flex items-center gap-4 mb-6">
                        <button wire:click="$set('auth_mode', 'register')" class="flex-1 py-3 rounded-xl font-bold transition-all {{ $auth_mode === 'register' ? 'bg-white dark:bg-slate-800 text-indigo-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                            {{ __('New License') }}
                        </button>
                        <button wire:click="$set('auth_mode', 'login')" class="flex-1 py-3 rounded-xl font-bold transition-all {{ $auth_mode === 'login' ? 'bg-white dark:bg-slate-800 text-indigo-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                            {{ __('Existing License') }}
                        </button>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400">{{ __('Activation Password') }}</label>
                        <input wire:model="password" type="password" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-900 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>

            @elseif($step === 5)
                {{-- Step 5: Success --}}
                <div class="text-center py-10 animate-in zoom-in duration-500">
                    <div class="w-32 h-32 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 shadow-xl shadow-green-500/5 transition-transform hover:scale-110">
                        <i data-lucide="party-popper" class="w-16 h-16"></i>
                    </div>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-4">{{ __('Installation Successful!') }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-lg mb-12 max-w-md mx-auto">{{ __('System is ready and license is active. You can now access the dashboard.') }}</p>
                    <a href="/admin" class="inline-flex items-center gap-3 bg-indigo-600 text-white px-16 py-5 rounded-[2rem] font-bold hover:bg-indigo-700 transition-all shadow-2xl shadow-indigo-500/20 active:scale-95">
                        {{ __('Go to Dashboard') }}
                        <i data-lucide="arrow-{{ $dir === 'rtl' ? 'left' : 'right' }}" class="w-5 h-5"></i>
                    </a>
                </div>
            @endif
        </div>

        @if($step < 5)
            <div class="mt-12 flex items-center justify-between border-t border-slate-50 dark:border-slate-800 pt-10">
                <div>
                    @if($step > 1)
                        <button wire:click="prevStep" class="text-slate-400 hover:text-slate-600 font-bold px-6 py-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            <i data-lucide="arrow-{{ $dir === 'rtl' ? 'right' : 'left' }}" class="w-5 h-5"></i>
                            {{ __('Previous Step') }}
                        </button>
                    @endif
                </div>

                <button wire:click="nextStep" wire:loading.attr="disabled" class="bg-indigo-600 text-white px-12 py-4 rounded-[1.5rem] font-black uppercase tracking-widest text-xs hover:bg-indigo-700 transition-all flex items-center gap-3 shadow-xl shadow-indigo-500/10 active:scale-95 disabled:opacity-50">
                    <span wire:loading.remove>{{ $step === 4 ? __('Complete Activation') : __('Next Step') }}</span>
                    <span wire:loading class="flex items-center gap-2">
                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                        {{ __('Processing...') }}
                    </span>
                    <i data-lucide="arrow-{{ $dir === 'rtl' ? 'left' : 'right' }}" class="w-4 h-4" wire:loading.remove></i>
                </button>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            lucide.createIcons();
        });
        document.addEventListener('livewire:navigated', () => {
            lucide.createIcons();
        });
        window.addEventListener('step-changed', () => {
            lucide.createIcons();
        });
    </script>
</div>

