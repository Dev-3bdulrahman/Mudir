<div class="space-y-6">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-black text-gray-900 dark:text-white">{{ __('Visitor Log') }}</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Monitor real-time traffic and visitor behavior.') }}
      </p>
    </div>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">
      <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">{{ __('Total Visits') }}</p>
      <p class="text-3xl font-black text-gray-900 dark:text-white">{{ \App\Models\VisitorLog::count() }}</p>
    </div>
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">
      <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">{{ __('Today Visits') }}</p>
      <p class="text-3xl font-black text-blue-600">{{ \App\Models\VisitorLog::today()->count() }}</p>
    </div>
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">
      <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">{{ __('Unique Today') }}</p>
      <p class="text-3xl font-black text-purple-600">{{ \App\Models\VisitorLog::uniqueToday()->count() }}</p>
    </div>
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">
      <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">{{ __('Avg Pages/Visit') }}</p>
      @php
        $total = \App\Models\VisitorLog::count();
        $unique = \App\Models\VisitorLog::where('is_unique', true)->count();
        $avg = $unique > 0 ? round($total / $unique, 1) : 0;
      @endphp
      <p class="text-3xl font-black text-green-600">{{ $avg }}</p>
    </div>
  </div>

  <!-- Filters & List -->
  <div
    class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
    <div class="p-6 border-b border-gray-50 dark:border-gray-800">
      <div class="relative w-full md:w-96">
        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
        <input type="text" wire:model.live="search" placeholder="{{ __('Search by IP, Country, City...') }}"
          class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all dark:text-white">
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-right">
        <thead>
          <tr class="bg-gray-50/50 dark:bg-gray-800/10">
            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('IP Address') }}</th>
            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Location') }}</th>
            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">
              {{ __('Device / Browser') }}
            </th>
            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Visited Page') }}
            </th>
            <th class="px-6 py-4 text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
          @forelse($visitors as $v)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors group">
              <td class="px-6 py-4">
                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $v->ip_address }}</span>
                @if($v->is_unique)
                  <span
                    class="ml-2 px-2 py-0.5 bg-green-100 dark:bg-green-900/40 text-green-600 text-[10px] font-black rounded-full uppercase">{{ __('Unique') }}</span>
                @endif
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                  <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $v->country }},
                    {{ $v->city }}</span>
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                    @php
                      $deviceIcon = match ($v->device_type) {
                        'Mobile' => 'smartphone',
                        'Tablet' => 'tablet',
                        default => 'monitor'
                      };
                    @endphp
                    <i data-lucide="{{ $deviceIcon }}" class="w-4 h-4 text-gray-500"></i>
                  </div>
                  <div class="text-xs">
                    <p class="font-bold text-gray-900 dark:text-white">{{ $v->browser }}</p>
                    <p class="text-gray-500">{{ $v->platform }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 max-w-xs">
                <p class="text-xs text-blue-600 dark:text-blue-400 truncate font-mono" title="{{ $v->url }}">
                  {{ str_replace(url('/'), '', $v->url) ?: '/' }}
                </p>
              </td>
              <td class="px-6 py-4 text-xs text-gray-500">
                {{ $v->created_at->format('Y-m-d H:i') }}
                <p class="text-[10px] text-gray-400">{{ $v->created_at->diffForHumans() }}</p>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                {{ __('No visitor logs found.') }}
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($visitors->hasPages())
      <div class="p-6 border-t border-gray-50 dark:border-gray-800">
        {{ $visitors->links() }}
      </div>
    @endif
  </div>
</div>