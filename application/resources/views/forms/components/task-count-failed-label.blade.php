<x-forms::field-wrapper
    :id="$getId()"
    {{--    :label="$getLabel()"--}}
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <div class="relative p-6 rounded-2xl bg-white shadow filament-stats-card dark:bg-gray-800 filament-stats-overview-widget-card">
{{--            <div class="space-y-1">--}}
                <div class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-200">

                    <span>Просрочено раз</span>
                </div>

                <div class="text-2xl">
                    {{ $getLabel() }}
                </div>

{{--            </div>--}}
        </div>
    </div>
</x-forms::field-wrapper>
