<div x-data="{ activeTab: '{{ $services->count() > 0 ? 'services' : ($products->count() > 0 ? 'products' : ($portfolio->count() > 0 ? 'portfolio' : 'contact')) }}' }" class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-950 pb-20 relative transition-colors duration-300">
    <!-- Language Switcher -->
    <div class="absolute top-6 left-6 z-50">
        @if(app()->getLocale() == 'ar')
            <a href="{{ route('lang', ['locale' => 'en', 'scope' => 'frontend']) }}" aria-label="Switch to English" class="flex items-center gap-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md px-4 py-2 rounded-full shadow-lg border border-gray-100 dark:border-gray-700 hover:scale-105 transition-all font-bold text-gray-700 dark:text-gray-300">
                <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-[10px] dark:text-blue-300">EN</span>
                English
            </a>
        @else
            <a href="{{ route('lang', ['locale' => 'ar', 'scope' => 'frontend']) }}" aria-label="التبديل للعربية" class="flex items-center gap-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md px-4 py-2 rounded-full shadow-lg border border-gray-100 dark:border-gray-700 hover:scale-105 transition-all font-bold text-gray-700 dark:text-gray-300">
                <span class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-[10px] dark:text-green-300">AR</span>
                العربية
            </a>
        @endif
    </div>
    <!-- Hero Section -->
    <div class="flex flex-col items-center justify-center px-4 py-20 relative">
        <div class="text-center space-y-6 max-w-3xl">
            <div class="relative inline-block">
                @if($settings['logo_light'] ?? false)
                    <img src="{{ asset('storage/' . $settings['logo_light']) }}" alt="{{ $settings['site_name']['ar'] ?? 'Logo' }}" width="160" height="160" class="w-40 h-40 rounded-full object-contain shadow-2xl" fetchpriority="high" decoding="async">
                @else
                    <div class="w-40 h-40 rounded-full bg-gradient-to-br from-purple-600 via-blue-600 to-cyan-500 p-1 shadow-2xl animate-pulse mx-auto">
                        <div class="w-full h-full rounded-full bg-white flex items-center justify-center text-5xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                            {{ mb_substr(\App\Models\SiteSetting::getValue('site_name', __('Abdulrahman Mohsen')), 0, 2) }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="space-y-3">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white">
                    {{ \App\Models\SiteSetting::getValue('site_name', 'عبدالرحمن محسن') }}
                </h1>
                @if(!empty($settings['site_description']))
                <p class="text-2xl md:text-3xl bg-gradient-to-r from-purple-600 via-blue-600 to-cyan-500 bg-clip-text text-transparent font-semibold">
                    {{ $settings['site_description'] }}
                </p>
                @endif
            </div>

            <p class="text-lg md:text-xl text-gray-700 dark:text-gray-300 leading-relaxed max-w-2xl mx-auto">
                {{ __('Professional Web and Desktop Applications Developer') }}
                <br />
                {{ __('Expertise in software development and integrated technical solutions') }}
            </p>

            <!-- Navigation Tabs -->
            <div class="flex flex-wrap justify-center gap-3 pt-6">
                @if($services->count() > 0)
                <button @click="activeTab = 'services'" aria-label="{{ __('View Services') }}" :class="activeTab === 'services' ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg scale-110' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:scale-110 border border-transparent dark:border-gray-700'" class="flex items-center gap-2 px-6 py-3 rounded-full font-semibold transition-all duration-300 transform">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                    <span>{{ __('Services') }}</span>
                </button>
                @endif
                @if($products->count() > 0)
                <button @click="activeTab = 'products'" aria-label="{{ __('View Products') }}" :class="activeTab === 'products' ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg scale-110' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:scale-110 border border-transparent dark:border-gray-700'" class="flex items-center gap-2 px-6 py-3 rounded-full font-semibold transition-all duration-300 transform">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span>{{ __('Products') }}</span>
                </button>
                @endif
                @if($portfolio->count() > 0)
                <button @click="activeTab = 'portfolio'" aria-label="{{ __('View Portfolio') }}" :class="activeTab === 'portfolio' ? 'bg-gradient-to-r from-orange-500 to-red-600 text-white shadow-lg scale-110' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:scale-110 border border-transparent dark:border-gray-700'" class="flex items-center gap-2 px-6 py-3 rounded-full font-semibold transition-all duration-300 transform">
                    <i data-lucide="folder-open" class="w-5 h-5"></i>
                    <span>{{ __('Portfolio') }}</span>
                </button>
                @endif
                <button @click="activeTab = 'contact'" aria-label="{{ __('Contact Us') }}" :class="activeTab === 'contact' ? 'bg-gradient-to-r from-pink-500 to-rose-600 text-white shadow-lg scale-110' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:scale-110 border border-transparent dark:border-gray-700'" class="flex items-center gap-2 px-6 py-3 rounded-full font-semibold transition-all duration-300 transform">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                    <span>{{ __('Contact Us') }}</span>
                </button>
                <a href="{{ route('login') }}" aria-label="{{ __('Login to Admin Dashboard') }}" class="flex items-center gap-2 px-6 py-3 rounded-full font-semibold bg-gray-800 text-white shadow-md transition-all duration-300 transform hover:scale-110">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    <span>{{ __('Login') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="py-16 px-4">
        <div class="container mx-auto">
            
            <!-- Services Section -->
            @if($services->count() > 0)
            <div x-show="activeTab === 'services'" class="tab-content">
                <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    @foreach($services as $service)
                    @php
                        $color = $service['color'] ?? 'purple';
                        $locale = app()->getLocale();
                        $title = $service['title'][$locale] ?? $service['title']['ar'] ?? $service['title'] ?? '';
                        $description = $service['description'][$locale] ?? $service['description']['ar'] ?? $service['description'] ?? '';
                    @endphp
                    <div class="bg-gradient-to-br from-{{ $color }}-50 to-white dark:from-{{ $color }}-900/10 dark:to-gray-900 p-6 rounded-lg shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-r-4 border-{{ $color }}-500 dark:border-{{ $color }}-600">
                        <h3 class="text-xl font-bold text-{{ $color }}-700 dark:text-{{ $color }}-400 mb-3">{{ $title }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $description }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Products Section -->
            @if($products->count() > 0)
            <div x-show="activeTab === 'products'" class="tab-content" x-cloak>
                <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    @foreach($products as $product)
                    @php
                        $color = $product['color'] ?? 'green';
                        $locale = app()->getLocale();
                        $title = $product['title'][$locale] ?? $product['title']['ar'] ?? $product['title'] ?? '';
                        $description = $product['description'][$locale] ?? $product['description']['ar'] ?? $product['description'] ?? '';
                    @endphp
                    <div class="bg-gradient-to-br from-{{ $color }}-50 to-white dark:from-{{ $color }}-900/10 dark:to-gray-900 p-6 rounded-lg shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-r-4 border-{{ $color }}-500 dark:border-{{ $color }}-600">
                        <h3 class="text-xl font-bold text-{{ $color }}-700 dark:text-{{ $color }}-400 mb-3">{{ $title }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $description }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Portfolio Section -->
            @if($portfolio->count() > 0)
            <div x-show="activeTab === 'portfolio'" class="tab-content" x-cloak>
                <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    @foreach($portfolio as $item)
                    @php
                        $color = $item['color'] ?? 'orange';
                        $locale = app()->getLocale();
                        $title = $item['title'][$locale] ?? $item['title']['ar'] ?? $item['title'] ?? '';
                        $description = $item['description'][$locale] ?? $item['description']['ar'] ?? $item['description'] ?? '';
                    @endphp
                    <div class="bg-gradient-to-br from-{{ $color }}-50 to-white dark:from-{{ $color }}-900/10 dark:to-gray-900 p-6 rounded-lg shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-r-4 border-{{ $color }}-500 dark:border-{{ $color }}-600">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-{{ $color }}-700 dark:text-{{ $color }}-400">{{ $title }}</h3>
                            <span class="text-xs bg-gradient-to-r from-{{ $color }}-500 to-{{ $color }}-600 text-white px-3 py-1 rounded-full">{{ $item['year'] ?? '' }}</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">{{ $description }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Contact Section -->
            <div x-show="activeTab === 'contact'" class="tab-content" x-cloak>
                @livewire('contact-form')
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center pt-10 text-gray-400 dark:text-gray-600 text-sm">
        <p>© {{ date('Y') }} {{ \App\Models\SiteSetting::getValue('site_name', __('Abdulrahman Mohsen')) }}. {{ __('All Rights Reserved.') }}</p>
    </footer>
</div>
