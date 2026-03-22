<x-error-layout
    code="503"
    title="{{ __('Service Unavailable') }}"
    icon="construction"
    label="{{ __('Maintenance Mode') }}"
    headerGradient="from-slate-600 to-slate-800"
    orb1Color="bg-slate-500/20"
    orb2Color="bg-slate-600/15"
    lineColor="to-slate-500/40"
    labelColor="text-slate-400/70"
    dotColor="bg-slate-400 shadow-slate-400/50"
    badgeClass="bg-slate-500/20 text-slate-300 border-slate-500/30"
>
    {{ $exception?->getMessage() ?: __('The application is currently down for scheduled maintenance. We will be back online shortly. Thank you for your patience.') }}
</x-error-layout>
