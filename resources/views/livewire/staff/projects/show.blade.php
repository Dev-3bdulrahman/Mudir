<div class="space-y-6">
  <!-- Project Header -->
  <div
    class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div class="flex items-center gap-5">
      <div
        class="w-14 h-14 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg ring-4 ring-gray-50 dark:ring-gray-800"
        style="background-color: {{ $project->color ?: '#3b82f6' }}">
        {{ substr($project->name, 0, 1) }}
      </div>
      <div>
        <h2 class="text-2xl font-black text-gray-900 dark:text-white leading-tight">{{ $project->name }}</h2>
        <div class="flex items-center gap-3 mt-1.5">
          <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest"
            style="background-color: {{ ($project->color ?: '#3b82f6') }}20; color: {{ $project->color ?: '#3b82f6' }}">
            {{ $project->type }}
          </span>
          <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
          <span class="text-xs font-bold text-gray-500 dark:text-gray-400 flex items-center gap-1">
            <i data-lucide="user" class="w-3.5 h-3.5"></i>
            {{ $project->client->user->name }}
          </span>
        </div>
      </div>
    </div>

    <div class="flex flex-col items-end gap-2 shrink-0">
      <div class="flex items-center gap-3">
        <div class="text-right">
          <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ __('Overall Completion') }}</p>
          <p class="text-lg font-black text-gray-900 dark:text-white">{{ $project->progress }}%</p>
        </div>
        <div
          class="w-10 h-10 rounded-full border-4 border-gray-100 dark:border-gray-800 flex items-center justify-center relative overflow-hidden">
          <div class="absolute inset-0 bg-blue-500 origin-bottom transition-all duration-1000"
            style="height: {{ $project->progress }}%; background-color: {{ $project->color ?: '#3b82f6' }}; opacity: 0.15">
          </div>
          <i data-lucide="activity" class="w-4 h-4" style="color: {{ $project->color ?: '#3b82f6' }}"></i>
        </div>
      </div>
      <a href="{{ route('staff.projects') }}" wire:navigate
        class="text-xs text-gray-400 hover:text-blue-600 font-bold transition-colors">{{ __('Back to List') }}</a>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Tasks Column -->
    <div class="space-y-6">
      <div
        class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="p-5 border-b border-gray-50 dark:border-gray-800 flex items-center justify-between">
          <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <i data-lucide="list-checks" class="text-blue-600"></i>
            {{ __('Pending Tasks') }}
          </h3>
          <span class="text-xs font-black text-gray-500 bg-gray-100 dark:bg-gray-800 px-2.5 py-1 rounded-lg">
            {{ $project->tasks->where('status', 'completed')->count() }} / {{ $project->tasks->count() }}
          </span>
        </div>

        <div class="p-4 space-y-2">
          @forelse($project->tasks as $task)
            <div
              class="flex items-center justify-between p-3 rounded-xl border border-transparent hover:border-gray-100 dark:hover:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/20 transition-all group">
              <div class="flex items-center gap-3">
                <button wire:click="toggleTask({{ $task->id }})"
                  class="w-5 h-5 rounded-md border-2 flex items-center justify-center transition-all {{ $task->status === 'completed' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 dark:border-gray-700' }}">
                  @if($task->status === 'completed')
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                  @endif
                </button>
                <span
                  class="text-sm font-medium {{ $task->status === 'completed' ? 'text-gray-400 line-through' : 'text-gray-700 dark:text-gray-200' }}">
                  {{ $task->title }}
                </span>
              </div>
            </div>
          @empty
            <p class="py-10 text-center text-gray-400 text-sm italic">{{ __('No tasks defined for this project.') }}</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Updates Column -->
    <div class="space-y-6">
      <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-6">
          <i data-lucide="newspaper" class="text-purple-600"></i>
          {{ __('Project Feed') }}
        </h3>

        <div class="space-y-6">
          <!-- Update Input -->
          <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-800">
            <textarea wire:model="newUpdateContent" rows="3" placeholder="{{ __('What did you accomplish today?') }}"
              class="w-full bg-transparent border-none p-0 text-sm dark:text-white focus:ring-0 placeholder-gray-400"></textarea>
            <div class="flex justify-end mt-4 border-t border-gray-200 dark:border-gray-700 pt-3">
              <button wire:click="addUpdate"
                class="px-6 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-black rounded-xl transition-all shadow-lg shadow-purple-500/20">
                {{ __('Share Status') }}
              </button>
            </div>
          </div>

          <!-- Timeline -->
          <div class="space-y-6 relative pl-6 border-l border-gray-100 dark:border-gray-800">
            @foreach($project->updates->sortByDesc('created_at') as $update)
              <div class="relative">
                <div
                  class="absolute -left-[31px] top-1.5 w-2 h-2 rounded-full bg-purple-500 border-4 border-white dark:border-gray-900 ring-2 ring-purple-500 shadow-sm">
                </div>
                <div class="flex items-center gap-2 mb-1.5">
                  <span class="text-xs font-black text-gray-900 dark:text-white">{{ $update->author->name }}</span>
                  <span
                    class="text-[10px] text-gray-400 font-bold uppercase">{{ $update->created_at->diffForHumans() }}</span>
                </div>
                <div
                  class="p-4 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 text-sm text-gray-600 dark:text-gray-400 leading-relaxed shadow-sm">
                  {{ $update->content }}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('livewire:load', () => {
    lucide.createIcons();
  });
</script>