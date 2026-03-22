<div class="space-y-6">
  <!-- Welcome Header -->
  <div
    class="flex items-center justify-between bg-gradient-to-l from-blue-600 to-indigo-700 p-8 rounded-3xl text-white shadow-xl shadow-blue-500/10 mb-8 relative overflow-hidden">
    <div class="relative z-10">
      <h1 class="text-3xl font-black mb-2">{{ __('Ahlan,') }} {{ auth()->user()->name }} 👋</h1>
      <p class="text-blue-100 font-medium max-w-md">{{ __("Here's a quick look at your projects and requests.") }}</p>
    </div>
    <div class="hidden md:block opacity-20 absolute -right-10 -bottom-10">
      <i data-lucide="layers" class="w-64 h-64"></i>
    </div>
  </div>

  <!-- Quick Stats -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div
      class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <div>
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Active Projects') }}</p>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['active_projects'] }}</h3>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
        <i data-lucide="layout-grid" class="w-6 h-6"></i>
      </div>
    </div>

    <div
      class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <div>
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Open Tickets') }}</p>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['open_tickets'] }}</h3>
      </div>
      <div
        class="w-12 h-12 rounded-2xl bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-600">
        <i data-lucide="help-circle" class="w-6 h-6"></i>
      </div>
    </div>

    <div
      class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <div>
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Unpaid Invoices') }}</p>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['pending_invoices'] }}</h3>
      </div>
      <div class="w-12 h-12 rounded-2xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600">
        <i data-lucide="credit-card" class="w-6 h-6"></i>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Project Updates Feed -->
    <div
      class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
      <div class="p-6 border-b border-gray-50 dark:border-gray-800">
        <h3 class="text-lg font-black text-gray-900 dark:text-white">{{ __('Recent Updates') }}</h3>
      </div>
      <div class="p-6 space-y-8 relative pl-10">
        @forelse($recentUpdates as $update)
          <div class="relative">
            <div
              class="absolute -right-[33px] top-1.5 w-2.5 h-2.5 rounded-full bg-blue-600 border-4 border-white dark:border-gray-900 ring-4 ring-blue-500/10">
            </div>
            <div class="flex flex-col gap-1">
              <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $update->project->name }}</h4>
              <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $update->content }}</p>
              <span
                class="text-[10px] text-gray-400 font-bold uppercase mt-1">{{ $update->created_at->diffForHumans() }}</span>
            </div>
          </div>
        @empty
          <p class="text-center text-gray-400 italic py-10">{{ __('No updates yet.') }}</p>
        @endforelse
      </div>
    </div>

    <!-- Sidebar Actions -->
    <div class="space-y-6">
      <!-- Active Projects List -->
      <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">{{ __('My Projects') }}</h3>
        <div class="space-y-4">
          @forelse($activeProjects as $project)
            <div class="p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-800 group">
              <div class="flex items-center justify-between mb-2">
                <span
                  class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 transition-colors">{{ $project->name }}</span>
                <span class="text-[10px] font-black text-gray-400">{{ $project->progress }}%</span>
              </div>
              <div class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600"
                  style="width: {{ $project->progress }}%; background-color: {{ $project->color ?: '#3b82f6' }}"></div>
              </div>
            </div>
          @empty
            <p class="text-xs text-gray-400 italic">{{ __('No active projects.') }}</p>
          @endforelse
        </div>
      </div>

      <!-- Pending Invoices -->
      <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">{{ __('Latest Invoices') }}</h3>
        <div class="space-y-3">
          @forelse($unpaidInvoices as $inv)
            <div
              class="flex items-center justify-between py-2 border-b border-gray-50 dark:border-gray-800 last:border-0">
              <div>
                <p class="text-xs font-bold text-gray-900 dark:text-white">#{{ $inv->invoice_number }}</p>
                <p class="text-[10px] text-red-500 font-bold uppercase">{{ __('Due:') }}
                  {{ $inv->due_date->format('M d') }}</p>
              </div>
              <span class="text-sm font-black text-gray-900 dark:text-white">{{ number_format($inv->amount, 0) }}
                {{ $inv->currency }}</span>
            </div>
          @empty
            <p class="text-xs text-gray-400 italic">{{ __('No pending invoices.') }}</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>