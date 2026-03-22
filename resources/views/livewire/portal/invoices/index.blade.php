<div class="space-y-8">
  <h2 class="text-2xl font-black text-gray-900 dark:text-white">{{ __('Billing & Invoices') }}</h2>

  <!-- Financial Summary -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div
      class="bg-gradient-to-br from-green-500 to-green-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-green-500/10 relative overflow-hidden">
      <div class="relative z-10">
        <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">{{ __('Total Investments') }}</p>
        <h3 class="text-4xl font-black mb-1">{{ number_format($totalPaid, 0) }} <span
            class="text-lg opacity-60">{{ $currency }}</span></h3>
        <p class="text-xs font-bold opacity-60">{{ __('Total amount paid to date') }}</p>
      </div>
      <i data-lucide="check-check" class="absolute -right-6 -bottom-6 w-32 h-32 opacity-10"></i>
    </div>

    <div
      class="bg-gradient-to-br from-red-500 to-rose-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-red-500/10 relative overflow-hidden">
      <div class="relative z-10">
        <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">{{ __('Outstanding Balance') }}</p>
        <h3 class="text-4xl font-black mb-1">{{ number_format($totalDue, 0) }} <span
            class="text-lg opacity-60">{{ $currency }}</span></h3>
        <p class="text-xs font-bold opacity-60">{{ __('Payments currently pending') }}</p>
      </div>
      <i data-lucide="clock" class="absolute -right-6 -bottom-6 w-32 h-32 opacity-10"></i>
    </div>
  </div>

  <!-- Invoices Table -->
  <div
    class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
    <table class="w-full text-right">
      <thead>
        <tr class="bg-gray-50 dark:bg-gray-800/50">
          <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Invoice') }}</th>
          <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Reference') }}
          </th>
          <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
            {{ __('Amount') }}
          </th>
          <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
            {{ __('Status') }}
          </th>
          <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
            {{ __('Issue Date') }}
          </th>
          <th class="px-8 py-5"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
        @forelse($invoices as $inv)
          <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-colors group">
            <td class="px-8 py-5">
              <span class="text-sm font-black text-gray-900 dark:text-white">#{{ $inv->invoice_number }}</span>
            </td>
            <td class="px-8 py-5">
              <span
                class="text-xs font-bold text-gray-500 dark:text-gray-400">{{ $inv->project ? $inv->project->name : __('Direct Service') }}</span>
            </td>
            <td class="px-8 py-5 text-center">
              <span class="text-sm font-black text-gray-900 dark:text-white">{{ number_format($inv->amount, 0) }}
                {{ $inv->currency }}</span>
            </td>
            <td class="px-8 py-5 text-center">
              @php
                $statusStyles = [
                  'pending' => 'bg-amber-100 text-amber-600',
                  'paid' => 'bg-green-100 text-green-600',
                  'cancelled' => 'bg-gray-100 text-gray-400',
                ];
              @endphp
              <span
                class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusStyles[$inv->status] ?? '' }}">
                {{ __($inv->status) }}
              </span>
            </td>
            <td class="px-8 py-5 text-center">
              <span
                class="text-xs font-bold text-gray-500 dark:text-gray-400">{{ $inv->created_at->format('Y/m/d') }}</span>
            </td>
            <td class="px-8 py-5 text-right">
              <button wire:click="downloadInvoice({{ $inv->id }})"
                class="p-2.5 bg-gray-50 dark:bg-gray-800 text-gray-400 rounded-xl hover:text-blue-600 transition-all border border-gray-100 dark:border-gray-800 active:scale-95">
                <i data-lucide="download" class="w-4 h-4"></i>
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="py-20 text-center text-gray-400 font-medium italic">
              {{ __('No billing history available.') }}
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $invoices->links() }}
  </div>
</div>

<script>
  document.addEventListener('livewire:load', () => {
    lucide.createIcons();
  });
</script>