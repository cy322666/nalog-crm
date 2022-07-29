{{-- Injected variables $status, $styles --}}
<div class="{{ $styles['kanbanWrapper'] }}">

        @include($kanbanHeaderView, [
            'status' => $status
        ])
    <div class="{{ $styles['kanban'] }} {{ $status['color'] }}" id="{{ $status['id'] }}">
        <div
            id="{{ $status['kanbanRecordsId'] }}"
            data-status-id="{{ $status['id'] }}"
            class="{{ $styles['kanbanRecords'] }}">

            @foreach($status['records'] as $record)
                @include($recordView, [
                    'record' => $record,
                ])
            @endforeach

        </div>

        @include($kanbanFooterView, [
            'status' => $status
        ])

    </div>
</div>
