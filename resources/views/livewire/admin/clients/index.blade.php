<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div class="relative w-72">
      <input wire:model.live="search" type="text" placeholder="{{ __('Search clients...') }}"
        class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
      <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
    </div>
    <button wire:click="openModal"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors">
      <i data-lucide="plus" class="w-4 h-4"></i>
      {{ __('Add New Client') }}
    </button>
  </div>

  <!-- Clients Table -->
  <div
    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
    <table class="w-full text-right border-collapse">
      <thead>
        <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Name') }}</th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Company') }}</th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Contact') }}</th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-center">
            {{ __('Projects') }}</th>
          <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase text-left">
            {{ __('Actions') }}</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($clients as $client)
          <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold">
                  {{ substr($client->user->name, 0, 1) }}
                </div>
                <div>
                  <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $client->user->name }}</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">{{ $client->user->email }}</p>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
              {{ $client->company_name ?: '—' }}
            </td>
            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
              {{ $client->phone ?: '—' }}
            </td>
            <td class="px-6 py-4 text-center">
              <span
                class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg text-xs font-bold">
                {{ $client->projects_count ?? 0 }}
              </span>
            </td>
            <td class="px-6 py-4 text-left">
              <div class="flex items-center gap-2">
                <button wire:click="edit({{ $client->id }})"
                  class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                  <i data-lucide="edit" class="w-4 h-4"></i>
                </button>
                <button wire:click="delete({{ $client->id }})"
                  wire:confirm="{{ __('Are you sure you want to delete this client?') }}"
                  class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
              {{ __('No clients found.') }}
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $clients->links() }}
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
          <form wire:submit.prevent="{{ $editingClientId ? 'update' : 'store' }}">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-4 dark:border-gray-800">
                {{ $editingClientId ? __('Edit Client') : __('Add New Client') }}
              </h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Full Name') }}</label>
                  <input wire:model="name" type="text"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
                  @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Email') }}</label>
                  <input wire:model="email" type="email"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
                  @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Password') }}</label>
                  <input wire:model="password" type="password"
                    placeholder="{{ $editingClientId ? __('Leave blank to keep current') : '' }}"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
                  @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Phone Number') }}</label>
                  <input wire:model="phone" type="text"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
                  @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2 space-y-1">
                  <label
                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Company Name') }}</label>
                  <input wire:model="company_name" type="text"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white">
                  @error('company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2 space-y-1">
                  <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Notes') }}</label>
                  <textarea wire:model="notes" rows="3"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white"></textarea>
                  @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                {{ $editingClientId ? __('Update Client') : __('Save Client') }}
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