<div class="space-y-6 max-w-2xl mx-auto">
  <div class="flex items-center justify-between">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
      <i data-lucide="list-checks" class="text-blue-600"></i>
      {{ __('My Daily Checklist') }}
    </h2>
    <button wire:click="openModal"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-all flex items-center gap-2 shadow-lg shadow-blue-500/20 active:scale-95">
      <i data-lucide="plus" class="w-4 h-4"></i>
      {{ __('Add New Item') }}
    </button>
  </div>

  <!-- Todo Feed -->
  <div class="space-y-3">
    @forelse($todos as $todo)
      <div
        class="bg-white dark:bg-gray-900 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-800 flex items-start gap-4 transition-all hover:shadow-md group">
        <button wire:click="toggleTodo({{ $todo->id }})"
          class="mt-0.5 w-6 h-6 rounded-lg border-2 flex items-center justify-center transition-colors {{ $todo->status === 'done' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-200 dark:border-gray-700' }}">
          @if($todo->status === 'done')
            <i data-lucide="check" class="w-4 h-4"></i>
          @endif
        </button>

        <div class="flex-1">
          <div class="flex items-center gap-2 mb-1">
            <h4
              class="text-sm font-bold {{ $todo->status === 'done' ? 'text-gray-400 line-through' : 'text-gray-900 dark:text-white' }}">
              {{ $todo->title }}
            </h4>
            @php
              $priorityColors = [
                'low' => 'text-gray-400',
                'normal' => 'text-blue-500',
                'high' => 'text-red-500',
              ];
            @endphp
            <i data-lucide="flag" class="w-3 h-3 {{ $priorityColors[$todo->priority] ?? 'text-gray-400' }}"></i>
          </div>

          @if($todo->description)
            <p
              class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed {{ $todo->status === 'done' ? 'line-through opacity-50' : '' }}">
              {{ $todo->description }}
            </p>
          @endif

          @if($todo->due_date)
            <div
              class="flex items-center gap-1 mt-2 text-[10px] font-bold {{ $todo->due_date->isPast() && $todo->status !== 'done' ? 'text-red-500' : 'text-gray-400' }}">
              <i data-lucide="calendar" class="w-3 h-3"></i>
              {{ $todo->due_date->format('Y/m/d') }}
              @if($todo->assigned_by && $todo->assignedBy)
                • {{ __('By:') }} {{ $todo->assignedBy->name }}
              @endif
            </div>
          @endif
        </div>

        <button wire:click="deleteTodo({{ $todo->id }})" wire:confirm="{{ __('Delete item?') }}"
          class="opacity-0 group-hover:opacity-100 p-2 text-gray-400 hover:text-red-500 transition-all">
          <i data-lucide="trash-2" class="w-4 h-4"></i>
        </button>
      </div>
    @empty
      <div class="py-20 text-center text-gray-400 italic">
        <i data-lucide="sparkles" class="w-12 h-12 mx-auto mb-4 opacity-10"></i>
        {{ __('No todos. Enjoy your peace!') }}
      </div>
    @endforelse
  </div>

  <!-- Modal -->
  @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="isModalOpen = false"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-2xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 dark:border-gray-800">
          <form wire:submit.prevent="store">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-4 dark:border-gray-800">
                {{ __('Add New Reminder') }}
              </h3>

              <div class="space-y-4">
                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ __('Task Title') }}</label>
                  <input wire:model="title" type="text"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-1 focus:ring-blue-500">
                  @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ __('Priority') }}</label>
                    <select wire:model="priority"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-1 focus:ring-blue-500">
                      <option value="low">{{ __('Low') }}</option>
                      <option value="normal">{{ __('Normal') }}</option>
                      <option value="high">{{ __('High') }}</option>
                    </select>
                  </div>
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ __('Due Date') }}</label>
                    <input wire:model="due_date" type="date"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-1 focus:ring-blue-500">
                  </div>
                </div>

                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ __('Additional Details') }}</label>
                  <textarea wire:model="description" rows="3"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm dark:text-white focus:ring-1 focus:ring-blue-500"></textarea>
                </div>
              </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex items-center justify-end gap-3">
              <button type="button" @click="isModalOpen = false"
                class="px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-medium hover:underline">
                {{ __('Nevermind') }}
              </button>
              <button type="submit"
                class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                {{ __('Add Task') }}
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