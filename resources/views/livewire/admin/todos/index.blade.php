<div class="space-y-6">
  <!-- Filters & Actions -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex flex-wrap items-center gap-3">
      <div class="relative w-60">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search todos...') }}"
          class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
      </div>

      <select wire:model.live="filterUser"
        class="px-3 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 min-w-[140px]">
        <option value="">{{ __('All Staff') }}</option>
        @foreach($employeesList as $emp)
          <option value="{{ $emp->id }}">{{ $emp->name }}</option>
        @endforeach
      </select>

      <select wire:model.live="filterStatus"
        class="px-3 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 min-w-[120px]">
        <option value="">{{ __('All Status') }}</option>
        <option value="pending">{{ __('Pending') }}</option>
        <option value="in_progress">{{ __('In Progress') }}</option>
        <option value="done">{{ __('Done') }}</option>
      </select>

      <select wire:model.live="filterPriority"
        class="px-3 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 min-w-[120px]">
        <option value="">{{ __('All Priority') }}</option>
        <option value="low">{{ __('Low') }}</option>
        <option value="normal">{{ __('Normal') }}</option>
        <option value="high">{{ __('High') }}</option>
      </select>
    </div>

    <button wire:click="openModal"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors">
      <i data-lucide="plus" class="w-4 h-4"></i>
      {{ __('Assign Todo') }}
    </button>
  </div>

  <!-- Todos Grid (Admin view: Task based) -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
    @forelse($todos as $todo)
      <div
        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-5 flex flex-col group relative">
        <div class="flex items-center justify-between mb-3">
          @php
            $priorityColors = [
              'low' => 'text-gray-400',
              'normal' => 'text-blue-500',
              'high' => 'text-red-500',
            ];
          @endphp
          <i data-lucide="flag" class="w-4 h-4 {{ $priorityColors[$todo->priority] ?? 'text-gray-400' }}"></i>

          <div class="flex items-center gap-1">
            @if($todo->status === 'done')
              <span class="text-[10px] font-bold text-green-500 uppercase">{{ __('Completed') }}</span>
            @elseif($todo->due_date && $todo->due_date->isPast())
              <span class="text-[10px] font-bold text-red-500 uppercase">{{ __('Overdue') }}</span>
            @endif
          </div>
        </div>

        <h4
          class="text-sm font-bold text-gray-900 dark:text-white leading-snug mb-2 {{ $todo->status === 'done' ? 'line-through text-gray-400' : '' }}">
          {{ $todo->title }}
        </h4>

        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 line-clamp-2">
          {{ $todo->description }}
        </p>

        <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50 dark:border-gray-800">
          <div class="flex items-center gap-2">
            <div
              class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-[10px] font-bold text-indigo-600 dark:text-indigo-400"
              title="{{ $todo->user->name }}">
              {{ substr($todo->user->name, 0, 1) }}
            </div>
            <span class="text-[11px] text-gray-500 font-medium">{{ $todo->user->name }}</span>
          </div>

          <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
            <button wire:click="edit({{ $todo->id }})" class="p-1 text-gray-400 hover:text-blue-600">
              <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
            </button>
            <button wire:click="delete({{ $todo->id }})" wire:confirm="{{ __('Delete todo?') }}"
              class="p-1 text-gray-400 hover:text-red-600">
              <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
            </button>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full py-12 text-center text-gray-500 dark:text-gray-400 italic">
        {{ __('No todos assigned yet.') }}
      </div>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $todos->links() }}
  </div>

  <!-- Modal -->
  @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
          wire:click="closeModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 dark:border-gray-800">
          <form wire:submit.prevent="{{ $editingTodoId ? 'update' : 'store' }}">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-4 dark:border-gray-800">
                {{ $editingTodoId ? __('Edit Todo') : __('Assign New Todo') }}
              </h3>

              <div class="space-y-4">
                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Assign to Staff Member') }}</label>
                  <select wire:model="user_id"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-1 focus:ring-blue-500">
                    <option value="">{{ __('Select Staff Member') }}</option>
                    @foreach($employeesList as $emp)
                      <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                    @endforeach
                  </select>
                  @error('user_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Title') }}</label>
                  <input wire:model="title" type="text"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-1 focus:ring-blue-500">
                  @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Priority') }}</label>
                    <select wire:model="priority"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-1 focus:ring-blue-500">
                      <option value="low">{{ __('Low') }}</option>
                      <option value="normal">{{ __('Normal') }}</option>
                      <option value="high">{{ __('High') }}</option>
                    </select>
                    @error('priority') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Due Date') }}</label>
                    <input wire:model="due_date" type="date"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-1 focus:ring-blue-500">
                    @error('due_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Description') }}</label>
                  <textarea wire:model="description" rows="3"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
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
                {{ $editingTodoId ? __('Update Todo') : __('Assign Todo') }}
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