<x-error-layout
    code="419"
    title="{{ __('Page Expired') }}"
    icon="clock-alert"
    label="{{ __('Session Expired') }}"
    headerGradient="from-yellow-600 to-orange-600"
    orb1Color="bg-yellow-600/20"
    orb2Color="bg-orange-600/15"
    lineColor="to-yellow-500/40"
    labelColor="text-yellow-400/70"
    dotColor="bg-yellow-500 shadow-yellow-500/50"
    badgeClass="bg-yellow-500/20 text-yellow-300 border-yellow-500/30"
>
    {{ __('Your session has expired due to inactivity. Please refresh the page and try again.') }}
</x-error-layout>
