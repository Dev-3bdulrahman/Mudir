<div>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('Manage Subscribers') }}</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('Manage clients and their active licenses') }}</p>
        </div>
        <button wire:click="create" class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>{{ __('Add Subscriber') }}</span>
        </button>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-right">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                    <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Name') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Domain') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Product') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Expires At') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Status') }}</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-700 dark:text-gray-300">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($subscribers as $subscriber)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 dark:text-white">{{ $subscriber['name'] }}</div>
                        <div class="text-xs text-gray-500">{{ $subscriber['email'] }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-mono text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded">{{ $subscriber['domain'] }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $subscriber['product']['name'][app()->getLocale()] ?? ($subscriber['product']['name']['en'] ?? 'N/A') }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                        {{ $subscriber['expires_at'] ? date('Y-m-d', strtotime($subscriber['expires_at'])) : 'Never' }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'active' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                'suspended' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'expired' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                            ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $statusColors[$subscriber['status']] ?? 'bg-gray-100' }}">
                            {{ __(ucfirst($subscriber['status'])) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button wire:click="edit({{ $subscriber['id'] }})" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button wire:click="confirmDelete({{ $subscriber['id'] }})" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
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
    <div x-data="{ open: @entangle('showModal').live }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="open" @click="open = false" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 class="bg-white dark:bg-gray-900 rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:max-w-2xl sm:w-full z-10 border border-gray-100 dark:border-gray-800">
                
                <form wire:submit="save">
                    <div class="bg-white dark:bg-gray-900 px-6 py-6 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $selectedId ? __('Edit Subscriber') : __('Add Subscriber') }}
                        </h3>
                    </div>

                    <div class="bg-white dark:bg-gray-900 px-6 py-6 space-y-4 text-right">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Full Name') }}</label>
                                <input wire:model="name" type="text" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white outline-none">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Email Address') }}</label>
                                <input wire:model="email" type="email" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white outline-none">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Domain') }}</label>
                                <input wire:model="domain" type="text" placeholder="example.com" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white outline-none font-mono">
                                @error('domain') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Licensed Product') }}</label>
                                <select wire:model="licensed_product_id" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white outline-none">
                                    <option value="">{{ __('Select Product') }}</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product['id'] }}">{{ $product['name'][app()->getLocale()] ?? array_shift($product['name']) }}</option>
                                    @endforeach
                                </select>
                                @error('licensed_product_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Expires At') }}</label>
                                <input wire:model="expires_at" type="date" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white outline-none">
                                @error('expires_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Grace Period (Days)') }}</label>
                                <input wire:model="grace_period_days" type="number" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white outline-none">
                                @error('grace_period_days') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Status') }}</label>
                                <select wire:model="status" class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white outline-none">
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="expired">Expired</option>
                                </select>
                                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('License Key') }}</label>
                            <input wire:model="license_key" type="text" readonly class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-500 font-mono text-sm outline-none" placeholder="Auto-generated on save">
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">{{ __('Save Changes') }}</button>
                        <button @click="open = false" type="button" class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation -->
    <div x-data="{ open: @entangle('showDeleteModal') }" x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="relative flex items-center justify-center min-h-screen">
            <div @click="open = false" class="absolute inset-0 bg-gray-500/75 transition-opacity"></div>
            <div class="bg-white dark:bg-gray-900 p-8 rounded-xl relative max-w-sm w-full mx-4 shadow-xl">
                <h3 class="text-lg font-bold mb-4">{{ __('Are you sure?') }}</h3>
                <div class="flex justify-end gap-3">
                    <button @click="open = false" class="px-4 py-2 text-gray-600">Cancel</button>
                    <button wire:click="delete" class="bg-red-600 text-white px-6 py-2 rounded-lg">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
