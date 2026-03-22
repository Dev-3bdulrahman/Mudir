<div class="space-y-6">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg"
        style="background-color: {{ $project->color ?: '#3b82f6' }}">
        {{ substr($project->name, 0, 1) }}
      </div>
      <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $project->name }}</h2>
        <div class="flex items-center gap-3 mt-1">
          <span class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1">
            <i data-lucide="user" class="w-3.5 h-3.5"></i>
            {{ $project->client->user->name }}
          </span>
          <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
          <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider"
            style="background-color: {{ ($project->color ?: '#3b82f6') }}20; color: {{ $project->color ?: '#3b82f6' }}">
            {{ str_replace('_', ' ', $project->type) }}
          </span>
          <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
          @php
            $statusClasses = [
              'draft' => 'text-gray-600',
              'in_progress' => 'text-blue-600',
              'review' => 'text-orange-600',
              'completed' => 'text-green-600',
              'on_hold' => 'text-red-600'
            ];
          @endphp
          <span class="text-[10px] font-bold uppercase {{ $statusClasses[$project->status] ?? 'text-gray-600' }}">
            {{ str_replace('_', ' ', $project->status) }}
          </span>
        </div>
      </div>
    </div>

    <div class="flex items-center gap-2">
      @if($project->preview_url)
        <a href="{{ $project->preview_url }}" target="_blank"
          class="px-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
          <i data-lucide="external-link" class="w-4 h-4 text-blue-500"></i>
          {{ __('Live Preview') }}
        </a>
      @endif
      <a href="{{ route('admin.projects') }}" wire:navigate
        class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg text-sm font-semibold transition-colors">
        {{ __('Back to List') }}
      </a>
    </div>
  </div>

  <!-- Main Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Column: Tasks & Updates -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Tasks Card -->
      <div
        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 overflow-hidden">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <i data-lucide="check-square" class="w-5 h-5 text-blue-600"></i>
            {{ __('Project Tasks') }}
          </h3>
          <div class="text-xs font-bold text-gray-500 bg-gray-50 dark:bg-gray-800 px-2 py-1 rounded">
            {{ $project->tasks->where('status', 'completed')->count() }} / {{ $project->tasks->count() }}
          </div>
        </div>

        <div class="space-y-4">
          <!-- New Task Form -->
          <div class="flex gap-2">
            <input wire:model="newTaskTitle" type="text" placeholder="{{ __('Add a new task...') }}"
              class="flex-1 px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm focus:ring-1 focus:ring-blue-500 dark:text-white">
            <button wire:click="addTask"
              class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
              <i data-lucide="plus" class="w-4 h-4"></i>
            </button>
          </div>

          <!-- Tasks List -->
          <div class="divide-y divide-gray-50 dark:divide-gray-800">
            @forelse($project->tasks as $task)
              <div class="flex items-center justify-between py-3 group">
                <div class="flex items-center gap-3">
                  <button wire:click="toggleTask({{ $task->id }})"
                    class="w-5 h-5 rounded-md border flex items-center justify-center transition-colors {{ $task->status === 'completed' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 dark:border-gray-700' }}">
                    @if($task->status === 'completed')
                      <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    @endif
                  </button>
                  <span
                    class="text-sm {{ $task->status === 'completed' ? 'text-gray-400 line-through' : 'text-gray-700 dark:text-gray-300' }}">
                    {{ $task->title }}
                  </span>
                </div>
                <button wire:click="deleteTask({{ $task->id }})" wire:confirm="{{ __('Delete task?') }}"
                  class="text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all">
                  <i data-lucide="x" class="w-4 h-4"></i>
                </button>
              </div>
            @empty
              <p class="py-6 text-center text-gray-400 text-sm italic">{{ __('No tasks yet.') }}</p>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Updates / Timeline Card -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-6">
          <i data-lucide="clock" class="w-5 h-5 text-purple-600"></i>
          {{ __('Project Updates') }}
        </h3>

        <div class="space-y-6">
          <!-- New Update Input -->
          <div>
            <textarea wire:model="newUpdateContent" rows="2" placeholder="{{ __('Write an update for the client...') }}"
              class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm focus:ring-1 focus:ring-purple-500 dark:text-white mb-2"></textarea>
            <div class="flex justify-end">
              <button wire:click="addUpdate"
                class="px-4 py-1.5 bg-purple-600 text-white text-xs font-bold rounded-lg hover:bg-purple-700 transition-colors">
                {{ __('Post Update') }}
              </button>
            </div>
          </div>

          <!-- Timeline -->
          <div class="relative pl-6 border-l border-gray-100 dark:border-gray-800 space-y-8">
            @forelse($project->updates->sortByDesc('created_at') as $update)
              <div class="relative">
                <div
                  class="absolute -left-[31px] top-1.5 w-2 h-2 rounded-full bg-purple-500 border-4 border-white dark:border-gray-900 ring-2 ring-purple-500 shadow-sm">
                </div>
                <div class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                  <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $update->author->name }}</span>
                    <span class="text-[10px] text-gray-500">{{ $update->created_at->diffForHumans() }}</span>
                  </div>
                  <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $update->content }}</p>
                </div>
              </div>
            @empty
              <p class="text-center text-gray-400 text-sm italic">{{ __('No updates shared yet.') }}</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Info & Team -->
    <div class="space-y-6">

      <!-- Progress Card -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase mb-4">{{ __('Overall Progress') }}</h3>
        <div class="flex items-center gap-4">
          <div class="flex-1">
            <div class="w-full h-3 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
              <div class="h-full transition-all duration-1000"
                style="width: {{ $project->progress }}%; background-color: {{ $project->color ?: '#3b82f6' }}"></div>
            </div>
          </div>
          <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $project->progress }}%</span>
        </div>
      </div>

      <!-- Team Card -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
          <i data-lucide="users" class="w-5 h-5 text-indigo-600"></i>
          {{ __('Project Team') }}
        </h3>

        <div class="space-y-4">
          <!-- Assign Employee -->
          <div class="flex gap-2">
            <select wire:model="selectedEmployeeId"
              class="flex-1 px-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-sm focus:ring-1 focus:ring-indigo-500 dark:text-white">
              <option value="">{{ __('Select Employee') }}</option>
              @foreach($employeesList as $emp)
                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
              @endforeach
            </select>
            <button wire:click="assignEmployee"
              class="px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
              <i data-lucide="user-plus" class="w-4 h-4"></i>
            </button>
          </div>

          <!-- Team List -->
          <div class="space-y-2">
            @foreach($project->employees as $emp)
              <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                <div class="flex items-center gap-2">
                  <div
                    class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xs font-bold">
                    {{ substr($emp->name, 0, 1) }}
                  </div>
                  <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $emp->name }}</span>
                </div>
                <button wire:click="removeEmployee({{ $emp->id }})" class="p-1 text-gray-400 hover:text-red-500">
                  <i data-lucide="user-minus" class="w-4 h-4"></i>
                </button>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Financial Summery (Brief) -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
          <i data-lucide="credit-card" class="w-5 h-5 text-green-600"></i>
          {{ __('Invoices') }}
        </h3>
        <div class="space-y-3">
          @forelse($project->invoices as $invoice)
            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
              <div class="text-sm font-medium">#{{ $invoice->invoice_number }}</div>
              <div class="text-sm font-bold {{ $invoice->status === 'paid' ? 'text-green-600' : 'text-red-600' }}">
                {{ $invoice->amount }} {{ $invoice->currency }}
              </div>
            </div>
          @empty
            <p class="text-center text-gray-400 text-xs italic py-2">{{ __('No invoices yet.') }}</p>
          @endforelse
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