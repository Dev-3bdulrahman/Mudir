<div class="space-y-8">
  <!-- Project Hero -->
  <div
    class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-800 p-8 md:p-12 relative overflow-hidden">
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
      <div class="space-y-4">
        <div class="flex items-center gap-3">
          <span
            class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 rounded-full text-[10px] font-black text-blue-600 uppercase tracking-widest">{{ $project->type }}</span>
          <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span>
          <span class="text-xs font-bold text-gray-500 uppercase tracking-tight">{{ __('Live Phase') }}:
            {{ str_replace('_', ' ', $project->status) }}</span>
        </div>
        <h2 class="text-4xl font-black text-gray-900 dark:text-white leading-tight">{{ $project->name }}</h2>
        <p class="text-gray-500 dark:text-gray-400 font-medium max-w-xl leading-relaxed">{{ $project->description }}</p>

        <div class="flex items-center gap-3 pt-4">
          @if($project->preview_url)
            <a href="{{ $project->preview_url }}" target="_blank"
              class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2 active:scale-95">
              <i data-lucide="globe" class="w-4 h-4"></i>
              {{ __('Visit Live Site') }}
            </a>
          @endif
          <button
            class="px-6 py-2.5 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-sm font-black rounded-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center gap-2">
            <i data-lucide="message-circle" class="w-4 h-4"></i>
            {{ __('Contact Team') }}
          </button>
        </div>
      </div>

      <div
        class="shrink-0 flex flex-col items-center justify-center p-8 bg-gray-50 dark:bg-gray-800/50 rounded-[2rem] border border-gray-100 dark:border-gray-800">
        <div class="relative w-32 h-32 flex items-center justify-center">
          <svg class="w-full h-full transform -rotate-90">
            <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent"
              class="text-gray-200 dark:text-gray-800" />
            <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent"
              stroke-dasharray="364.4" stroke-dashoffset="{{ 364.4 - (364.4 * $project->progress / 100) }}"
              class="text-blue-600 transition-all duration-1000 shadow-xl" stroke-linecap="round"
              style="color: {{ $project->color ?: '#3b82f6' }}" />
          </svg>
          <div class="absolute inset-0 flex items-center justify-center flex-col">
            <span class="text-3xl font-black text-gray-900 dark:text-white">{{ $project->progress }}%</span>
            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ __('Done') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">

      <!-- Tasks List -->
      <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-800 p-8">
        <h3 class="text-xl font-black text-gray-900 dark:text-white mb-8 flex items-center gap-2">
          <i data-lucide="check-circle-2" class="text-green-500 w-6 h-6"></i>
          {{ __('Project Roadmap') }}
        </h3>

        <div class="space-y-4">
          @forelse($project->tasks as $task)
            <div
              class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-transparent transition-all cursor-default group">
              <div
                class="w-6 h-6 rounded-lg flex items-center justify-center shrink-0 {{ $task->status === 'completed' ? 'bg-green-500 text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700' }}">
                @if($task->status === 'completed')
                  <i data-lucide="check" class="w-4 h-4"></i>
                @endif
              </div>
              <span
                class="text-sm font-bold {{ $task->status === 'completed' ? 'text-gray-400 line-through' : 'text-gray-800 dark:text-gray-200' }}">
                {{ $task->title }}
              </span>
            </div>
          @empty
            <p class="text-center py-10 text-gray-400 italic text-sm">{{ __('No roadmap items yet.') }}</p>
          @endforelse
        </div>
      </div>

      <!-- News Feed -->
      <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-800 p-8">
        <h3 class="text-xl font-black text-gray-900 dark:text-white mb-8 flex items-center gap-2">
          <i data-lucide="activity" class="text-purple-500 w-6 h-6"></i>
          {{ __('Deployment Log') }}
        </h3>

        <div class="space-y-8 relative pl-6 border-l border-gray-100 dark:border-gray-800">
          @forelse($project->updates->sortByDesc('created_at') as $update)
            <div class="relative">
              <div
                class="absolute -right-[34px] top-1.5 w-2 h-2 rounded-full bg-purple-500 border-4 border-white dark:border-gray-900 ring-4 ring-purple-500/10">
              </div>
              <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                  <span
                    class="text-xs font-black text-gray-900 dark:text-white uppercase">{{ $update->author->name }}</span>
                  <span
                    class="text-[10px] text-gray-400 font-bold uppercase">{{ $update->created_at->diffForHumans() }}</span>
                </div>
                <div
                  class="p-6 bg-gray-50 dark:bg-gray-800/80 rounded-3xl text-sm text-gray-600 dark:text-gray-400 leading-relaxed font-medium">
                  {{ $update->content }}
                </div>
              </div>
            </div>
          @empty
            <p class="text-center py-10 text-gray-400 italic text-sm">{{ __('Waiting for first status report.') }}</p>
          @endforelse
        </div>
      </div>

    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
      <!-- Project Team -->
      <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-800 p-8">
        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6">{{ __('Project Team') }}</h3>
        <div class="space-y-4">
          @forelse($project->employees as $emp)
            <div class="flex items-center gap-4">
              <div
                class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-black shadow-lg shadow-indigo-500/20">
                {{ substr($emp->name, 0, 1) }}
              </div>
              <div>
                <p class="text-xs font-black text-gray-900 dark:text-white leading-none mb-1">{{ $emp->name }}</p>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">{{ __('Technical Core') }}</p>
              </div>
            </div>
          @empty
            <p class="text-xs text-gray-400 italic">{{ __('Internal review phase.') }}</p>
          @endforelse
        </div>
      </div>

      <!-- Financials -->
      <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-sm border border-gray-100 dark:border-gray-800 p-8">
        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6">{{ __('Project Billing') }}</h3>
        <div class="space-y-4">
          @foreach($project->invoices as $inv)
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs font-black text-gray-900 dark:text-white">#{{ $inv->invoice_number }}</p>
                <p
                  class="text-[10px] uppercase font-bold {{ $inv->status === 'paid' ? 'text-green-500' : 'text-red-500' }}">
                  {{ __($inv->status) }}</p>
              </div>
              <p class="text-sm font-black text-gray-900 dark:text-white">{{ number_format($inv->amount, 0) }}
                {{ $inv->currency }}</p>
            </div>
          @endforeach
        </div>
        <a href="{{ route('portal.invoices') }}" wire:navigate
          class="w-full mt-6 block py-3 bg-gray-50 dark:bg-gray-800 rounded-2xl text-center text-xs font-black text-gray-900 dark:text-white hover:bg-gray-100 transition-all uppercase tracking-widest">{{ __('All Invoices') }}</a>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('livewire:load', () => {
    lucide.createIcons();
  });
</script>