<x-forms::field-wrapper
    :id="$getId()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    @php
        $service = new \App\Services\TaskService($this->getRecord());
    @endphp

    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">

{{--            <span>{{ $service->label }}</span>--}}
            <span>{{ $service->text }}</span>

        <div class="text-lg text-{{$service->color}}-500">
            {{ $service->label }}
        </div>
    </div>
</x-forms::field-wrapper>
