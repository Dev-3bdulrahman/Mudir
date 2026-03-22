<div x-data="{ activeTab: 'general' }">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Manage Settings') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Customize site identity and SEO') }}</p>
        </div>
        <button wire:click="save"
            class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 flex items-center gap-2">
            <i data-lucide="save" class="w-5 h-5"></i>
            <span>{{ __('Save Changes') }}</span>
        </button>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl mb-8 w-fit transition-colors">
        <button @click="activeTab = 'general'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'general', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'general' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all">{{ __('General Settings') }}</button>
        <button @click="activeTab = 'identity'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'identity', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'identity' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all">{{ __('Site Identity') }}</button>
        <button @click="activeTab = 'seo'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'seo', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'seo' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all">{{ __('SEO Settings') }}</button>
        <button @click="activeTab = 'social'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'social', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'social' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all">{{ __('Social Links') }}</button>
        <button @click="activeTab = 'theme'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'theme', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'theme' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all">{{ __('Theme Settings') }}</button>
        <button @click="activeTab = 'pdf'"
            :class="{ 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm': activeTab === 'pdf', 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200': activeTab !== 'pdf' }"
            class="px-6 py-2 rounded-lg text-sm font-bold transition-all">{{ __('PDF Branding') }}</button>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- General Settings Tab -->
            <div x-show="activeTab === 'general'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    معلومات الموقع الأساسية
                </h3>
                <div class="grid gap-6">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Site Name') }}
                                (العربية)</label>
                            <input type="text" wire:model="site_name_ar" dir="rtl"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                        </div>
                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Site Name') }}
                                (English)</label>
                            <input type="text" wire:model="site_name_en" dir="ltr"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Job Title') }}
                                (العربية)</label>
                            <input type="text" wire:model="job_title_ar" dir="rtl"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                        </div>
                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Job Title') }}
                                (English)</label>
                            <input type="text" wire:model="job_title_en" dir="ltr"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Site Description') }}
                                (العربية)</label>
                            <textarea wire:model="site_description_ar" rows="3" dir="rtl"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"></textarea>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Site Description') }}
                                (English)</label>
                            <textarea wire:model="site_description_en" rows="3" dir="ltr"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"></textarea>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Contact Email') }}</label>
                            <input type="email" wire:model="contact_email"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"
                                placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Contact Phone') }}</label>
                            <input type="text" wire:model="contact_phone"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"
                                placeholder="+966 50 000 0000">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Identity Settings Tab -->
            <div x-show="activeTab === 'identity'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="image" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    هوية الموقع (اللوجو والأيقونات)
                </h3>
                <div class="grid gap-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">{{ __('Logo (Light Mode)') }}</label>
                            <div class="relative group">
                                <div
                                    class="w-full h-32 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden transition-colors">
                                    @if ($logo_light)
                                        <img src="{{ $logo_light->temporaryUrl() }}" class="max-h-24 object-contain">
                                    @elseif ($existing_logo_light)
                                        <img src="{{ asset('storage/' . $existing_logo_light) }}"
                                            class="max-h-24 object-contain">
                                    @else
                                        <div class="text-center">
                                            <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
                                            <span class="text-xs text-gray-400">اضغط للرفع</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" wire:model="logo_light"
                                    class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 mb-4">{{ __('Logo (Dark Mode)') }}</label>
                            <div class="relative group">
                                <div
                                    class="w-full h-32 rounded-xl bg-gray-900 border-2 border-dashed border-gray-700 flex items-center justify-center overflow-hidden">
                                    @if ($logo_dark)
                                        <img src="{{ $logo_dark->temporaryUrl() }}" class="max-h-24 object-contain">
                                    @elseif ($existing_logo_dark)
                                        <img src="{{ asset('storage/' . $existing_logo_dark) }}"
                                            class="max-h-24 object-contain">
                                    @else
                                        <div class="text-center">
                                            <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-600 mx-auto mb-2"></i>
                                            <span class="text-xs text-gray-500">اضغط للرفع</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" wire:model="logo_dark"
                                    class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-4">{{ __('Favicon') }}</label>
                        <div class="flex items-center gap-6">
                            <div
                                class="w-16 h-16 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden transition-colors">
                                @if ($favicon)
                                    <img src="{{ $favicon->temporaryUrl() }}" class="w-10 h-10 object-contain">
                                @elseif ($existing_favicon)
                                    <img src="{{ asset('storage/' . $existing_favicon) }}" class="w-10 h-10 object-contain">
                                @else
                                    <i data-lucide="globe" class="w-8 h-8 text-gray-300 dark:text-gray-600"></i>
                                @endif
                            </div>
                            <div class="relative">
                                <button
                                    class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">تغيير
                                    الأيقونة</button>
                                <input type="file" wire:model="favicon"
                                    class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <span class="text-xs text-gray-400 dark:text-gray-500">يفضل 32x32 أو 64x64 بكسل</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings Tab -->
            <div x-show="activeTab === 'seo'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="search" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    تحسين محركات البحث (SEO)
                </h3>
                <div class="grid gap-8">
                    <div class="grid gap-6">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Title') }}
                                    (العربية)</label>
                                <input type="text" wire:model="seo_title_ar" dir="rtl"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Title') }}
                                    (English)</label>
                                <input type="text" wire:model="seo_title_en" dir="ltr"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Description') }}
                                    (العربية)</label>
                                <textarea wire:model="seo_description_ar" rows="4" dir="rtl"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Description') }}
                                    (English)</label>
                                <textarea wire:model="seo_description_en" rows="4" dir="ltr"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"></textarea>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Keywords') }}
                                    (العربية)</label>
                                <input type="text" wire:model="seo_keywords_ar" dir="rtl"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"
                                    placeholder="برمجة، تطوير، ...">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Meta Keywords') }}
                                    (English)</label>
                                <input type="text" wire:model="seo_keywords_en" dir="ltr"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"
                                    placeholder="programming, development, ...">
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-gray-100 dark:border-gray-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i data-lucide="activity" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                            {{ __('Analytics & Tracking') }}
                        </h3>
                        <div class="grid gap-6">
                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Google Analytics ID') }}</label>
                                    <input type="text" wire:model="google_analytics_id" placeholder="G-XXXXXXXXXX"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Google Tag Manager ID') }}</label>
                                    <input type="text" wire:model="google_tag_manager_id" placeholder="GTM-XXXXXXX"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Facebook Pixel ID') }}</label>
                                    <input type="text" wire:model="facebook_pixel_id" placeholder="1234567890..."
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Header Scripts') }}</label>
                                    <textarea wire:model="custom_header_scripts" rows="4" placeholder="<script>...</script>"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-mono text-xs focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Body Top Scripts') }}</label>
                                    <textarea wire:model="custom_body_scripts" rows="4" placeholder="<noscript>...</noscript>"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-mono text-xs focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Footer Scripts') }}</label>
                                    <textarea wire:model="custom_footer_scripts" rows="4" placeholder="<script>...</script>"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-mono text-xs focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Links Tab -->
            <div x-show="activeTab === 'social'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="share-2" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    روابط التواصل الاجتماعي
                </h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 italic">{{ __('WhatsApp Number') }}</label>
                        <div class="relative">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </span>
                            <input type="text" wire:model="whatsapp"
                                class="w-full pr-12 pl-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all"
                                placeholder="966...">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 italic">Facebook</label>
                        <input type="text" wire:model="facebook"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 italic">Twitter (X)</label>
                        <input type="text" wire:model="twitter"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 italic">Instagram</label>
                        <input type="text" wire:model="instagram"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 italic">LinkedIn</label>
                        <input type="text" wire:model="linkedin"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                    </div>
                </div>
            </div>

            <!-- Theme Settings Tab -->
            <div x-show="activeTab === 'theme'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="palette" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    {{ __('Theme Settings') }}
                </h3>
                <div class="grid gap-8">
                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-xl transition-colors">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ __('Dark Mode Supported') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Enable or disable dark mode for the entire site') }}
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="dark_mode_supported" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>

                    <div x-show="dark_mode_supported" class="space-y-6">
                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-xl transition-colors">
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white">{{ __('Show Theme Toggle') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('Allow users to switch between light and dark mode manually') }}
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="show_theme_toggle" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">{{ __('Default Theme') }}</label>
                            <select wire:model="default_theme"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 dark:focus:ring-blue-900/20 transition-all">
                                <option value="light">{{ __('Light') }}</option>
                                <option value="dark">{{ __('Dark') }}</option>
                                <option value="system">{{ __('System (Auto)') }}</option>
                            </select>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                {{ __('The theme visitors will see on their first visit.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PDF Branding Tab -->
            <div x-show="activeTab === 'pdf'"
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition-colors">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="file-check" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    {{ __('PDF Branding & Layout') }}
                </h3>
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">{{ __('Dedicated PDF Logo') }}</label>
                        <div class="relative group max-w-xs">
                            <div
                                class="w-full h-24 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden transition-colors">
                                @if ($logo_pdf)
                                    <img src="{{ $logo_pdf->temporaryUrl() }}" class="max-h-16 object-contain">
                                @elseif ($existing_logo_pdf)
                                    <img src="{{ asset('storage/' . $existing_logo_pdf) }}" class="max-h-16 object-contain">
                                @else
                                    <div class="text-center">
                                        <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
                                        <span class="text-xs text-gray-400">{{ __('Click to upload') }}</span>
                                    </div>
                                @endif
                            </div>
                            <input type="file" wire:model="logo_pdf" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">{{ __('Leave empty to use Site Identity logos.') }}</p>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">{{ __('Dedicated PDF Watermark Logo') }}</label>
                        <div class="relative group max-w-xs">
                            <div
                                class="w-full h-24 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden transition-colors">
                                @if ($logo_pdf_watermark)
                                    <img src="{{ $logo_pdf_watermark->temporaryUrl() }}" class="max-h-16 object-contain">
                                @elseif ($existing_logo_pdf_watermark)
                                    <img src="{{ asset('storage/' . $existing_logo_pdf_watermark) }}"
                                        class="max-h-16 object-contain">
                                @else
                                    <div class="text-center">
                                        <i data-lucide="upload-cloud" class="w-8 h-8 text-gray-300 mx-auto mb-2"></i>
                                        <span class="text-xs text-gray-400">{{ __('Click to upload') }}</span>
                                    </div>
                                @endif
                            </div>
                            <input type="file" wire:model="logo_pdf_watermark"
                                class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            {{ __('Used as a background watermark if enabled. Falls back to PDF Logo.') }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-xl transition-colors">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ __('Show Background/Watermark') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Show logo as a background watermark in PDF') }}
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="pdf_show_background" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>

                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-xl transition-colors">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ __('Show Company Signature') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Enable signature block for the company by default') }}
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="pdf_show_company_signature" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>

                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-xl transition-colors">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ __('Show Client Signature') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Enable signature block for the client by default') }}
                            </p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="pdf_show_client_signature" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Tips -->
        <div class="space-y-6">
            <div class="bg-blue-600 text-white p-8 rounded-2xl shadow-lg shadow-blue-100">
                <h4 class="font-bold mb-4">{{ __('Technical Tip') }}</h4>
                <p class="text-blue-100 text-sm leading-relaxed">
                    {{ __('Ensure accurate Meta Description for better SEO rankings. Keywords still matter but description is key.') }}
                </p>
            </div>

            <div
                class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm transition-colors relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform">
                </div>
                <h4 class="font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="monitor" class="w-5 h-5 text-blue-600"></i>
                    {{ __('Live Status') }}
                </h4>
                <div class="space-y-4 relative z-10">
                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-transparent hover:border-gray-100 dark:hover:border-gray-700 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="relative flex h-3 w-3">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $is_online ? 'bg-green-400' : 'bg-red-400' }} opacity-75"></span>
                                <span
                                    class="relative inline-flex rounded-full h-3 w-3 {{ $is_online ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            </div>
                            <span
                                class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Site Status') }}</span>
                        </div>
                        <span class="text-xs font-black uppercase {{ $is_online ? 'text-green-600' : 'text-red-600' }}">
                            {{ $is_online ? __('Online') : __('Offline') }}
                        </span>
                    </div>

                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-transparent hover:border-gray-100 dark:hover:border-gray-700 transition-all">
                        <div class="flex items-center gap-3">
                            <i data-lucide="{{ $ssl_active ? 'shield-check' : 'shield-alert' }}"
                                class="w-4 h-4 {{ $ssl_active ? 'text-blue-500' : 'text-amber-500' }}"></i>
                            <span
                                class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('SSL Safety') }}</span>
                        </div>
                        <span
                            class="text-xs font-black uppercase {{ $ssl_active ? 'text-blue-600' : 'text-amber-600' }}">
                            {{ $ssl_active ? __('Active') : __('Inactive') }}
                        </span>
                    </div>

                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-transparent hover:border-gray-100 dark:hover:border-gray-700 transition-all">
                        <div class="flex items-center gap-3">
                            <i data-lucide="refresh-cw" class="w-4 h-4 text-gray-400"></i>
                            <span
                                class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Last Update') }}</span>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            {{ $last_updated_human }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>