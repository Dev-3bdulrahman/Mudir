<div class="space-y-6">
  <!-- Header/Filters -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex flex-wrap items-center gap-3">
      <div class="relative w-64">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search tickets...') }}"
          class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
      </div>

      <select wire:model.live="filterStatus"
        class="px-3 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
        <option value="">{{ __('All Statuses') }}</option>
        <option value="open">{{ __('Open') }}</option>
        <option value="in_progress">{{ __('In Progress') }}</option>
        <option value="resolved">{{ __('Resolved') }}</option>
        <option value="closed">{{ __('Closed') }}</option>
      </select>

      <select wire:model.live="filterPriority"
        class="px-3 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
        <option value="">{{ __('All Priorities') }}</option>
        <option value="low">{{ __('Low') }}</option>
        <option value="normal">{{ __('Normal') }}</option>
        <option value="high">{{ __('High') }}</option>
        <option value="urgent">{{ __('Urgent') }}</option>
      </select>
    </div>
  </div>

  <!-- Tickets Table -->
  <div
    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
    <table class="w-full text-right border-collapse">
      <thead>
        <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-right">
            {{ __('Ticket Info') }}</th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-center">
            {{ __('Priority') }}</th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-center">
            {{ __('Assigned To') }}</th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-center">
            {{ __('Status') }}</th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-left">
            {{ __('Actions') }}</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($tickets as $ticket)
          <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
            <td class="px-6 py-4">
              <div class="flex flex-col gap-0.5">
                <a href="{{ route('admin.tickets.show', $ticket->id) }}" wire:navigate
                  class="text-sm font-bold text-gray-900 dark:text-white hover:text-blue-600 transition-colors">
                  {{ $ticket->subject }}
                </a>
                <div class="flex items-center gap-2 text-[11px] text-gray-500 dark:text-gray-400">
                  <span>{{ $ticket->client->user->name }}</span>
                  <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                  <span>{{ $ticket->created_at->diffForHumans() }}</span>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              @php
                $priorityClasses = [
                  'low' => 'bg-gray-100 text-gray-600',
                  'normal' => 'bg-blue-50 text-blue-600',
                  'high' => 'bg-orange-50 text-orange-600',
                  'urgent' => 'bg-red-100 text-red-600 animate-pulse',
                ];
              @endphp
              <span
                class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $priorityClasses[$ticket->priority] ?? '' }}">
                {{ __($ticket->priority) }}
              </span>
            </td>
            <td class="px-6 py-4 text-center">
              @if($ticket->assignedTo)
                <div class="flex flex-col items-center">
                  <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $ticket->assignedTo->name }}</span>
                  <button @click="$wire.set('assigningTicketId', {{ $ticket->id }})"
                    class="text-[10px] text-blue-500 hover:underline">{{ __('Change') }}</button>
                </div>
              @else
                <button @click="$wire.set('assigningTicketId', {{ $ticket->id }})"
                  class="text-xs font-bold text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-lg border border-blue-200 dark:border-blue-800 hover:bg-blue-100 transition-colors">
                  {{ __('Assign') }}
                </button>
              @endif
            </td>
            <td class="px-6 py-4 text-center">
              @php
                $statusClasses = [
                  'open' => 'bg-green-100 text-green-600',
                  'in_progress' => 'bg-blue-100 text-blue-600',
                  'resolved' => 'bg-gray-100 text-gray-500',
                  'closed' => 'bg-gray-200 text-gray-400',
                ];
              @endphp
              <span
                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusClasses[$ticket->status] ?? '' }}">
                {{ __($ticket->status) }}
              </span>
            </td>
            <td class="px-6 py-4 text-left">
              <div class="flex items-center gap-2">
                <a href="{{ route('admin.tickets.show', $ticket->id) }}" wire:navigate
                  class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                  <i data-lucide="eye" class="w-4 h-4"></i>
                </a>
                @if($ticket->status !== 'closed')
                  <button wire:click="closeTicket({{ $ticket->id }})"
                    class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                  </button>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
              {{ __('No tickets found.') }}
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $tickets->links() }}
  </div>

  <!-- Assignment Modal (Using standard Alpine since we don't have a generic modal component yet) -->
  @if($assigningTicketId)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
          @click="$wire.set('assigningTicketId', null)"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xs sm:w-full border border-gray-100 dark:border-gray-800">
          <div class="p-6">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 uppercase tracking-wider">
              {{ __('Assign Ticket') }}</h3>
            <select wire:model="selectedEmployeeId"
              class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
              <option value="">{{ __('Select Staff Member') }}</option>
              @foreach($employeesList as $emp)
                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
              @endforeach
            </select>
            <div class="mt-6 flex justify-end gap-2">
              <button @click="$wire.set('assigningTicketId', null)"
                class="text-xs text-gray-500 hover:underline">{{ __('Cancel') }}</button>
              <button wire:click="assignEmployee"
                class="px-4 py-1.5 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition-colors">
                {{ __('Assign Now') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>