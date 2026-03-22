<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-black text-gray-900 dark:text-white">{{ __('Support Center') }}</h2>
        <button wire:click="openModal" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-blue-500/20 active:scale-95 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            {{ __('New Support Request') }}
        </button>
    </div>

    <!-- Tickets Grid -->
    <div class="bg-white dark:bg-gray-900 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="divide-y divide-gray-50 dark:divide-gray-800">
            @forelse($tickets as $ticket)
                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-all group">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 shrink-0 shadow-sm border border-blue-100/50 dark:border-blue-800/20">
                                <i data-lucide="message-circle" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-black text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                    <a href="{{ route('portal.tickets.show', $ticket->id) }}" wire:navigate>{{ $ticket->subject }}</a>
                                </h4>
                                <div class="flex flex-wrap items-center gap-3 mt-1.5 text-[11px] text-gray-400 font-bold uppercase tracking-tight">
                                    <span class="flex items-center gap-1"><i data-lucide="hash" class="w-3 h-3"></i> TKT-{{ $ticket->id }}</span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3"></i> {{ $ticket->created_at->format('Y-m-d') }}</span>
                                    @if($ticket->project)
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-blue-500">{{ $ticket->project->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            @php
                                $statusColors = [
                                    'open' => 'bg-green-100 text-green-600',
                                    'in_progress' => 'bg-blue-100 text-blue-600',
                                    'resolved' => 'bg-gray-100 text-gray-500',
                                    'closed' => 'bg-gray-200 text-gray-400',
                                ];
                                $priorityColors = [
                                    'low' => 'text-gray-400',
                                    'normal' => 'text-blue-500',
                                    'high' => 'text-orange-500',
                                    'urgent' => 'text-red-500',
                                ];
                            @endphp
                            <span class="text-[10px] font-black uppercase tracking-widest {{ $priorityColors[$ticket->priority] ?? 'text-gray-400' }}">
                                {{ __($ticket->priority) }}
                            </span>
                            <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusColors[$ticket->status] ?? '' }}">
                                {{ __($ticket->status) }}
                            </span>
                             <a href="{{ route('portal.tickets.show', $ticket->id) }}" wire:navigate class="p-2.5 bg-gray-50 dark:bg-gray-800 text-gray-400 rounded-xl hover:text-blue-600 transition-all border border-gray-100 dark:border-gray-800 active:scale-90">
                                <i data-lucide="chevron-left" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-24 text-center">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800/50 rounded-full flex items-center justify-center mx-auto mb-6 opacity-20">
                        <i data-lucide="inbox" class="w-10 h-10"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white">{{ __('No Tickets Yet') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Whenever you need help, we are here for you.') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $tickets->links() }}
    </div>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" wire:click="isModalOpen = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-[2.5rem] text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-100 dark:border-gray-800">
                    <form wire:submit.prevent="store">
                        <div class="p-10">
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-8 border-b pb-6 dark:border-gray-800">
                                {{ __('Start a New Conversation') }}
                            </h3>

                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('What is this about?') }}</label>
                                    <input wire:model="subject" type="text" placeholder="{{ __('e.g. Design feedback, Bug report...') }}"
                                        class="w-full px-6 py-3.5 bg-gray-50 dark:bg-gray-800 border-none rounded-[1.5rem] text-sm dark:text-white focus:ring-2 focus:ring-blue-500 shadow-inner transition-all">
                                    @error('subject') <span class="text-red-500 text-[10px] font-bold uppercase">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Related Project') }}</label>
                                        <select wire:model="project_id" class="w-full px-6 py-3.5 bg-gray-50 dark:bg-gray-800 border-none rounded-[1.5rem] text-sm dark:text-white focus:ring-2 focus:ring-blue-500 shadow-inner appearance-none transition-all">
                                            <option value="">{{ __('General Support') }}</option>
                                            @foreach($myProjects as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Urgency Level') }}</label>
                                        <select wire:model="priority" class="w-full px-6 py-3.5 bg-gray-50 dark:bg-gray-800 border-none rounded-[1.5rem] text-sm dark:text-white focus:ring-2 focus:ring-blue-500 shadow-inner appearance-none transition-all">
                                            <option value="low">{{ __('Low - No Rush') }}</option>
                                            <option value="normal">{{ __('Normal - Standard') }}</option>
                                            <option value="high">{{ __('High - Important') }}</option>
                                            <option value="urgent">{{ __('Urgent - Immediate Action') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('How can we help?') }}</label>
                                    <textarea wire:model="message" rows="5" placeholder="{{ __('Describe your request in detail...') }}"
                                        class="w-full px-6 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-[2rem] text-sm dark:text-white focus:ring-2 focus:ring-blue-500 shadow-inner transition-all"></textarea>
                                    @error('message') <span class="text-red-500 text-[10px] font-bold uppercase">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="px-10 py-6 bg-gray-50 dark:bg-gray-800/50 flex items-center justify-end gap-5">
                            <button type="button" wire:click="isModalOpen = false" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" class="px-10 py-3.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-2xl transition-all shadow-xl shadow-blue-500/30 active:scale-95">
                                {{ __('Send Request') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:load', () => {
        lucide.createIcons();
    });
</script>
