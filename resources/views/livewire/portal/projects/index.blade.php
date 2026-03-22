<div class="space-y-6">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <h2 class="text-2xl font-black text-gray-900 dark:text-white">{{ __('Project Portfolio') }}</h2>
    <div class="relative w-72">
      <input wire:model.live="search" type="text" placeholder="{{ __('Search your projects...') }}"
        class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl text-sm focus:ring-2 focus:ring-blue-500 shadow-sm transition-all">
      <i data-lucide="search" class="absolute left-3 top-3 w-4 h-4 text-gray-400"></i>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($projects as $project)
      <div
        class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col group transition-all hover:shadow-xl hover:-translate-y-1">
        <div class="h-1.5" style="background-color: {{ $project->color ?: '#3b82f6' }}"></div>
        <div class="p-8 flex flex-col flex-1">
          <div class="flex items-start justify-between mb-6">
            <div
              class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-lg ring-4 ring-gray-50 dark:ring-gray-800"
              style="background-color: {{ $project->color ?: '#3b82f6' }}">
              {{ substr($project->name, 0, 1) }}
            </div>
            <span
              class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-gray-400 border border-gray-100 dark:border-gray-800">
              {{ str_replace('_', ' ', $project->status) }}
            </span>
          </div>

          <h3 class="text-xl font-black text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 transition-colors">
            <a href="{{ route('portal.projects.show', $project->id) }}" wire:navigate>{{ $project->name }}</a>
          </h3>
          <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-6 flex-1 line-clamp-2">
            {{ $project->description }}</p>

          <div class="pt-6 border-t border-gray-50 dark:border-gray-800">
            <div class="flex items-center justify-between mb-2">
              <span
                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Project Health') }}</span>
              <span class="text-xs font-black text-gray-900 dark:text-white">{{ $project->progress }}%</span>
            </div>
            <div class="w-full h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden shadow-inner">
              <div class="h-full transition-all duration-1000 shadow-[0_0_10px_rgba(59,130,246,0.3)]"
                style="width: {{ $project->progress }}%; background-color: {{ $project->color ?: '#3b82f6' }}"></div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full py-20 text-center">
        <div
          class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6 opacity-20">
          <i data-lucide="folder-x" class="w-10 h-10"></i>
        </div>
        <h3 class="text-lg font-black text-gray-900 dark:text-white">{{ __('No Projects Found') }}</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('We are looking forward to working with you!') }}</p>
      </div>
    @endforelse
  </div>

  <div class="mt-8">
    {{ $projects->links() }}
  </div>
</div>