<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Manage Services') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage and display your services') }}</p>
        </div>
        <button wire:click="create"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('Add New Service') }}</span>
        </button>
    </div>

    <!-- Services Table -->

    <div
        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden transition-colors">
        <table class="w-full text-right">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                    <th class="px-6 py-4 text-sm font-bold text-gray-600 dark:text-gray-400">{{ __('Service') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-600 dark:text-gray-400">{{ __('Description') }}
                    </th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-600 dark:text-gray-400">{{ __('Status') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-600 dark:text-gray-400">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($services as $service)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-{{ $service['color'] }}-50 dark:bg-{{ $service['color'] }}-900/20 flex items-center justify-center text-{{ $service['color'] }}-600 dark:text-{{ $service['color'] }}-400">
                                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                                </div>
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ is_array($service['title']) ? ($service['title'][app()->getLocale()] ?? array_shift($service['title'])) : $service['title'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-md">
                            {{ is_array($service['description']) ? ($service['description'][app()->getLocale()] ?? array_shift($service['description'])) : $service['description'] }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="text-xs font-bold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">{{ __('Active') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <button wire:click="edit({{ $service['id'] }})"
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $service['id'] }})"
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ open: @entangle('showModal') }" x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full transition-colors border dark:border-gray-800">

                <form wire:submit="save">
                    <div
                        class="bg-white dark:bg-gray-900 px-6 py-6 border-b border-gray-100 dark:border-gray-800 transition-colors">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modal-title">
                                {{ $serviceId ? __('Edit Service') : __('Add New Service') }}
                            </h3>
                            <button @click="open = false" type="button"
                                class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 px-6 py-6 space-y-6 text-right transition-colors">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="title_ar"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Service Name') }}
                                    (العربية)</label>
                                <input wire:model="title_ar" type="text" id="title_ar" dir="rtl"
                                    class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                                @error('title_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="title_en"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Service Name') }}
                                    (English)</label>
                                <input wire:model="title_en" type="text" id="title_en" dir="ltr"
                                    class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none">
                                @error('title_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="description_ar"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Service Description') }}
                                    (العربية)</label>
                                <textarea wire:model="description_ar" id="description_ar" rows="4" dir="rtl"
                                    class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none"></textarea>
                                @error('description_ar') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="description_en"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Service Description') }}
                                    (English)</label>
                                <textarea wire:model="description_en" id="description_en" rows="4" dir="ltr"
                                    class="w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none"></textarea>
                                @error('description_en') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Icon Color') }}</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach(['blue', 'purple', 'cyan', 'indigo', 'green', 'orange', 'red'] as $c)
                                    <label class="relative cursor-pointer">
                                        <input wire:model="color" type="radio" name="color" value="{{ $c }}"
                                            class="sr-only peer">
                                        <div
                                            class="w-8 h-8 rounded-full bg-{{ $c }}-500 border-2 border-transparent peer-checked:border-white peer-checked:ring-2 peer-checked:ring-{{ $c }}-500 transition-all">
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-row-reverse gap-3 transition-colors">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm transition-colors">
                            {{ __('Save Changes') }}
                        </button>
                        <button @click="open = false" type="button"
                            class="w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition-colors">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ open: @entangle('showDeleteModal') }" x-show="open" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-middle bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full transition-colors border dark:border-gray-800">

                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center text-red-600 dark:text-red-400">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">حذف الخدمة</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">هل أنت متأكد من رغبتك في حذف هذه الخدمة؟ هذا
                        الإجراء لا يمكن التراجع عنه.</p>

                    <div class="flex flex-row-reverse gap-3">
                        <button wire:click="delete" type="button"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                            {{ __('Confirm Delete') }}
                        </button>
                        <button @click="open = false" type="button"
                            class="w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>