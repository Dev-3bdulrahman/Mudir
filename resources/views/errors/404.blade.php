<x-error-layout
    code="404"
    title="{{ __('Page Not Found') }}"
    icon="search-x"
    label="{{ __('Not Found') }}"
    headerGradient="from-blue-600 to-indigo-700"
    orb1Color="bg-blue-600/20"
    orb2Color="bg-indigo-600/15"
    lineColor="to-blue-500/40"
    labelColor="text-blue-400/70"
    dotColor="bg-blue-500 shadow-blue-500/50"
    badgeClass="bg-blue-500/20 text-blue-300 border-blue-500/30"
>
    {{ __('The page you are looking for could not be found. It may have been moved, deleted, or never existed.') }}
</x-error-layout>
