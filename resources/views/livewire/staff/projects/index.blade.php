<div class="space-y-6">
  <div class="flex items-center justify-between">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
      <i data-lucide="folder-kanban" class="text-blue-600"></i>
      {{ __('Assigned Projects') }}
    </h2>
    <div class="flex items-center gap-3">
      <div class="relative w-64">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search project name...') }}"
          class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
      </div>
      <select wire:model.live="filterStatus"
        class="px-3 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm text-gray-600">
        <option value="">{{ __('All Status') }}</option>
        <option value="in_progress">{{ __('Active') }}</option>
        <option value="review">{{ __('Review') }}</option>
        <option value="completed">{{ __('Done') }}</option>
      </select>
    </div>
  </div>

  <!-- Projects Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($projects as $project)
      <div
        class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col group transition-all hover:shadow-lg">
        <div class="h-1.5" style="background-color: {{ $project->color ?: '#3b82f6' }}"></div>
        <div class="p-6 flex flex-col flex-1">
          <div class="flex items-start justify-between mb-4">
            <div>
              <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest"
                style="background-color: {{ ($project->color ?: '#3b82f6') }}20; color: {{ $project->color ?: '#3b82f6' }}">
                {{ $project->type }}
              </span>
              <h3
                class="text-lg font-bold text-gray-900 dark:text-white mt-1 group-hover:text-blue-600 transition-colors">
                <a href="{{ route('staff.projects.show', $project->id) }}" wire:navigate>{{ $project->name }}</a>
              </h3>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1 font-medium">
                <i data-lucide="user" class="w-3 h-3 text-gray-400"></i>
                {{ $project->client->user->name }}
              </p>
            </div>
            @php
              $statusClasses = [
                'draft' => 'text-gray-400',
                'in_progress' => 'text-blue-600',
                'review' => 'text-orange-600',
                'completed' => 'text-green-600',
                'on_hold' => 'text-red-600'
              ];
            @endphp
            <span
              class="text-[9px] font-black uppercase tracking-widest {{ $statusClasses[$project->status] ?? 'text-gray-400' }}">
              {{ str_replace('_', ' ', $project->status) }}
            </span>
          </div>

          <div class="mt-auto">
            <div class="flex items-center justify-between mb-1.5">
              <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ __('Progress') }}</span>
              <span class="text-xs font-black text-gray-900 dark:text-white">{{ $project->progress }}%</span>
            </div>
            <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
              <div class="h-full transition-all duration-700 shadow-sm"
                style="width: {{ $project->progress }}%; background-color: {{ $project->color ?: '#3b82f6' }}"></div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full py-20 text-center text-gray-400 italic">
        <i data-lucide="folder-open" class="w-12 h-12 mx-auto mb-4 opacity-10"></i>
        {{ __('No projects assigned to you yet.') }}
      </div>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $projects->links() }}
  </div>
</div>