<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Manage Portfolio') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage and display your portfolio') }}</p>
        </div>
        <button wire:click="create" class="bg-orange-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-orange-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('Add Portfolio Item') }}</span>
        </button>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($portfolioItems as $item)
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow">
            <div class="h-32 bg-gradient-to-br from-{{ $item['color'] ?? 'orange' }}-400 to-{{ $item['color'] ?? 'orange' }}-600 flex items-center justify-center text-white">
                <i data-lucide="image" class="w-12 h-12 opacity-50"></i>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ is_array($item['title']) ? ($item['title'][app()->getLocale()] ?? array_shift($item['title'])) : $item['title'] }}</h3>
                    <span class="text-xs bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 px-2 py-1 rounded">{{ $item['year'] }}</span>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 line-clamp-2">
                    {{ is_array($item['description']) ? ($item['description'][app()->getLocale()] ?? array_shift($item['description'])) : $item['description'] }}
                </p>
                <div class="flex items-center justify-end gap-2 border-t border-gray-50 dark:border-gray-800 pt-4">
                    <button wire:click="edit({{ $item['id'] }})" class="p-2 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </button>
                    <button wire:click="confirmDelete({{ $item['id'] }})" class="p-2 text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ open: @entangle('showModal') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="open = false"
                 class="absolute inset-0 bg-gray-500/75 transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form wire:submit="save">
                    <div class="bg-white dark:bg-gray-900 px-6 py-6 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ $portfolioId ? __('Edit Work') : __('Add Portfolio Item') }}
                            </h3>
                            <button @click="open = false" type="button" class="text-gray-400 hover:text-gray-500">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 px-6 py-6 space-y-4 text-right">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="pf-title_ar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Work title') }} (العربية)</label>
                                <input wire:model="title_ar" type="text" id="pf-title_ar" dir="rtl"
                                       class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all outline-none">
                                @error('title_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="pf-title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Work title') }} (English)</label>
                                <input wire:model="title_en" type="text" id="pf-title_en" dir="ltr"
                                       class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all outline-none">
                                @error('title_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="pf-year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Year') }}</label>
                                <input wire:model="year" type="text" id="pf-year" 
                                       class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all outline-none">
                                @error('year') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Icon Color') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(['orange', 'blue', 'purple', 'cyan', 'indigo', 'green', 'red'] as $c)
                                    <label class="relative cursor-pointer">
                                        <input wire:model="color" type="radio" name="color" value="{{ $c }}" class="sr-only peer">
                                        <div class="w-6 h-6 rounded-full bg-{{ $c }}-500 border-2 border-transparent peer-checked:border-white peer-checked:ring-2 peer-checked:ring-{{ $c }}-500 transition-all"></div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="pf-description_ar" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Work Description') }} (العربية)</label>
                                <textarea wire:model="description_ar" id="pf-description_ar" rows="4" dir="rtl"
                                          class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all outline-none"></textarea>
                                @error('description_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="pf-description_en" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Work Description') }} (English)</label>
                                <textarea wire:model="description_en" id="pf-description_en" rows="4" dir="ltr"
                                          class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all outline-none"></textarea>
                                @error('description_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:w-auto sm:text-sm transition-colors">
                            {{ __('Save Changes') }}
                        </button>
                        <button @click="open = false" type="button" 
                                class="w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-2 bg-white dark:bg-gray-900 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition-colors">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ open: @entangle('showDeleteModal') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div @click="open = false" class="absolute inset-0 bg-gray-500/75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">حذف العمل</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">هل أنت متأكد من رغبتك في حذف هذا العمل من معرض الأعمال؟</p>
                    <div class="flex flex-row-reverse gap-3">
                        <button wire:click="delete" type="button" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">{{ __('Confirm Delete') }}</button>
                        <button @click="open = false" type="button" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">{{ __('Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
