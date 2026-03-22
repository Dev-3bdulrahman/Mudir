<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Welcome back,') }} {{ auth()->user()->name }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __("Here's an overview of your current assignments.") }}</p>
        </div>
        <div class="hidden md:block text-left">
            <div class="text-xs font-bold text-gray-400 uppercase">{{ __('Current Shift') }}</div>
            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ now()->format('Y-m-d H:i') }}</div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                    <i data-lucide="ticket" class="w-5 h-5"></i>
                </div>
                <span class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['tickets'] }}</span>
            </div>
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('My Open Tickets') }}</h3>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-purple-600">
                    <i data-lucide="list-todo" class="w-5 h-5"></i>
                </div>
                <span class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['todos'] }}</span>
            </div>
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Pending Todos') }}</h3>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                </div>
                <span class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['projects'] }}</span>
            </div>
            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Active Projects') }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ticket Queue -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-6 border-b border-gray-50 dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Recent Tickets') }}</h3>
                <a href="{{ route('staff.tickets') }}" wire:navigate class="text-xs font-bold text-blue-600 hover:underline uppercase">{{ __('View All') }}</a>
            </div>
            <div class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse($recentTickets as $ticket)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors flex items-center justify-between group">
                        <div class="flex flex-col gap-0.5">
                            <a href="{{ route('staff.tickets.show', $ticket->id) }}" wire:navigate class="text-sm font-bold text-gray-800 dark:text-gray-200 group-hover:text-blue-600">{{ $ticket->subject }}</a>
                            <span class="text-[10px] text-gray-400 font-medium uppercase">{{ $ticket->client->user->name }} • {{ $ticket->priority }}</span>
                        </div>
                        <i data-lucide="chevron-left" class="w-4 h-4 text-gray-300"></i>
                    </div>
                @empty
                    <p class="p-8 text-center text-gray-400 text-sm italic">{{ __('No tickets assigned to you yet.') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Todo List -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="p-6 border-b border-gray-50 dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('My Reminders') }}</h3>
                <a href="{{ route('staff.todos') }}" wire:navigate class="text-xs font-bold text-purple-600 hover:underline uppercase">{{ __('Manage') }}</a>
            </div>
            <div class="p-4 space-y-3">
                @forelse($pendingTodos as $todo)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-800">
                         @php
                            $priorityColors = [
                                'low' => 'bg-gray-400',
                                'normal' => 'bg-blue-500',
                                'high' => 'bg-red-500',
                            ];
                        @endphp
                        <div class="w-1.5 h-1.5 rounded-full {{ $priorityColors[$todo->priority] ?? 'bg-gray-400' }}"></div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $todo->title }}</p>
                            @if($todo->due_date)
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ __('Due:') }} {{ $todo->due_date->format('M d') }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="p-8 text-center text-gray-400 text-sm italic">{{ __('Zero pending todos. Good job!') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Active Projects -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('My Active Projects') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($activeProjects as $project)
                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-800 group">
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider" 
                            style="background-color: {{ ($project->color ?: '#3b82f6') }}20; color: {{ $project->color ?: '#3b82f6' }}">
                            {{ $project->type }}
                        </span>
                        <span class="text-[10px] font-bold text-gray-900 dark:text-white">{{ $project->progress }}%</span>
                    </div>
                    <a href="{{ route('staff.projects.show', $project->id) }}" wire:navigate class="text-sm font-bold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 block mb-3 truncate">{{ $project->name }}</a>
                    <div class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600" style="width: {{ $project->progress }}%; background-color: {{ $project->color ?: '#3b82f6' }}"></div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-6 text-center text-gray-400 text-sm italic">{{ __('No active projects for now.') }}</div>
            @endforelse
        </div>
    </div>
</div>