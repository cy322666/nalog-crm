<div wire:poll.30000ms>
<div x-data="{ isOpen: false }" class="relative">
    {{-- значок уведомлений --}}
    <button
        x-on:click="isOpen =! isOpen"
        @class([
            //значок уведомлений
            'flex items-center justify-center w-13 h-10'
        ])
    >
        <x-heroicon-o-bell class="h-5 -mr-1 align-text-top  @if($this->totalUnread) animate-swing @endif origin-top"></x-heroicon-o-bell>

        @if($this->totalUnread)
            <sup class="inline-flex items-center justify-center p-1 text-xs leading-none text-white bg-danger-600 rounded-full">
                {{ $this->totalUnread }}
            </sup>
        @endif
    </button>
    {{-- значок уведомлений --}}

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
            'absolute z-10 right-0 rtl:right-auto rtl:left-0 mt-2 shadow-xl bg-white rounded-md w-100 top-full',
            'dark:border-gray-600 dark:bg-gray-700' => config('filament.dark_mode'),
        ])
    >

        @if(!$notifications->isEmpty())
            <div @class([
                'py-3 px-3 space-y-3 overflow-hidden  rounded-md shadow-xl space-y-4',
                'dark:border-gray-600 w-80 dark:bg-gray-700' => config('filament.dark_mode'),
            ])style="width: 350px;">

            @foreach($notifications as $notification)
                <div @class([
                'relative h-16',
                ])>
                {{-- Заголовок --}}
                <div class="flex space-x-3 place-content-start h-8 mt-2">
{{--                    @php--}}
{{--                        $icon = match ($notification->level) {--}}
{{--                            'info'    => 'heroicon-o-information-circle',--}}
{{--                            'warning' => 'heroicon-o-exclamation-circle',--}}
{{--                            'error'   => 'heroicon-o-x-circle',--}}
{{--                            'success' => 'heroicon-o-check-circle',--}}
{{--                            'default' => 'heroicon-o-information-circle',--}}
{{--                        }--}}
{{--                    @endphp--}}

{{--                    <div>@svg($icon, ['class' => "w-6 space-x-2"])</div>--}}

                    {{-- Заголовок --}}
                    <div>{{ $notification->title }}</div>
                </div>
                    <small class="block px-1 text-lg font-normal"><a href="{{ $notification->link }}" style="color: cadetblue; font-size: medium">{{ $notification->message }}</a></small>
                </div>
            @endforeach
            </div>

            {{-- Кнопки --}}
            <div class="p-2">
                <button wire:click="notificationPage()" class="inline-flex items-center justify-center gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-500 hover:bg-gray-600 focus:bg-gray-500 focus:ring-offset-primary-700 filament-page-button-action">
                    <span>Все уведомления</span>
                </button>

                <button wire:click="reading()" class="inline-flex items-center justify-center gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 px-4 text-sm text-white shadow focus:ring-white border-transparent bg-black hover:bg-black-600 focus:bg-gray-500 focus:ring-offset-primary-700 filament-page-button-action">
                    <span>Прочитать</span>
                </button>
            </div>
            {{-- Кнопки --}}
        @else
            <div @class([
            'py-3 px-3 space-y-3 overflow-hidden  rounded-md shadow-xl space-y-4',
            'dark:border-gray-600 w-80 dark:bg-gray-700' => config('filament.dark_mode'),
            ]) style="width: 350px;">
                <p class="px-1.5 text-sm font-normal text-center">Нет уведомлений</p>
            </div>
            <div class="p-2">
                <button wire:click="notificationPage()" class="inline-flex items-center justify-center gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-500 hover:bg-gray-600 focus:bg-gray-500 focus:ring-offset-primary-700 filament-page-button-action">
                    <span>Все уведомления</span>
                </button>
            </div>
        @endif
    </div>
</div>
</div>
