<div class="space-y-6">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl">
      <button wire:click="$set('filterScope', 'mine')"
        class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterScope === 'mine' ? 'bg-white dark:bg-gray-700 text-blue-600 shadow-sm' : 'text-gray-500' }}">
        {{ __('Assigned to Me') }}
      </button>
      <button wire:click="$set('filterScope', 'all')"
        class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterScope === 'all' ? 'bg-white dark:bg-gray-700 text-blue-600 shadow-sm' : 'text-gray-500' }}">
        {{ __('All Tickets') }}
      </button>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative w-64">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search...') }}"
          class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
      </div>
      <select wire:model.live="filterStatus"
        class="px-3 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm text-gray-600">
        <option value="">{{ __('All') }}</option>
        <option value="open">{{ __('Open') }}</option>
        <option value="in_progress">{{ __('In Progress') }}</option>
        <option value="resolved">{{ __('Resolved') }}</option>
      </select>
    </div>
  </div>

  <!-- Tickets List -->
  <div
    class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
    <div class="divide-y divide-gray-50 dark:divide-gray-800">
      @forelse($tickets as $ticket)
        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-all group">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-4">
              <div
                class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 shrink-0">
                <i data-lucide="{{ $ticket->priority === 'urgent' ? 'alert-circle' : 'message-square' }}"
                  class="w-5 h-5"></i>
              </div>
              <div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                  <a href="{{ route('staff.tickets.show', $ticket->id) }}" wire:navigate>{{ $ticket->subject }}</a>
                </h4>
                <div class="flex flex-wrap items-center gap-3 mt-1 text-[11px] text-gray-500 font-medium">
                  <span class="flex items-center gap-1"><i data-lucide="user" class="w-3 h-3"></i>
                    {{ $ticket->client->user->name }}</span>
                  <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                  <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i>
                    {{ $ticket->created_at->diffForHumans() }}</span>
                  @if($ticket->project)
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span class="flex items-center gap-1"><i data-lucide="layout" class="w-3 h-3"></i>
                      {{ $ticket->project->name }}</span>
                  @endif
                </div>
              </div>
            </div>

            <div class="flex items-center gap-4">
              @php
                $priorityStyles = [
                  'low' => 'text-gray-400',
                  'normal' => 'text-blue-500',
                  'high' => 'text-orange-500',
                  'urgent' => 'text-red-500 font-black',
                ];
                $statusStyles = [
                  'open' => 'bg-green-100 text-green-600',
                  'in_progress' => 'bg-blue-100 text-blue-600',
                  'resolved' => 'bg-gray-100 text-gray-500',
                  'closed' => 'bg-gray-200 text-gray-400',
                ];
              @endphp
              <div
                class="text-[10px] uppercase font-black {{ $priorityStyles[$ticket->priority] ?? 'text-gray-400' }} tracking-widest">
                {{ __($ticket->priority) }}
              </div>
              <span
                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusStyles[$ticket->status] ?? '' }}">
                {{ __($ticket->status) }}
              </span>
              <a href="{{ route('staff.tickets.show', $ticket->id) }}" wire:navigate
                class="p-2 bg-gray-100 dark:bg-gray-800 text-gray-400 rounded-lg hover:text-blue-600 transition-colors">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="py-20 text-center text-gray-400 italic">
          <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
          {{ __('Your ticket queue is empty.') }}
        </div>
      @endforelse
    </div>
  </div>

  <div class="mt-4">
    {{ $tickets->links() }}
  </div>
</div>