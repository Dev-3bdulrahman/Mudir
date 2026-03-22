<x-error-layout
    code="500"
    title="{{ __('Server Error') }}"
    icon="server-crash"
    label="{{ __('Internal Error') }}"
    headerGradient="from-red-700 to-rose-800"
    orb1Color="bg-red-700/20"
    orb2Color="bg-rose-600/15"
    lineColor="to-red-500/40"
    labelColor="text-red-400/70"
    dotColor="bg-red-500 shadow-red-500/50"
    badgeClass="bg-red-500/20 text-red-300 border-red-500/30"
>
    {{ __('An unexpected error occurred on the server. Our team has been notified. Please try again in a few moments.') }}
</x-error-layout>
