<x-error-layout
    code="403"
    title="{{ __('Access Forbidden') }}"
    icon="shield-off"
    label="{{ __('Access Denied') }}"
    headerGradient="from-orange-600 to-red-700"
    orb1Color="bg-orange-600/20"
    orb2Color="bg-red-600/15"
    lineColor="to-orange-500/40"
    labelColor="text-orange-400/70"
    dotColor="bg-orange-500 shadow-orange-500/50"
    badgeClass="bg-orange-500/20 text-orange-300 border-orange-500/30"
>
    {{ $exception?->getMessage() ?: __('You do not have permission to access this page. Please contact your administrator if you believe this is a mistake.') }}
</x-error-layout>
