<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Manage Licensed Products') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage products that require licensing') }}</p>
        </div>
        <button wire:click="create" class="bg-indigo-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-indigo-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('Add Licensed Product') }}</span>
        </button>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach($licensedProducts as $product)
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-start gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        {{ is_array($product['name']) ? ($product['name'][app()->getLocale()] ?? array_shift($product['name'])) : $product['name'] }}
                    </h3>
                    <div class="flex items-center gap-1">
                        <button wire:click="edit({{ $product['id'] }})" class="p-1.5 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </button>
                        <button wire:click="confirmDelete({{ $product['id'] }})" class="p-1.5 text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed line-clamp-2">
                    {{ is_array($product['description']) ? ($product['description'][app()->getLocale()] ?? array_shift($product['description'])) : $product['description'] }}
                </p>
                <div class="mt-4 pt-4 border-t border-gray-50 dark:border-gray-800 flex items-center justify-between">
                    <span class="text-xs font-mono text-gray-400 dark:text-gray-500">{{ $product['slug'] }}</span>
                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded">Product</span>
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
                 class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                
                <form wire:submit="save">
                    <div class="bg-white dark:bg-gray-900 px-6 py-6 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ $selectedId ? __('Edit Licensed Product') : __('Add Licensed Product') }}
                            </h3>
                            <button @click="open = false" type="button" class="text-gray-400 hover:text-gray-500">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 px-6 py-6 space-y-6 text-right max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name_ar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Name') }} (العربية)</label>
                                <input wire:model="name_ar" type="text" id="name_ar" dir="rtl"
                                       class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none">
                                @error('name_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="name_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Name') }} (English)</label>
                                <input wire:model="name_en" type="text" id="name_en" dir="ltr"
                                       class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none">
                                @error('name_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Slug') }} / المعرف الفريد</label>
                            <input wire:model="slug" type="text" id="slug" dir="ltr" placeholder="e.g. accounting-system"
                                   class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none font-mono">
                            @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="description_ar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Description') }} (العربية)</label>
                                <textarea wire:model="description_ar" id="description_ar" rows="3" dir="rtl"
                                          class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"></textarea>
                                @error('description_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="description_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Description') }} (English)</label>
                                <textarea wire:model="description_en" id="description_en" rows="3" dir="ltr"
                                          class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"></textarea>
                                @error('description_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="dashboard_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Dashboard Code') }} (PHP/Blade)</label>
                            <div class="relative">
                                <textarea wire:model="dashboard_code" id="dashboard_code" rows="12" dir="ltr"
                                          class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-green-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none font-mono text-sm leading-relaxed"
                                          placeholder="<div>... Livewire logic here ...</div>"></textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">هذا الكود سيتم حقنه في المشروع الفرعي بشكل ديناميكي.</p>
                            @error('dashboard_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition-colors">
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
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Delete Product') }}</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">{{ __('Are you sure you want to delete this product?') }}</p>
                    <div class="flex flex-row-reverse gap-3">
                        <button wire:click="delete" type="button" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">{{ __('Confirm Delete') }}</button>
                        <button @click="open = false" type="button" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">{{ __('Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
