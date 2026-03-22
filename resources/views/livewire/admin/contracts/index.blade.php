<div class="space-y-6">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-4">
      <div class="relative w-64">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search contracts...') }}"
          class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
      </div>

      <a href="{{ route('admin.contract_templates') }}" wire:navigate class="text-xs text-blue-600 hover:underline">
        {{ __('Manage Templates') }}
      </a>
    </div>

    <button wire:click="openModal"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors">
      <i data-lucide="plus" class="w-4 h-4"></i>
      {{ __('Add New Contract') }}
    </button>
  </div>

  <!-- Contracts Table -->
  <div
    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-right border-collapse">
        <thead>
          <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
            <th
              class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">
              {{ __('Contract No') }}
            </th>
            <th
              class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">
              {{ __('Client') }}
            </th>
            <th
              class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">
              {{ __('Title') }}
            </th>
            <th
              class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">
              {{ __('Amount') }}
            </th>
            <th
              class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">
              {{ __('Status') }}
            </th>
            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">
              {{ __('Actions') }}
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          @forelse($contracts as $contract)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
              <td class="px-6 py-4 font-mono text-xs">{{ $contract->contract_number }}</td>
              <td class="px-6 py-4">
                <div class="font-bold text-gray-900 dark:text-white">{{ $contract->client->user->name }}</div>
              </td>
              <td class="px-6 py-4 text-sm">{{ $contract->getTranslation('title') }}</td>
              <td class="px-6 py-4 text-sm font-bold">
                {{ $contract->total_amount ? number_format($contract->total_amount, 2) . ' ' . $contract->currency : '-' }}
              </td>
              <td class="px-6 py-4 text-center">
                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase 
                                                @if($contract->status == 'signed') bg-green-100 text-green-600
                                                @elseif($contract->status == 'draft') bg-gray-100 text-gray-600
                                                @elseif($contract->status == 'sent') bg-blue-100 text-blue-600
                                                @else bg-red-100 text-red-600 @endif">
                  {{ __($contract->status) }}
                </span>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center justify-start gap-2">
                  <button wire:click="edit({{ $contract->id }})"
                    class="p-1.5 text-gray-400 hover:text-blue-600 transition-colors" title="{{ __('Edit') }}">
                    <i data-lucide="edit" class="w-4 h-4"></i>
                  </button>
                  <button wire:click="openDownloadModal({{ $contract->id }})"
                    class="p-1.5 text-gray-400 hover:text-blue-600 transition-colors" title="{{ __('Download PDF') }}">
                    <i data-lucide="download" class="w-4 h-4"></i>
                  </button>
                  <button wire:click="delete({{ $contract->id }})" wire:confirm="{{ __('Delete this contract?') }}"
                    class="p-1.5 text-gray-400 hover:text-red-600 transition-colors">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                {{ __('No contracts found.') }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-50 dark:border-gray-800">
      {{ $contracts->links() }}
    </div>
  </div>

  <!-- Modal -->
  @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
          wire:click="closeModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full border border-gray-100 dark:border-gray-800">
          <form wire:submit.prevent="save">
            <div class="p-6">
              <div class="flex items-center justify-between mb-6 border-b pb-4 dark:border-gray-800">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                  {{ $editingContractId ? __('Edit Contract') : __('Create New Contract') }}
                </h3>
                <div class="text-xs font-mono text-gray-400 bg-gray-50 dark:bg-gray-800 px-3 py-1 rounded-full">
                  {{ $contract_number }}
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="space-y-1 text-right">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Select Client') }}</label>
                  <select wire:model="client_id"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">{{ __('Select Client') }}</option>
                    @foreach($clients as $client)
                      <option value="{{ $client->id }}">{{ $client->user->name }}</option>
                    @endforeach
                  </select>
                  @error('client_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1 text-right">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Load from Template') }}</label>
                  <select wire:model.live="contract_template_id"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">{{ __('Manual Creation') }}</option>
                    @foreach($templates as $template)
                      <option value="{{ $template->id }}">{{ $template->getTranslation('title') }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="space-y-1 text-right">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Total Amount') }}</label>
                  <div class="flex gap-2">
                    <input wire:model="total_amount" type="number" step="0.01"
                      class="flex-1 px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    <select wire:model="currency"
                      class="w-24 px-2 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                      <option value="USD">USD</option>
                      <option value="AED">AED</option>
                      <option value="SAR">SAR</option>
                      <option value="EUR">EUR</option>
                    </select>
                  </div>
                  @error('total_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t pt-6 dark:border-gray-800">
                <div class="space-y-4" dir="rtl">
                  <div class="space-y-1 text-right">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Contract Title (Arabic)') }}</label>
                    <input wire:model="title_ar" type="text"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('title_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                  <div class="space-y-1 text-right">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Clauses (Arabic - one per line)') }}</label>
                    <textarea wire:model="content_ar" rows="12"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500 font-mono"></textarea>
                    @error('content_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="space-y-4" dir="ltr">
                  <div class="space-y-1 text-left">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Contract Title (English)') }}</label>
                    <input wire:model="title_en" type="text"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('title_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                  <div class="space-y-1 text-left">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Clauses (English - one per line)') }}</label>
                    <textarea wire:model="content_en" rows="12"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500 font-mono"></textarea>
                    @error('content_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex items-center justify-end gap-3">
              <button type="button" wire:click="closeModal"
                class="px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-medium hover:underline">
                {{ __('Cancel') }}
              </button>
              <button type="submit"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors">
                {{ $editingContractId ? __('Update Contract') : __('Generate Contract') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  {{-- Download / Language Selection Modal --}}
  @if($isDownloadModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
          wire:click="closeDownloadModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-2xl p-8 text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 dark:border-gray-800">
          <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6 text-center">
            {{ __('Download Contract') }}
          </h3>

          {{-- Customization Options (Same as Quotations) --}}
          <div class="mb-8 space-y-4 text-sm text-gray-600 dark:text-gray-400">
            <div class="grid grid-cols-2 gap-3">
              <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                <span class="font-medium text-gray-700 dark:text-gray-200">{{ __('Show Logo') }}</span>
                <button wire:click="$toggle('showLogo')"
                  class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $showLogo ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                  <span
                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $showLogo ? (app()->getLocale() == 'ar' ? '-translate-x-6' : 'translate-x-6') : (app()->getLocale() == 'ar' ? '-translate-x-1' : 'translate-x-1') }}"></span>
                </button>
              </div>
              <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                <span class="font-medium text-gray-700 dark:text-gray-200">{{ __('Show Background') }}</span>
                <button wire:click="$toggle('showBackground')"
                  class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $showBackground ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                  <span
                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $showBackground ? (app()->getLocale() == 'ar' ? '-translate-x-6' : 'translate-x-6') : (app()->getLocale() == 'ar' ? '-translate-x-1' : 'translate-x-1') }}"></span>
                </button>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                <span class="font-medium text-gray-700 dark:text-gray-200">{{ __('Company Signature') }}</span>
                <button wire:click="$toggle('showCompanySignature')"
                  class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $showCompanySignature ? 'bg-green-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                  <span
                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $showCompanySignature ? (app()->getLocale() == 'ar' ? '-translate-x-6' : 'translate-x-6') : (app()->getLocale() == 'ar' ? '-translate-x-1' : 'translate-x-1') }}"></span>
                </button>
              </div>
              <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                <span class="font-medium text-gray-700 dark:text-gray-200">{{ __('Client Signature') }}</span>
                <button wire:click="$toggle('showClientSignature')"
                  class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $showClientSignature ? 'bg-green-600' : 'bg-gray-200 dark:bg-gray-700' }}">
                  <span
                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $showClientSignature ? (app()->getLocale() == 'ar' ? '-translate-x-6' : 'translate-x-6') : (app()->getLocale() == 'ar' ? '-translate-x-1' : 'translate-x-1') }}"></span>
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
            <button wire:click="downloadPdf('ar')"
              class="px-6 py-10 bg-gray-50 dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900 border-2 border-transparent hover:border-blue-500 rounded-2xl flex flex-col items-center gap-3 transition-all group">
              <span class="text-3xl">🇸🇦</span>
              <span class="font-black text-gray-900 dark:text-white group-hover:text-blue-600">{{ __('Arabic') }}</span>
            </button>
            <button wire:click="downloadPdf('en')"
              class="px-6 py-10 bg-gray-50 dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900 border-2 border-transparent hover:border-blue-500 rounded-2xl flex flex-col items-center gap-3 transition-all group">
              <span class="text-3xl">🇺🇸</span>
              <span class="font-black text-gray-900 dark:text-white group-hover:text-blue-600">{{ __('English') }}</span>
            </button>
          </div>

          <button type="button" wire:click="closeDownloadModal"
            class="mt-6 w-full py-3 bg-gray-100 dark:bg-gray-800 text-sm font-bold text-gray-500 rounded-xl hover:bg-gray-200 transition-colors">
            {{ __('Cancel') }}
          </button>
        </div>
      </div>
    </div>
  @endif

</div>