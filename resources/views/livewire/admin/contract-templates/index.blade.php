<div class="space-y-6">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-4">
      <div class="relative w-64">
        <input wire:model.live="search" type="text" placeholder="{{ __('Search templates...') }}"
          class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm transition-colors focus:ring-2 focus:ring-blue-500">
        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
      </div>
    </div>

    <button wire:click="openModal"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors">
      <i data-lucide="plus" class="w-4 h-4"></i>
      {{ __('Add New Template') }}
    </button>
  </div>

  <!-- Templates Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($templates as $template)
      <div
        class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md transition-all group">
        <div class="flex items-start justify-between mb-4">
          <div class="w-12 h-12 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
            <i data-lucide="file-text" class="w-6 h-6"></i>
          </div>
          <div class="flex gap-2">
            <button wire:click="edit({{ $template->id }})"
              class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
              <i data-lucide="edit" class="w-4 h-4"></i>
            </button>
            <button class="p-2 text-gray-400 hover:text-red-600 transition-colors">
              <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
          </div>
        </div>

        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 transition-colors">
          {{ $template->getTranslation('title') }}
        </h3>

        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">
          {{ count($template->content[app()->getLocale()] ?? []) }} {{ __('Clauses') }}
        </p>

        <div class="flex items-center justify-between pt-4 border-t dark:border-gray-800">
          <button wire:click="toggleStatus({{ $template->id }})"
            class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $template->is_active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }}">
            {{ $template->is_active ? __('Active') : __('Inactive') }}
          </button>
          <span
            class="text-[10px] text-gray-400 font-medium uppercase">{{ $template->created_at->format('Y-m-d') }}</span>
        </div>
      </div>
    @empty
      <div class="col-span-full py-12 text-center text-gray-500">
        {{ __('No templates found.') }}
      </div>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $templates->links() }}
  </div>

  <!-- Modal -->
  @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
          wire:click="closeModal"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
          class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-gray-100 dark:border-gray-800">
          <form wire:submit.prevent="save">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b pb-4 dark:border-gray-800">
                {{ $editingTemplateId ? __('Edit Template') : __('Add New Template') }}
              </h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Arabic Side -->
                <div class="space-y-4" dir="rtl">
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Title (Arabic)') }}</label>
                    <input wire:model="title_ar" type="text"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('title_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Clauses (Arabic - one per line)') }}</label>
                    <textarea wire:model="content_ar" rows="12"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500 font-mono"
                      placeholder="اكتب كل بند في سطر مستقل..."></textarea>
                    @error('content_ar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                </div>

                <!-- English Side -->
                <div class="space-y-4" dir="ltr">
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Title (English)') }}</label>
                    <input wire:model="title_en" type="text"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500">
                    @error('title_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                  <div class="space-y-1">
                    <label
                      class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">{{ __('Clauses (English - one per line)') }}</label>
                    <textarea wire:model="content_en" rows="12"
                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm dark:text-white focus:ring-2 focus:ring-blue-500 font-mono"
                      placeholder="Write each clause in a new line..."></textarea>
                    @error('content_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                  </div>
                </div>
              </div>

              <div class="mt-6 flex items-center gap-2">
                <input wire:model="is_active" type="checkbox" id="is_active"
                  class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="is_active"
                  class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active') }}</label>
              </div>

              <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/10 rounded-lg">
                <p class="text-xs text-blue-700 dark:text-blue-300 flex items-center gap-2">
                  <i data-lucide="info" class="w-4 h-4"></i>
                  {{ __('Supported variables') }}: <code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">@{{client_name}}</code>, <code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">@{{company_name}}</code>, <code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">@{{current_date}}</code>, <code class="bg-blue-100 dark:bg-blue-900/30 px-1 rounded">@{{contract_number}}</code>
                </p>
              </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex items-center justify-end gap-3">
              <button type="button" wire:click="closeModal"
                class="px-4 py-2 text-gray-600 dark:text-gray-400 text-sm font-medium hover:underline">
                {{ __('Cancel') }}
              </button>
              <button type="submit"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors">
                {{ $editingTemplateId ? __('Update Template') : __('Save Template') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

</div>