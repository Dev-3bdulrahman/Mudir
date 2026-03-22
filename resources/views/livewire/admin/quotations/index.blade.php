<div class="space-y-6">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="relative w-64">
      <input wire:model.live="search" type="text" placeholder="{{ __('Search quotations...') }}"
        class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
      <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
    </div>

    <button wire:click="openModal"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors whitespace-nowrap">
      <i data-lucide="plus" class="w-4 h-4"></i>
      {{ __('New Quotation') }}
    </button>
  </div>

  <!-- Quotations Table -->
  <div
    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-right">
        <thead>
          <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">{{ __('Client') }}</th>
            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">{{ __('Amount') }}</th>
            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">{{ __('Status') }}</th>
            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">{{ __('Expiry') }}</th>
            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">{{ __('Actions') }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          @forelse($quotations as $quote)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
              <td class="px-6 py-4">
                <div class="font-bold text-gray-900 dark:text-white">{{ $quote->display_name }}</div>
                <div class="text-xs text-gray-500">
                  {{ $quote->client_email ?: ($quote->client ? $quote->client->user->email : '') }}
                </div>
              </td>
              <td class="px-6 py-4 font-black text-blue-600">
                {{ number_format($quote->amount, 2) }} {{ $quote->currency }}
              </td>
              <td class="px-6 py-4">
                @php
                  $statusClasses = [
                    'draft' => 'bg-gray-100 text-gray-600',
                    'sent' => 'bg-blue-100 text-blue-600',
                    'accepted' => 'bg-green-100 text-green-600',
                    'rejected' => 'bg-red-100 text-red-600'
                  ];
                @endphp
                <span
                  class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusClasses[$quote->status] ?? 'bg-gray-100 text-gray-600' }}">
                  {{ __($quote->status) }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500">
                {{ $quote->expired_at ? $quote->expired_at->format('Y-m-d') : '-' }}
              </td>
              <td class="px-6 py-4 flex items-center gap-2">
                <button wire:click="openDownloadModal({{ $quote->id }}, 'print')" title="{{ __('Print') }}"
                  class="p-2 text-gray-400 hover:text-orange-600 transition-colors">
                  <i data-lucide="printer" class="w-4 h-4"></i>
                </button>
                <button wire:click="openDownloadModal({{ $quote->id }}, 'download')" title="{{ __('Download PDF') }}"
                  class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                  <i data-lucide="download" class="w-4 h-4"></i>
                </button>
                <button wire:click="sendQuotation({{ $quote->id }})" title="{{ __('Send via Email/WhatsApp') }}"
                  class="p-2 text-gray-400 hover:text-green-600 transition-colors">
                  <i data-lucide="send" class="w-4 h-4"></i>
                </button>
                <button wire:click="edit({{ $quote->id }})"
                  class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                  <i data-lucide="edit-3" class="w-4 h-4"></i>
                </button>
                <button wire:click="delete({{ $quote->id }})" wire:confirm="{{ __('Delete quotation?') }}"
                  class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">{{ __('No quotations found.') }}</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-50 dark:border-gray-800">
      {{ $quotations->links() }}
    </div>
  </div>

  <!-- Quotation Modal -->
  @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
          wire:click="closeModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-gray-100 dark:border-gray-800">
          <form wire:submit.prevent="{{ $editingQuotationId ? 'update' : 'store' }}">
            <div class="p-8">
              <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-8 border-b pb-4 dark:border-gray-800">
                {{ $editingQuotationId ? __('Edit Quotation') : __('New Quotation') }}
              </h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-4">
                  <div class="space-y-1">
                    <label
                      class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Select Client') }}</label>
                    <select wire:model.live="client_id"
                      class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                      <option value="">{{ __('Guest / External Client') }}</option>
                      @foreach($clientsList as $c)
                        <option value="{{ $c->id }}">{{ $c->user->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  @if(!$client_id)
                    <div class="space-y-1">
                      <label
                        class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Guest Name') }}</label>
                      <input wire:model="client_name" type="text"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                      @error('client_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                  @endif
                </div>

                <div class="space-y-4">
                  <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                      <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Email') }}</label>
                      <input wire:model="client_email" type="email"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="space-y-1">
                      <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Phone') }}</label>
                      <input wire:model="client_phone" type="text"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                  </div>
                  <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                      <label
                        class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Currency') }}</label>
                      <select wire:model="currency"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="USD">USD - $</option>
                        <option value="AED">AED - د.إ</option>
                        <option value="SAR">SAR - ر.س</option>
                        <option value="EUR">EUR - €</option>
                      </select>
                    </div>
                    <div class="space-y-1">
                      <label
                        class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Quotation Language') }}</label>
                      <select wire:model="language"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="ar">{{ __('Arabic') }}</option>
                        <option value="en">{{ __('English') }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="space-y-1">
                    <label
                      class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Expiry Date') }}</label>
                    <input wire:model="expired_at" type="date"
                      class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                  </div>
                </div>
              </div>

              <!-- Items Repeater -->
              <div class="space-y-4 mb-8">
                <div class="flex items-center justify-between">
                  <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">
                    {{ __('Line Items') }}
                  </h4>
                  <button type="button" wire:click="addItem"
                    class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1">
                    <i data-lucide="plus-circle" class="w-3 h-3"></i>
                    {{ __('Add Item') }}
                  </button>
                </div>

                <div class="space-y-3">
                  @foreach($items as $index => $item)
                    <div class="flex items-end gap-3 group">
                      <div class="flex-1 space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase">{{ __('Description') }}</label>
                        <input wire:model.blur="items.{{ $index }}.description" type="text"
                          class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                      </div>
                      <div class="w-20 space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase">{{ __('Qty') }}</label>
                        <input wire:model.blur="items.{{ $index }}.quantity" type="number"
                          class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500 text-center">
                      </div>
                      <div class="w-32 space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase">{{ __('Price') }}</label>
                        <input wire:model.blur="items.{{ $index }}.unit_price" type="number" step="0.01"
                          class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500 text-left">
                      </div>
                      <button type="button" wire:click="removeItem({{ $index }})"
                        class="p-2 text-gray-300 hover:text-red-500 transition-colors mb-1">
                        <i data-lucide="x" class="w-4 h-4"></i>
                      </button>
                    </div>
                  @endforeach
                </div>
              </div>

              <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-6">
                <div class="space-y-1">
                  <label
                    class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Total Amount') }}</label>
                  <div class="text-3xl font-black text-blue-600">
                    {{ number_format($amount, 2) }} <span class="text-sm">{{ $currency }}</span>
                  </div>
                </div>
                <div class="w-1/2 space-y-1">
                  <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Notes') }}</label>
                  <textarea wire:model="notes" rows="2"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
              </div>
            </div>

            <div class="px-8 py-6 bg-gray-50 dark:bg-gray-800/50 flex items-center justify-end gap-4">
              <button type="button" wire:click="closeModal"
                class="text-sm font-bold text-gray-500 hover:underline uppercase tracking-widest">
                {{ __('Cancel') }}
              </button>
              <button type="submit"
                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-xl shadow-lg shadow-blue-500/30 transition-all active:scale-95 uppercase tracking-widest">
                {{ $editingQuotationId ? __('Update Quotation') : __('Save Quotation') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  <!-- Download Language Modal -->
  @if($isDownloadModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
          wire:click="$set('isDownloadModalOpen', false)"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-2xl p-8 text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 dark:border-gray-800">
          <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6">
            {{ $downloadMode === 'print' ? __('Select Print Language') : __('Select Download Language') }}
          </h3>

          {{-- Customization Options --}}
          <div class="mb-8 space-y-4 text-sm text-gray-600 dark:text-gray-400">
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
              <span class="font-bold text-gray-700 dark:text-gray-200">{{ __('Show Background') }}</span>
              <button wire:click="$toggle('showBackground')"
                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $showBackground ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                <span
                  class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $showBackground ? (app()->getLocale() == 'ar' ? '-translate-x-6' : 'translate-x-6') : (app()->getLocale() == 'ar' ? '-translate-x-1' : 'translate-x-1') }}"></span>
              </button>
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                <span class="font-medium">{{ __('Company Signature') }}</span>
                <button wire:click="$toggle('showCompanySignature')"
                  class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors {{ $showCompanySignature ? 'bg-green-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                  <span
                    class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform {{ $showCompanySignature ? (app()->getLocale() == 'ar' ? '-translate-x-5' : 'translate-x-5') : (app()->getLocale() == 'ar' ? '-translate-x-1' : 'translate-x-1') }}"></span>
                </button>
              </div>
              <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                <span class="font-medium">{{ __('Client Signature') }}</span>
                <button wire:click="$toggle('showClientSignature')"
                  class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors {{ $showClientSignature ? 'bg-green-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                  <span
                    class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform {{ $showClientSignature ? (app()->getLocale() == 'ar' ? '-translate-x-5' : 'translate-x-5') : (app()->getLocale() == 'ar' ? '-translate-x-1' : 'translate-x-1') }}"></span>
                </button>
              </div>
            </div>

            <div class="p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
              <span class="block mb-2 font-bold text-gray-700 dark:text-gray-200">{{ __('Use Logo') }}:</span>
              <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" wire:model="pdfLogo" value="logo_dark" class="text-blue-600">
                  <span>{{ __('Dark Logo') }}</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" wire:model="pdfLogo" value="logo_light" class="text-blue-600">
                  <span>{{ __('Light Logo') }}</span>
                </label>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <button wire:click="downloadQuotation({{ $selectedQuotationId }}, 'ar')"
              class="px-6 py-10 bg-gray-50 dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900 border-2 border-transparent hover:border-blue-500 rounded-2xl flex flex-col items-center gap-3 transition-all group">
              <span class="text-3xl">🇸🇦</span>
              <span class="font-black text-gray-900 dark:text-white group-hover:text-blue-600">{{ __('Arabic') }}</span>
            </button>
            <button wire:click="downloadQuotation({{ $selectedQuotationId }}, 'en')"
              class="px-6 py-10 bg-gray-50 dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900 border-2 border-transparent hover:border-blue-500 rounded-2xl flex flex-col items-center gap-3 transition-all group">
              <span class="text-3xl">🇺🇸</span>
              <span class="font-black text-gray-900 dark:text-white group-hover:text-blue-600">{{ __('English') }}</span>
            </button>
          </div>
          <button type="button" wire:click="$set('isDownloadModalOpen', false)"
            class="mt-6 w-full py-3 bg-gray-100 dark:bg-gray-800 text-sm font-bold text-gray-500 rounded-xl hover:bg-gray-200 transition-colors">
            {{ __('Cancel') }}
          </button>
        </div>
      </div>
    </div>
  @endif
</div>