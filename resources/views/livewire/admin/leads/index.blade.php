<div>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">رسائل التواصل</h2>
        <p class="text-gray-500 text-sm">عرض وإدارة طلبات العملاء والاستفسارات</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-right">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">المرسل</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">الموضوع</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">الموقع</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">التاريخ</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">الحالة</th>
                    <th class="px-6 py-4 text-sm font-bold text-gray-500">إجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($leads as $lead)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $lead['name'] }}</div>
                        <div class="text-xs text-gray-400">{{ $lead['email'] }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                        {{ $lead['subject'] }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-gray-600">
                            @if($lead['country'] || $lead['city'])
                                <div class="flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                    <span>{{ $lead['city'] ?? '' }}{{ $lead['city'] && $lead['country'] ? ', ' : '' }}{{ $lead['country'] ?? '' }}</span>
                                </div>
                            @endif
                            @if($lead['ip_address'])
                                <div class="text-gray-400 mt-1" dir="ltr">{{ $lead['ip_address'] }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($lead['created_at'])->format('Y/m/d H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'new' => 'bg-blue-50 text-blue-600',
                                'read' => 'bg-gray-50 text-gray-600',
                                'replied' => 'bg-green-50 text-green-600'
                            ];
                            $statusLabels = [
                                'new' => __('New'),
                                'read' => __('Read'),
                                'replied' => __('Replied')
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $statusColors[$lead['status']] }}">
                            {{ $statusLabels[$lead['status']] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button wire:click="viewLead({{ $lead['id'] }})" class="p-2 text-gray-500 hover:text-blue-600 rounded-lg">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                            <button wire:click="confirmDelete({{ $lead['id'] }})" class="p-2 text-gray-500 hover:text-red-600 rounded-lg">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- View Lead Modal -->
    <div x-data="{ open: @entangle('showModal') }" 
         x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div @click="open = false" class="absolute inset-0 bg-gray-500/75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-middle bg-white rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                @if($selectedLead)
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">{{ __('Message Details') }}</h3>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>

                    <div class="space-y-6 text-right">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('Sender') }}</p>
                                <p class="font-bold text-gray-900">{{ $selectedLead['name'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('Email Address') }}</p>
                                <p class="font-bold text-gray-900" dir="ltr">{{ $selectedLead['email'] }}</p>
                            </div>
                        </div>
                        @if($selectedLead['phone'])
                        <div>
                            <p class="text-xs text-gray-400 mb-1">{{ __('Phone') }}</p>
                            <p class="font-bold text-gray-900" dir="ltr">{{ $selectedLead['phone'] }}</p>
                        </div>
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('IP Address') }}</p>
                                <p class="font-mono text-sm text-gray-900" dir="ltr">{{ $selectedLead['ip_address'] ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-1">{{ __('Location') }}</p>
                                <p class="text-sm text-gray-900">{{ $selectedLead['city'] ?? '' }}{{ $selectedLead['city'] && $selectedLead['country'] ? ', ' : '' }}{{ $selectedLead['country'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">{{ __('Subject') }}</p>
                            <p class="font-bold text-gray-900">{{ $selectedLead['subject'] }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs text-gray-400 mb-2">{{ __('Message') }}</p>
                            <p class="text-gray-700 leading-relaxed">{{ $selectedLead['message'] }}</p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <button @click="open = false" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors">{{ __('Cancel') }}</button>
                        
                        @if($selectedLead['status'] === 'new')
                        <button wire:click="markAsRead({{ $selectedLead['id'] }})" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            {{ __('Mark as Read') }}
                        </button>
                        @endif

                        <a href="mailto:{{ $selectedLead['email'] }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            <span>{{ __('Reply via Email') }}</span>
                        </a>
                    </div>
                </div>
                @endif
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
                class="inline-block align-middle bg-white rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ __('Delete Message') }}</h3>
                    </div>
                    <p class="text-gray-600 mb-8">{{ __('Are you sure you want to delete this message? This action cannot be undone.') }}</p>

                    <div class="flex flex-row-reverse gap-3">
                        <button wire:click="delete" type="button"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                            {{ __('Confirm Delete') }}
                        </button>
                        <button @click="open = false" type="button"
                            class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
