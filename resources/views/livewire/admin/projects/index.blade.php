<div class="space-y-6">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex flex-wrap items-center gap-4">
      <div class="relative w-64">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search projects...') }}"
          class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
      </div>

      <select wire:model.live="filterClient"
        class="px-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500 min-w-[150px]">
        <option value="">{{ __('All Clients') }}</option>
        @foreach($clientsList as $c)
          <option value="{{ $c->id }}">{{ $c->user->name }}</option>
        @endforeach
      </select>

      <select wire:model.live="filterStatus"
        class="px-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500 min-w-[150px]">
        <option value="">{{ __('All Statuses') }}</option>
        <option value="draft">{{ __('Draft') }}</option>
        <option value="in_progress">{{ __('In Progress') }}</option>
        <option value="review">{{ __('Review') }}</option>
        <option value="completed">{{ __('Completed') }}</option>
        <option value="on_hold">{{ __('On Hold') }}</option>
      </select>

      <select wire:model.live="filterType"
        class="px-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500 min-w-[150px]">
        <option value="">{{ __('All Types') }}</option>
        @foreach($projectTypes as $type)
          <option value="{{ $type->id }}">{{ $type->getTranslation('name') }}</option>
        @endforeach
      </select>
    </div>

    <button wire:click="openModal"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors whitespace-nowrap">
      <i data-lucide="plus" class="w-4 h-4"></i>
      {{ __('Add New Project') }}
    </button>
  </div>

  <!-- Projects Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($projects as $project)
      <div
        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden group">
        <div class="h-2" style="background-color: {{ $project->color ?: '#3b82f6' }}"></div>
        <div class="p-6">
          <div class="flex items-start justify-between mb-4">
            <div>
              <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"
                style="background-color: {{ ($project->projectType->color ?? ($project->color ?: '#3b82f6')) }}20; color: {{ $project->projectType->color ?? ($project->color ?: '#3b82f6') }}">
                {{ $project->projectType ? $project->projectType->getTranslation('name') : $project->type }}
              </span>
              <h3
                class="text-lg font-bold text-gray-900 dark:text-white mt-1 group-hover:text-blue-600 transition-colors">
                <a href="{{ route('admin.projects.show', $project->id) }}" wire:navigate>{{ $project->name }}</a>
              </h3>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                <i data-lucide="user" class="w-3 h-3"></i>
                {{ $project->client->user->name }}
              </p>
            </div>
            <div class="flex flex-col items-end gap-2">
              @php
                $statusClasses = [
                  'draft' => 'bg-gray-100 text-gray-600',
                  'in_progress' => 'bg-blue-100 text-blue-600',
                  'review' => 'bg-orange-100 text-orange-600',
                  'completed' => 'bg-green-100 text-green-600',
                  'on_hold' => 'bg-red-100 text-red-600'
                ];
              @endphp
              <span
                class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusClasses[$project->status] ?? 'bg-gray-100 text-gray-600' }}">
                {{ str_replace('_', ' ', $project->status) }}
              </span>
            </div>
          </div>

          <div class="mt-4">
            <div class="flex items-center justify-between mb-1">
              <span class="text-xs font-medium text-gray-500">{{ __('Progress') }}</span>
              <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $project->progress }}%</span>
            </div>
            <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
              <div class="h-full transition-all duration-500"
                style="width: {{ $project->progress }}%; background-color: {{ $project->color ?: '#3b82f6' }}"></div>
            </div>
          </div>

          <div class="mt-6 pt-4 border-t border-gray-50 dark:border-gray-800 flex items-center justify-between">
            <div class="flex -space-x-2">
              @foreach($project->employees as $employee)
                <div
                  class="w-7 h-7 rounded-full border-2 border-white dark:border-gray-900 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-[10px] font-bold"
                  title="{{ $employee->name }}">
                  {{ substr($employee->name, 0, 1) }}
                </div>
              @endforeach
              @if($project->employees->isEmpty())
                <span class="text-[10px] text-gray-400 italic font-medium">{{ __('Unassigned') }}</span>
              @endif
            </div>
            <div class="flex items-center gap-2">
              <button wire:click="edit({{ $project->id }})"
                class="p-1.5 text-gray-400 hover:text-blue-600 transition-colors">
                <i data-lucide="edit" class="w-4 h-4"></i>
              </button>
              <button wire:click="delete({{ $project->id }})" wire:confirm="{{ __('Delete project?') }}"
                class="p-1.5 text-gray-400 hover:text-red-600 transition-colors">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="md:col-span-2 xl:col-span-3 py-12 text-center text-gray-500 dark:text-gray-400 italic">
        {{ __('No projects found.') }}
      </div>
    @endforelse
  </div>

  <div class="mt-8">
    {{ $projects->links() }}
  </div>

  <!-- Project Modal -->
  @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
          wire:click="closeModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-800">
          <form wire:submit.prevent="{{ $editingProjectId ? 'update' : 'store' }}">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-4 dark:border-gray-800">
                {{ $editingProjectId ? __('Edit Project') : __('Add New Project') }}
              </h3>

              <div class="space-y-4">
                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Project Name') }}</label>
                  <input wire:model="name" type="text"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                  @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Client') }}</label>
                    <select wire:model="client_id"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                      <option value="">{{ __('Select Client') }}</option>
                      @foreach($clientsList as $c)
                        <option value="{{ $c->id }}">{{ $c->user->name }}</option>
                      @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                  <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Type') }}</label>
                    <select wire:model="project_type_id"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                      <option value="">{{ __('Select Type') }}</option>
                      @foreach($projectTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->getTranslation('name') }}</option>
                      @endforeach
                    </select>
                    @error('project_type_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Status') }}</label>
                    <select wire:model="status"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                      <option value="draft">{{ __('Draft') }}</option>
                      <option value="in_progress">{{ __('In Progress') }}</option>
                      <option value="review">{{ __('Review') }}</option>
                      <option value="completed">{{ __('Completed') }}</option>
                      <option value="on_hold">{{ __('On Hold') }}</option>
                    </select>
                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Theme Color') }}</label>
                    <div class="flex gap-2 items-center">
                      <input wire:model="color" type="color"
                        class="w-10 h-10 p-1 bg-gray-50 dark:bg-gray-800 border-none rounded-lg cursor-pointer">
                      <input wire:model="color" type="text"
                        class="flex-1 px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500"
                        placeholder="#000000">
                    </div>
                    @error('color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Preview URL') }}</label>
                  <input wire:model="preview_url" type="url"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500"
                    placeholder="https://...">
                  @error('preview_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Description') }}</label>
                  <textarea wire:model="description" rows="3"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                  @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex items-center justify-end gap-3">
              <button type="button" wire:click="closeModal"
                class="px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-medium hover:underline">
                {{ __('Cancel') }}
              </button>
              <button type="submit"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors">
                {{ $editingProjectId ? __('Update Project') : __('Save Project') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif
</div>