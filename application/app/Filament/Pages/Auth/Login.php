<?php

namespace App\Filament\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Http\Livewire\Auth\Login as BasePage;
use Illuminate\Contracts\View\View;

class Login extends \Filament\Http\Livewire\Auth\Login
{
    public function mount(): void
    {
        if (Filament::auth()->check()) {

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
