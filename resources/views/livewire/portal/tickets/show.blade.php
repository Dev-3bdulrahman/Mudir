<div class="max-w-4xl mx-auto space-y-8">
  <!-- Header -->
  <div
    class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-800 p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
    <div class="relative z-10 flex items-center gap-6">
      <div
        class="w-16 h-16 rounded-3xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 shadow-inner shrink-0 border border-blue-100/50 dark:border-blue-800/10">
        <i data-lucide="message-circle" class="w-8 h-8"></i>
      </div>
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">#{{ $ticket->id }}</span>
          <span class="w-1.5 h-1.5 bg-gray-200 rounded-full"></span>
          <span class="text-xs font-black text-blue-600 uppercase tracking-tighter">{{ __($ticket->priority) }}</span>
        </div>
        <h2 class="text-2xl font-black text-gray-900 dark:text-white leading-tight">{{ $ticket->subject }}</h2>
      </div>
    </div>

    <div class="flex items-center gap-4">
      @php
        $statusColors = [
          'open' => 'bg-green-100 text-green-600',
          'in_progress' => 'bg-blue-100 text-blue-600',
          'resolved' => 'bg-gray-100 text-gray-500',
          'closed' => 'bg-gray-200 text-gray-400',
        ];
      @endphp
      <span
        class="px-5 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusColors[$ticket->status] ?? '' }}">
        {{ __($ticket->status) }}
      </span>
      <a href="{{ route('portal.tickets') }}" wire:navigate
        class="p-3 bg-gray-50 dark:bg-gray-800 text-gray-400 rounded-2xl hover:text-blue-600 transition-all border border-gray-100 dark:border-gray-800 active:scale-90">
        <i data-lucide="arrow-right" class="w-6 h-6"></i>
      </a>
    </div>
  </div>

  <!-- Messages -->
  <div class="space-y-6">
    @foreach($messages as $msg)
      <div class="flex flex-col {{ $msg->user_id === auth()->id() ? 'items-start' : 'items-end' }}">
        <div
          class="max-w-[85%] md:max-w-[70%] rounded-[2rem] p-6 shadow-sm border {{ $msg->user_id === auth()->id() ? 'bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800 text-right' : 'bg-gradient-to-br from-blue-600 to-indigo-700 text-white border-blue-600 shadow-lg shadow-blue-500/10 text-right' }}">
          <div class="flex items-center justify-between gap-6 mb-3">
            <span
              class="text-xs font-black {{ $msg->user_id === auth()->id() ? 'text-gray-900 dark:text-white' : 'text-blue-50' }} uppercase tracking-tighter">
              {{ $msg->user->name }}
            </span>
            <span
              class="text-[10px] font-bold {{ $msg->user_id === auth()->id() ? 'text-gray-400' : 'text-blue-300' }} uppercase">
              {{ $msg->created_at->diffForHumans() }}
            </span>
          </div>
          <p
            class="text-sm font-medium leading-relaxed whitespace-pre-wrap {{ $msg->user_id === auth()->id() ? 'text-gray-600 dark:text-gray-400' : 'text-blue-50' }}">
            {{ $msg->body }}
          </p>

          @if($msg->attachment_path)
            <div
              class="mt-4 pt-4 border-t {{ $msg->user_id === auth()->id() ? 'border-gray-50 dark:border-gray-800' : 'border-blue-500' }}">
              <a href="{{ asset('storage/' . $msg->attachment_path) }}" target="_blank"
                class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest {{ $msg->user_id === auth()->id() ? 'text-blue-600 dark:text-blue-400' : 'text-white' }} hover:underline transition-all">
                <i data-lucide="paperclip" class="w-3 h-3"></i>
                {{ __('View Attachment') }}
              </a>
            </div>
          @endif
        </div>
      </div>
    @endforeach

    <!-- Reply Area -->
    @if($ticket->status !== 'closed')
      <div class="mt-12 group">
        <div
          class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800 p-6 focus-within:ring-4 ring-blue-500/5 transition-all">
          <textarea wire:model="messageBody" rows="4" placeholder="{{ __('Type your reply here...') }}"
            class="w-full px-4 py-2 bg-transparent border-none rounded-2xl text-sm font-medium dark:text-white focus:ring-0 placeholder-gray-400"></textarea>

          <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-50 dark:border-gray-800">
            <div class="flex flex-col gap-3">
              <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hidden sm:block">
                <i data-lucide="shield-check" class="w-3 h-3 inline mr-1 text-green-500"></i>
                {{ __('Secure Communication Channel') }}
              </p>

              <div class="flex items-center gap-3">
                <label
                  class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 dark:bg-gray-800 rounded-xl cursor-pointer hover:bg-gray-100 transition-all border border-gray-100 dark:border-gray-700 active:scale-95">
                  <i data-lucide="paperclip" class="w-4 h-4 text-gray-400"></i>
                  <span
                    class="text-[10px] font-black text-gray-500 uppercase tracking-tighter">{{ __('Attach File') }}</span>
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
              class="w-full sm:w-auto px-10 py-3.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-2xl transition-all flex items-center justify-center gap-3 shadow-xl shadow-blue-500/30 active:scale-95 group-focus-within:translate-y-[-2px]">
              <i data-lucide="send-active" class="w-4 h-4"></i>
              {{ __('Post Reply') }}
            </button>
          </div>
        </div>
      </div>
    @else
      <div
        class="bg-gray-100 dark:bg-gray-800/50 p-10 rounded-[2.5rem] text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
        <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest">{{ __('Conversation Archived') }}</h4>
        <p class="text-xs text-gray-500 mt-2">
          {{ __('This ticket was closed. If you need further assistance, please open a new request.') }}
        </p>
      </div>
    @endif
  </div>
</div>

<script>
  document.addEventListener('livewire:load', () => {
    lucide.createIcons();
  });
</script>