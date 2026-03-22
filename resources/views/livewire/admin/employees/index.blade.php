<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div class="relative w-72">
      <input wire:model.live="search" type="text" placeholder="{{ __('Search employees...') }}"
        class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
      <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
    </div>
    <button wire:click="openModal"
      class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors shadow-lg shadow-indigo-500/20">
      <i data-lucide="user-plus" class="w-4 h-4"></i>
      {{ __('Add New Employee') }}
    </button>
  </div>

  <!-- Employees List -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($employees as $employee)
      <div
        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 flex flex-col items-center text-center transition-all hover:shadow-md">
        <div
          class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold mb-4 shadow-inner ring-4 ring-gray-50 dark:ring-gray-800">
          {{ substr($employee->name, 0, 1) }}
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $employee->name }}</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $employee->email }}</p>

        <div
          class="flex items-center gap-4 mt-auto pt-4 border-t border-gray-50 dark:border-gray-800 w-full justify-center">
          <button wire:click="edit({{ $employee->id }})"
            class="p-2 text-gray-400 hover:text-indigo-600 transition-colors">
            <i data-lucide="edit" class="w-5 h-5"></i>
          </button>
          <button wire:click="delete({{ $employee->id }})" wire:confirm="{{ __('Delete employee account?') }}"
            class="p-2 text-gray-400 hover:text-red-500 transition-colors">
            <i data-lucide="trash-2" class="w-5 h-5"></i>
          </button>
        </div>
      </div>
    @empty
      <div class="col-span-full py-12 text-center text-gray-500 dark:text-gray-400 italic">
        {{ __('No employees found.') }}
      </div>
    @endforelse
  </div>

  <div class="mt-8">
    {{ $employees->links() }}
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
          <form wire:submit.prevent="{{ $editingEmployeeId ? 'update' : 'store' }}">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-4 dark:border-gray-800">
                {{ $editingEmployeeId ? __('Edit Staff Member') : __('Add New Staff Member') }}
              </h3>

              <div class="space-y-4">
                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Full Name') }}</label>
                  <input wire:model="name" type="text"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-indigo-500">
                  @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Email Address') }}</label>
                  <input wire:model="email" type="email"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-indigo-500">
                  @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Password') }}</label>
                  <input wire:model="password" type="password"
                    placeholder="{{ $editingEmployeeId ? __('Leave blank to keep current') : '' }}"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-indigo-500">
                  @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex items-center justify-end gap-3">
              <button type="button" wire:click="closeModal"
                class="px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-medium hover:underline">
                {{ __('Cancel') }}
              </button>
              <button type="submit"
                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg transition-colors">
                {{ $editingEmployeeId ? __('Update Employee') : __('Save Employee') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif
</div>