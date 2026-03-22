<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-4">
      <div class="relative w-72">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search invoices or projects...') }}"
          class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
      </div>
      <select wire:model.live="filterStatus"
        class="px-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500 min-w-[150px]">
        <option value="">{{ __('All Statuses') }}</option>
        <option value="pending">{{ __('Pending') }}</option>
        <option value="paid">{{ __('Paid') }}</option>
        <option value="cancelled">{{ __('Cancelled') }}</option>
      </select>
    </div>
    <button wire:click="openModal"
      class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors shadow-lg shadow-green-500/20">
      <i data-lucide="file-text" class="w-4 h-4"></i>
      {{ __('Create Invoice') }}
    </button>
  </div>

  <!-- Invoices Table -->
  <div
    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
    <table class="w-full text-right border-collapse">
      <thead>
        <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-right">
            {{ __('Number') }}
          </th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-right">
            {{ __('Project/Client') }}
          </th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-right">
            {{ __('Amount') }}
          </th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-right">
            {{ __('Due Date') }}
          </th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-center">
            {{ __('Status') }}
          </th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-left">
            {{ __('Actions') }}
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($invoices as $invoice)
          <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
            <td class="px-6 py-4">
              <span class="text-sm font-bold text-blue-600 dark:text-blue-400">#{{ $invoice->invoice_number }}</span>
            </td>
            <td class="px-6 py-4">
              <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $invoice->project->name }}</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">{{ $invoice->project->client->user->name }}</p>
            </td>
            <td class="px-6 py-4">
              <p class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($invoice->amount, 2) }}
                {{ $invoice->currency }}
              </p>
            </td>
            <td
              class="px-6 py-4 text-sm {{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'text-red-500 font-bold' : 'text-gray-600 dark:text-gray-400' }}">
              {{ $invoice->due_date->format('Y-m-d') }}
            </td>
            <td class="px-6 py-4 text-center">
              @php
                $statusClasses = [
                  'pending' => 'bg-orange-100 text-orange-600',
                  'paid' => 'bg-green-100 text-green-600',
                  'cancelled' => 'bg-red-100 text-red-600',
                ];
              @endphp
              <span
                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusClasses[$invoice->status] ?? 'bg-gray-100 text-gray-600' }}">
                {{ __($invoice->status) }}
              </span>
            </td>
            <td class="px-6 py-4 text-left">
              <div class="flex items-center gap-2">
                @if($invoice->status !== 'paid')
                  <button wire:click="markAsPaid({{ $invoice->id }})"
                    class="p-2 text-gray-400 hover:text-green-600 transition-colors" title="{{ __('Mark as Paid') }}">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                  </button>
                @endif
                <button wire:click="openDownloadModal({{ $invoice->id }}, 'print')"
                  class="p-2 text-gray-400 hover:text-orange-600 transition-colors" title="{{ __('Print') }}">
                  <i data-lucide="printer" class="w-4 h-4"></i>
                </button>
                <button wire:click="openDownloadModal({{ $invoice->id }}, 'download')"
                  class="p-2 text-gray-400 hover:text-blue-600 transition-colors" title="{{ __('Download PDF') }}">
                  <i data-lucide="download" class="w-4 h-4"></i>
                </button>
                <button wire:click="edit({{ $invoice->id }})"
                  class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                  <i data-lucide="edit" class="w-4 h-4"></i>
                </button>
                <button wire:click="delete({{ $invoice->id }})" wire:confirm="{{ __('Delete invoice?') }}"
                  class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
              {{ __('No invoices found.') }}
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $invoices->links() }}
  </div>

  <!-- Modal -->
  @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
          wire:click="closeModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-800">
          <form wire:submit.prevent="{{ $editingInvoiceId ? 'update' : 'store' }}">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-4 dark:border-gray-800">
                {{ $editingInvoiceId ? __('Edit Invoice') : __('Create New Invoice') }}
              </h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Invoice Number') }}</label>
                  <input wire:model="invoice_number" type="text"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
                  @error('invoice_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Project') }}</label>
                  <select wire:model="project_id"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
                    <option value="">{{ __('Select Project') }}</option>
                    @foreach($projectsList as $p)
                      <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->client->user->name }})</option>
                    @endforeach
                  </select>
                  @error('project_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Amount') }}</label>
                  <input wire:model="amount" type="number" step="0.01"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white font-bold">
                  @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Currency') }}</label>
                  <select wire:model="currency"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="USD">USD - $</option>
                    <option value="AED">AED - د.إ</option>
                    <option value="SAR">SAR - ر.س</option>
                    <option value="EUR">EUR - €</option>
                  </select>
                  @error('currency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Due Date') }}</label>
                  <input wire:model="due_date" type="date"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
                  @error('due_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Status') }}</label>
                  <select wire:model="status"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
                    <option value="pending">{{ __('Pending') }}</option>
                    <option value="paid">{{ __('Paid') }}</option>
                    <option value="cancelled">{{ __('Cancelled') }}</option>
                  </select>
                  @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2 space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Notes') }}</label>
                  <textarea wire:model="notes" rows="2"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white"></textarea>
                  @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex items-center justify-end gap-3">
              <button type="button" wire:click="closeModal"
                class="px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-medium hover:underline">
                {{ __('Cancel') }}
              </button>
              <button type="submit"
                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-colors">
                {{ $editingInvoiceId ? __('Update Invoice') : __('Save Invoice') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  <!-- Download/Print Modal -->
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
            <button wire:click="downloadInvoice({{ $selectedInvoiceId }}, 'ar')"
              class="px-6 py-10 bg-gray-50 dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900 border-2 border-transparent hover:border-blue-500 rounded-2xl flex flex-col items-center gap-3 transition-all group">
              <span class="text-3xl group-hover:scale-110 transition-transform">🇸🇦</span>
              <span class="font-bold text-gray-700 dark:text-gray-200">{{ __('Arabic') }}</span>
            </button>
            <button wire:click="downloadInvoice({{ $selectedInvoiceId }}, 'en')"
              class="px-6 py-10 bg-gray-50 dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900 border-2 border-transparent hover:border-blue-500 rounded-2xl flex flex-col items-center gap-3 transition-all group">
              <span class="text-3xl group-hover:scale-110 transition-transform">🇺🇸</span>
              <span class="font-bold text-gray-700 dark:text-gray-200">{{ __('English') }}</span>
            </button>
          </div>

          <button wire:click="$set('isDownloadModalOpen', false)"
            class="mt-6 w-full py-3 text-gray-500 hover:text-gray-700 font-medium transition-colors">
            {{ __('Cancel') }}
          </button>
        </div>
      </div>
    </div>
  @endif
</div>