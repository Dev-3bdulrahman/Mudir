<div x-data="{ open: false }" class="relative">
  <button @click="open = !open"
    class="relative p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors active:scale-90">
    <i data-lucide="bell" class="w-5 h-5"></i>
    @if(auth()->user()->unreadNotifications->count() > 0)
      <span
        class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full animate-pulse border-2 border-white dark:border-gray-900"></span>
    @endif
  </button>

  <div x-show="open" @click.away="open = false" x-cloak x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
    x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
    x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
    class="absolute left-0 mt-2 w-80 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-800 z-50 overflow-hidden">

    <div
      class="p-4 border-b border-gray-50 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/50">
      <h3 class="text-xs font-black uppercase tracking-widest text-gray-400">{{ __('Notifications') }}</h3>
      @if(auth()->user()->unreadNotifications->count() > 0)
        <button wire:click="markAllAsRead" class="text-[10px] font-bold text-blue-600 hover:underline">
          {{ __('Mark all as read') }}
        </button>
      @endif
    </div>

    <div class="max-h-[350px] overflow-y-auto scrollbar-thin">
      @forelse(auth()->user()->unreadNotifications as $notification)
        <div wire:click="markAsRead('{{ $notification->id }}')"
          class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors cursor-pointer border-b border-gray-50 dark:border-gray-800 last:border-0 group">
          <div class="flex items-start gap-4">
            <div
              class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 shrink-0 group-hover:scale-110 transition-transform">
              <i data-lucide="{{ str_contains($notification->type, 'Ticket') ? 'ticket' : 'check-square' }}"
                class="w-4 h-4"></i>
            </div>
            <div class="flex-1">
              <p class="text-xs font-bold text-gray-900 dark:text-white mb-1">
                {{ $notification->data['title'] ?? 'Notification' }}
              </p>
              <p class="text-[10px] text-gray-500 dark:text-gray-400 leading-relaxed mb-2">
                {{ $notification->data['message'] ?? '' }}
              </p>
              <span class="text-[9px] font-medium text-gray-400">
                {{ $notification->created_at->diffForHumans() }}
              </span>
            </div>
          </div>
        </div>
      @empty
        <div class="p-8 text-center">
          <div class="w-12 h-12 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3">
            <i data-lucide="bell-off" class="w-6 h-6 text-gray-300"></i>
          </div>
          <p class="text-xs text-gray-400 font-medium italic">{{ __('No new notifications') }}</p>
        </div>
      @endforelse
    </div>

    @if(auth()->user()->notifications->count() > 0)
      <div class="p-3 bg-gray-50 dark:bg-gray-800/50 text-center border-t border-gray-100 dark:border-gray-800">
        <a href="#"
          class="text-[10px] font-bold text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 uppercase tracking-widest">
          {{ __('View Archive') }}
        </a>
      </div>
    @endif
  </div>
</div>