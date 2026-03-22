<div class="space-y-6 max-w-5xl mx-auto">
  <!-- Ticket Header -->
  <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">#{{ $ticket->id }} - {{ $ticket->subject }}</h2>
        <div class="flex items-center gap-3 mt-2 text-sm text-gray-500 dark:text-gray-400">
          <span class="font-medium text-gray-700 dark:text-gray-300">{{ $ticket->client->user->name }}</span>
          <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
          <span>{{ $ticket->created_at->toDayDateTimeString() }}</span>
        </div>
      </div>
      <a href="{{ route('admin.tickets') }}" wire:navigate
        class="text-sm text-gray-500 hover:underline flex items-center gap-1">
        <i data-lucide="arrow-right" class="w-4 h-4"></i>
        {{ __('Back to Queue') }}
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Conversation -->
    <div class="lg:col-span-2 space-y-4 flex flex-col h-[600px]">
      <div
        class="flex-1 overflow-y-auto space-y-4 p-4 bg-gray-50 dark:bg-gray-800/20 rounded-xl border border-gray-100 dark:border-gray-800 scrollbar-thin">
        @foreach($ticket->messages as $msg)
          <div class="flex flex-col {{ $msg->user_id === auth()->id() ? 'items-start' : 'items-end' }}">
            <div
              class="max-w-[85%] rounded-2xl p-4 shadow-sm border {{ $msg->is_internal ? 'bg-amber-50 border-amber-200 dark:bg-amber-900/20 dark:border-amber-800/50' : ($msg->user_id === auth()->id() ? 'bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800 text-right' : 'bg-blue-600 text-white border-blue-600 text-right') }}">
              @if($msg->is_internal)
                <div
                  class="flex items-center gap-1 text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase mb-2">
                  <i data-lucide="lock" class="w-3 h-3"></i>
                  {{ __('Internal Note') }}
                </div>
              @endif
              <div class="flex items-center justify-between mb-1 gap-4">
                <span
                  class="text-xs font-bold {{ $msg->user_id === auth()->id() ? 'text-gray-900 dark:text-white' : ($msg->is_internal ? 'text-amber-900 dark:text-amber-100' : 'text-blue-50') }}">
                  {{ $msg->user->name }}
                </span>
                <span
                  class="text-[10px] {{ $msg->user_id === auth()->id() ? 'text-gray-400' : ($msg->is_internal ? 'text-amber-500' : 'text-blue-200') }}">
                  {{ $msg->created_at->shortRelativeDiffForHumans() }}
                </span>
              </div>
              <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $msg->body }}</p>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Reply Box -->
      @if($ticket->status !== 'closed')
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 shadow-sm">
          <textarea wire:model="messageBody" rows="3" placeholder="{{ __('Type your reply...') }}"
            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>

          <div class="flex items-center justify-between mt-3">
            <label class="flex items-center gap-2 cursor-pointer group">
              <input type="checkbox" wire:model="isInternal"
                class="w-4 h-4 text-amber-600 rounded border-gray-300 focus:ring-amber-500">
              <span
                class="text-xs font-bold text-gray-500 group-hover:text-amber-600 transition-colors uppercase">{{ __('Internal Note') }}</span>
            </label>
            <button wire:click="sendMessage"
              class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors flex items-center gap-2 shadow-lg shadow-blue-500/20">
              <i data-lucide="send" class="w-4 h-4"></i>
              {{ __('Send Reply') }}
            </button>
          </div>
        </div>
      @else
        <div
          class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl text-center text-gray-500 text-sm italic border border-dashed border-gray-300 dark:border-gray-700">
          {{ __('This ticket is closed. Re-open it to send more messages.') }}
        </div>
      @endif
    </div>

    <!-- Sidebar Actions/Info -->
    <div class="space-y-6">
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase mb-4 tracking-wider">
          {{ __('Ticket Management') }}</h3>

        <div class="space-y-4">
          <div class="space-y-1">
            <label class="text-[11px] font-bold text-gray-400 uppercase">{{ __('Status') }}</label>
            <select wire:model="newStatus" wire:change="updateTicketSettings"
              class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
              <option value="open">{{ __('Open') }}</option>
              <option value="in_progress">{{ __('In Progress') }}</option>
              <option value="resolved">{{ __('Resolved') }}</option>
              <option value="closed">{{ __('Closed') }}</option>
            </select>
          </div>

          <div class="space-y-1">
            <label class="text-[11px] font-bold text-gray-400 uppercase">{{ __('Priority') }}</label>
            <select wire:model="newPriority" wire:change="updateTicketSettings"
              class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
              <option value="low">{{ __('Low') }}</option>
              <option value="normal">{{ __('Normal') }}</option>
              <option value="high">{{ __('High') }}</option>
              <option value="urgent">{{ __('Urgent') }}</option>
            </select>
          </div>

          <div class="space-y-1 border-t pt-4 dark:border-gray-800">
            <label class="text-[11px] font-bold text-gray-400 uppercase">{{ __('Assigned Staff') }}</label>
            <select wire:model="newAssigneeId" wire:change="updateTicketSettings"
              class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
              <option value="">{{ __('Unassigned') }}</option>
              @foreach($employeesList as $emp)
                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase mb-4 tracking-wider">
          {{ __('Project Link') }}</h3>
        @if($ticket->project)
          <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
              {{ substr($ticket->project->name, 0, 1) }}
            </div>
            <a href="{{ route('admin.projects.show', $ticket->project_id) }}" wire:navigate
              class="text-sm font-bold text-gray-900 dark:text-white hover:underline">
              {{ $ticket->project->name }}
            </a>
          </div>
        @else
          <p class="text-xs text-gray-400 italic">{{ __('No project associated.') }}</p>
        @endif
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('livewire:load', () => {
    lucide.createIcons();
  });
</script>