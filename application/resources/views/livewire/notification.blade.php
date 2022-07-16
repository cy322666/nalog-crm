<div x-data="{ isOpen: false }" class="relative">
    <button
        x-on:click="isOpen =! isOpen"
        @class([
        //значок уведомлений позиционирование
            'flex items-center justify-center w-13 h-10 '
        ])
    >
        <x-heroicon-o-bell class="h-5 -mr-1 align-text-top  @if($this->totalUnread) animate-swing @endif origin-top"></x-heroicon-o-bell>

        @if($this->totalUnread)
            <sup class="inline-flex items-center justify-center p-1 text-xs leading-none text-white bg-danger-600 rounded-full">
                {{ $this->totalUnread }}
            </sup>
        @endif
    </button>

    <div
        x-show="isOpen"
        x-on:click.away="isOpen = false"
        x-transition:enter="transition"
        x-transition:enter-start="-translate-y-1 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-1 opacity-0"
        x-cloak
        @class([
        'absolute z-10 right-0 rtl:right-auto rtl:left-0 mt-2 shadow-xl bg-white rounded-xl w-100 top-full',
        'dark:border-gray-600 dark:bg-gray-700' => config('filament.dark_mode'),
    ])
    >
        @if(!$notifications->isEmpty())
            <ul @class([
        'py-3 px-2 space-y-3 overflow-hidden divide-y divide-gray-300 ',
        'dark:border-gray-600 w-80 dark:bg-gray-300' => config('filament.dark_mode'),
    ])style="width: 350px;">

        @foreach($notifications as $notification)
            <li @class([
            'relative',
            $notification->read() ? 'opacity-50' : '',
            ])>
                <div class="flex items-center w-full h-12 px-1.5 text-sm font-bold" style="font-size: medium">
                    @php
                        $icon = match ($notification->level) {
                            'info'    => 'heroicon-o-information-circle',
                            'warning' => 'heroicon-o-exclamation-circle',
                            'error'   => 'heroicon-o-x-circle',
                            'success' => 'heroicon-o-check-circle',
                        }
                    @endphp
                    @svg($icon, ['class' => 'mr-2 -ml-1 rtl:ml-2 rtl:-mr-1 w-6 h-6 text-gray-500'])

                    {{ $notification->title }}
                </div>
                <small class="block px-1.5 text-sm font-normal"><a href="{{ $notification->link }}" style="color: cadetblue; font-size: medium">{{ $notification->message }}</a></small>
            </li>
                @endforeach
            </ul>
{{--            <div class="p-2">--}}
{{--                <x-filament-notification.button-action--}}
{{--                    wire:click="markAllAsRead"--}}
{{--                    :color="config('filament-notification.buttons.markAllRead.color', 'primary')"--}}
{{--                    :outlined="config('filament-notification.buttons.markAllRead.outlined', false)"--}}
{{--                    :icon="config('filament-notification.buttons.markAllRead.icon', 'filament-notification::icon-check-all')"--}}
{{--                    :size="config('filament-notification.buttons.markAllRead.size', 'sm')"--}}
{{--                    class="w-full mt-2 h-8"--}}
{{--                >--}}
{{--                    {{ trans('filament-notification::component.buttons.markAllRead') }}--}}
{{--                </x-filament-notification.button-action>--}}
{{--            </div>--}}
        @else

            <div class="flex items-center w-full h-12 px-1.5 text-sm font-medium">
                <p class="px-1.5 text-sm font-normal text-center">Нет уведомлений</p>
            </div>
        @endif
    </div>
</div>
