<form wire:save.prevent="submit">

    {{ $this->form }}
{{--TODO отсуп--}}
    <div class="my-8">
        <button wire:click="save()" class="inline-flex items-center justify-center gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
            <span>Сохранить</span>
        </button>
    </div>
</form>
