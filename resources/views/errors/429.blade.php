<x-error-layout
    code="429"
    title="{{ __('Too Many Requests') }}"
    icon="zap-off"
    label="{{ __('Rate Limited') }}"
    headerGradient="from-purple-600 to-violet-700"
    orb1Color="bg-purple-600/20"
    orb2Color="bg-violet-600/15"
    lineColor="to-purple-500/40"
    labelColor="text-purple-400/70"
    dotColor="bg-purple-500 shadow-purple-500/50"
    badgeClass="bg-purple-500/20 text-purple-300 border-purple-500/30"
>
    {{ __('You have sent too many requests in a short period. Please wait a moment before trying again.') }}
</x-error-layout>
