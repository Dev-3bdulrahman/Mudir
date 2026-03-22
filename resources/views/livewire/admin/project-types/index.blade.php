<div class="space-y-6">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-4">
      <div class="relative w-64">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search types...') }}"
          class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
      </div>
    </div>

    <button wire:click="openModal"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors">
      <i data-lucide="plus" class="w-4 h-4"></i>
      {{ __('Add New Type') }}
    </button>
  </div>

  <!-- Types Table -->
  <div
    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-right border-collapse">
        <thead>
          <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
            <th
              class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">
              {{ __('Name') }}</th>
            <th
              class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">
              {{ __('Slug') }}</th>
            <th
              class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">
              {{ __('Color') }}</th>
            <th
              class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">
              {{ __('Status') }}</th>
            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left">
              {{ __('Actions') }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          @forelse($types as $type)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="background-color: {{ $type->color }}20; color: {{ $type->color }}">
                    <i data-lucide="{{ $type->icon }}" class="w-4 h-4"></i>
                  </div>
                  <div class="font-bold text-gray-900 dark:text-white">
                    {{ $type->getTranslation('name') }}
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $type->slug }}</td>
              <td class="px-6 py-4 text-center">
                <div class="inline-block w-6 h-6 rounded border border-gray-200 dark:border-gray-700"
                  style="background-color: {{ $type->color }}"></div>
              </td>
              <td class="px-6 py-4 text-center">
                @if($type->is_active)
                  <span
                    class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-green-100 text-green-600">{{ __('Active') }}</span>
                @else
                  <span
                    class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-gray-100 text-gray-600">{{ __('Inactive') }}</span>
                @endif
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center justify-start gap-2">
                  <button wire:click="edit({{ $type->id }})"
                    class="p-1.5 text-gray-400 hover:text-blue-600 transition-colors">
                    <i data-lucide="edit" class="w-4 h-4"></i>
                  </button>
                  <button wire:click="delete({{ $type->id }})" wire:confirm="{{ __('Delete this project type?') }}"
                    class="p-1.5 text-gray-400 hover:text-red-600 transition-colors">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                {{ __('No project types found.') }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-50 dark:border-gray-800">
      {{ $types->links() }}
    </div>
  </div>

  <!-- Modal -->
  @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
          wire:click="closeModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-800">
          <form wire:submit.prevent="save">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-4 dark:border-gray-800">
                {{ $editingTypeId ? __('Edit Project Type') : __('Add New Project Type') }}
              </h3>

              <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Name (Arabic)') }}</label>
                    <input wire:model="name_ar" type="text" dir="rtl"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('name_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Name (English)') }}</label>
                    <input wire:model="name_en" type="text" dir="ltr"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('name_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Color') }}</label>
                    <div class="flex gap-2">
                      <input wire:model="color" type="color"
                        class="w-10 h-10 p-1 bg-gray-50 dark:bg-gray-800 border-none rounded-lg cursor-pointer">
                      <input wire:model="color" type="text"
                        class="flex-1 px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    @error('color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Icon (Lucide)') }}</label>
                    <input wire:model="icon" type="text"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500"
                      placeholder="tag, briefcase, etc.">
                    @error('icon') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                </div>

                <div class="flex items-center gap-2">
                  <input wire:model="is_active" type="checkbox" id="is_active"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                  <label for="is_active"
                    class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active') }}</label>
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
                {{ $editingTypeId ? __('Update Type') : __('Save Type') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif
</div>