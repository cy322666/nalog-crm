{{-- Injected variables $record, $styles --}}
<div
    id="{{ $record['id'] }}"
    @if($recordClickEnabled)
    wire:click="onRecordClick('{{ $record['id'] }}')"
    @endif
    class="{{ $styles['record'] }} ">

    @include($recordContentView, [
        'record' => $record,
        'styles' => $styles,
    ])

</div>


{{--<div class="relative p-6 rounded-2xl bg-white filament-stats-card dark:bg-gray-800 filament-stats-overview-widget-card">--}}
{{--    <div class="space-y-1">--}}
{{--        <div class="flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-200">--}}

{{--            <span>{{$record['title']}}</span>--}}
{{--        </div>--}}

{{--        <div class="text-3xl">--}}
{{--            2--}}
{{--        </div>--}}

{{--    </div>--}}

{{--</div>--}}
