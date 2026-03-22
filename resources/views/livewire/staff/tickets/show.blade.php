<div class="space-y-6 max-w-4xl mx-auto">
  <div
    class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 mb-1">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">#{{ $ticket->id }}</span>
        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
        <span class="text-xs font-bold text-blue-600 uppercase">{{ __($ticket->priority) }}</span>
      </div>
      <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $ticket->subject }}</h2>
      <div class="hidden md:flex items-center gap-2 mt-1 text-xs text-gray-500">
        <span class="font-bold text-gray-700 dark:text-gray-300">{{ $ticket->client->user->name }}</span>
        <span>•</span>
        <span>{{ $ticket->created_at->format('Y-m-d H:i') }}</span>
      </div>
    </div>

    <div class="flex items-center gap-3">
      <select wire:model="newStatus" wire:change="updateStatus"
        class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 border-none rounded-lg text-xs font-bold text-gray-600 dark:text-gray-400 focus:ring-1 focus:ring-blue-500">
        <option value="open">{{ __('Open') }}</option>
        <option value="in_progress">{{ __('In Progress') }}</option>
        <option value="resolved">{{ __('Resolved') }}</option>
        <option value="closed">{{ __('Closed') }}</option>
      </select>
      <a href="{{ route('staff.tickets') }}" wire:navigate
        class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
        <i data-lucide="arrow-right" class="w-5 h-5"></i>
      </a>
    </div>
  </div>

  <!-- Conversation Feed -->
  <div class="space-y-4">
    <div
      class="bg-gray-50 dark:bg-gray-800/20 rounded-2xl border border-gray-100 dark:border-gray-800 p-4 min-h-[400px] max-h-[600px] overflow-y-auto space-y-4 scrollbar-thin">
      @foreach($ticket->messages as $msg)
        <div class="flex flex-col {{ $msg->user_id === auth()->id() ? 'items-start' : 'items-end' }}">
          <div
            class="max-w-[90%] md:max-w-[75%] rounded-2xl p-4 shadow-sm border {{ $msg->is_internal ? 'bg-amber-50 border-amber-200 dark:bg-amber-900/10 dark:border-amber-800/50' : ($msg->user_id === auth()->id() ? 'bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800 text-right' : 'bg-blue-600 text-white border-blue-600 text-right') }}">
            @if($msg->is_internal)
              <div class="flex items-center gap-1 text-[9px] font-bold text-amber-600 dark:text-amber-400 uppercase mb-2">
                <i data-lucide="lock" class="w-3 h-3"></i>
                {{ __('Private Note') }}
              </div>
            @endif
            <div class="flex items-center justify-between gap-4 mb-2">
              <span
                class="text-xs font-bold {{ $msg->user_id === auth()->id() ? 'text-gray-900 dark:text-white' : ($msg->is_internal ? 'text-amber-900 dark:text-amber-100' : 'text-blue-50') }}">
                {{ $msg->user->name }}
              </span>
              <span
                class="text-[10px] {{ $msg->user_id === auth()->id() ? 'text-gray-400' : ($msg->is_internal ? 'text-amber-500' : 'text-blue-200') }}">
                {{ $msg->created_at->diffForHumans() }}
              </span>
            </div>
            <p
              class="text-sm leading-relaxed whitespace-pre-wrap {{ $msg->user_id === auth()->id() ? 'text-gray-600 dark:text-gray-400' : ($msg->is_internal ? 'text-amber-900 dark:text-amber-100' : 'text-blue-50') }}">
              {{ $msg->body }}</p>

            @if($msg->attachment_path)
              <div
                class="mt-4 pt-4 border-t {{ $msg->user_id === auth()->id() ? 'border-gray-50 dark:border-gray-800' : ($msg->is_internal ? 'border-amber-200 dark:border-amber-800' : 'border-blue-500') }}">
                <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank"
                  class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest {{ $msg->user_id === auth()->id() ? 'text-blue-600' : ($msg->is_internal ? 'text-amber-700' : 'text-white') }} hover:underline transition-all">
                  <i data-lucide="paperclip" class="w-3 h-3"></i>
                  {{ __('View Attachment') }}
                </a>
              </div>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    <!-- Staff Reply Form -->
    @if($ticket->status !== 'closed')
        <div
          class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 p-4 transition-all focus-within:ring-2 ring-blue-500/10">
          <textarea wire:model="messageBody" rows="4" placeholder="{{ __('Type your message to the client...') }}"
            class="w-full px-4 py-2 bg-transparent border-none rounded-lg text-sm dark:text-white focus:ring-0 placeholder-gray-400"></textarea>

          <div class="flex flex-col gap-3">
            <label class="flex items-center gap-2 cursor-pointer group select-none">
              <input type="checkbox" wire:model="isInternal"
                class="w-4 h-4 text-amber-600 rounded border-gray-300 focus:ring-amber-500">
              <span
                class="text-xs font-bold text-gray-500 group-hover:text-amber-600 transition-colors uppercase">{{ __('Internal Staff Note') }}</span>
            </label>

            <div class="flex items-center gap-3">
              <label
                class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-100 transition-all border border-gray-100 dark:border-gray-700">
                <i data-lucide="paperclip" class="w-4 h-4 text-gray-500"></i>
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-tighter">{{ __('Attach File') }}</span>
                <input type="file" wire:model="attachment" class="hidden">
                <div wire:loading wire:target="attachment" class="ml-2">
                  <i data-lucide="loader" class="w-3 h-3 animate-spin text-blue-500"></i>
                </div>
              </label>
              @if($attachment)
                <span
                  class="text-[9px] font-black text-blue-600 uppercase italic">{{ $attachment->getClientOriginalName() }}</span>
                <button wire:click="$set('attachment', null)" class="text-red-500 hover:text-red-700">
                  <i data-lucide="x-circle" class="w-3 h-3"></i>
                </button>
              @endif
            </div>
          </div>

          <button wire:click="sendMessage"
            class="w-full sm:w-auto px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30 active:scale-95">
            <i data-lucide="send-active" class="w-4 h-4"></i>
            {{ __('Respond to Client') }}
          </button>
        </div>
      </div>
    @else
    <div
      class="bg-gray-100 dark:bg-gray-800 p-6 rounded-2xl text-center text-gray-500 text-sm font-medium border-2 border-dashed border-gray-200 dark:border-gray-700 italic">
      {{ __('This ticket is currently closed. If you need to respond, please change the status first.') }}
    </div>
  @endif
</div>
</div>

<script>
  document.addEventListener('livewire:load', () => {
    lucide.createIcons();
  });
</script>