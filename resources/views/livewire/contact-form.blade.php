<div class="max-w-2xl mx-auto">
    @if($success)
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
            <i data-lucide="check-circle" class="w-6 h-6"></i>
            <span>{{ __('Your message has been sent successfully!') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800">
        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">{{ __('Send us a message') }}</h3>
        
        <form wire:submit.prevent="submit" class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Name') }} <span class="text-red-500">*</span></label>
                <input type="text" wire:model="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Email') }} <span class="text-red-500">*</span></label>
                <input type="email" wire:model="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Phone') }}</label>
                <input type="text" wire:model="phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Subject') }}</label>
                <input type="text" wire:model="subject" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('subject') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Message') }} <span class="text-red-500">*</span></label>
                <textarea wire:model="message" rows="5" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"></textarea>
                @error('message') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-5 h-5"></i>
                <span>{{ __('Send Message') }}</span>
            </button>
        </form>

        <!-- Contact Info -->
        @if(!empty($contactEmail) || !empty($contactPhone) || !empty($whatsapp))
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4 text-center">{{ __('Or contact us directly') }}</h4>
            <div class="grid gap-3">
                @if($contactEmail)
                <a href="mailto:{{ $contactEmail }}" aria-label="{{ __('Email Us') }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors group border border-transparent dark:border-gray-700">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('Email') }}</p>
                        <p class="font-bold text-gray-800 dark:text-gray-200">{{ $contactEmail }}</p>
                    </div>
                </a>
                @endif

                @if($contactPhone)
                <a href="tel:{{ $contactPhone }}" aria-label="{{ __('Call Us') }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/30 transition-colors group border border-transparent dark:border-gray-700">
                    <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/50 flex items-center justify-center text-green-600 dark:text-green-400 group-hover:bg-green-600 group-hover:text-white transition-colors">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('Phone') }}</p>
                        <p class="font-bold text-gray-800 dark:text-gray-200" dir="ltr">{{ $contactPhone }}</p>
                    </div>
                </a>
                @endif

                @if($whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('Chat on WhatsApp') }}" class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors group border border-transparent dark:border-gray-700">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <i data-lucide="message-circle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('WhatsApp') }}</p>
                        <p class="font-bold text-gray-800 dark:text-gray-200">{{ __('Chat with us') }}</p>
                    </div>
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
