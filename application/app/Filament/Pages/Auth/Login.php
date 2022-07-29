<?php

namespace App\Filament\Pages\Auth;

use App\Models\Shop\Shop;
use App\Services\CacheService;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class Login extends \Filament\Http\Livewire\Auth\Login
{
    public function mount(): void
    {

        if (Filament::auth()->check()) {

            CacheService::setAccountId(Auth::user()
                ->shops()
                ->where('active', true)
                ->first()->id);

            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill([
            'email' => 'admin@filamentphp.com',
            'password' => 'password',
            'remember' => true,
        ]);
    }

    public function render(): View
    {
        return view('filament.pages.login')
            ->layout('filament.components.login', [
                'title' => "Вход",
            ]);
    }
}
