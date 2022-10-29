<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Resources\Shop\ShopResource;
use App\Models\Shop\Shop;
use App\Services\CacheService;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class Login extends \JeffGreco13\FilamentBreezy\Http\Livewire\Auth\Login
{
    public function mount(): void
    {
        parent::mount();

        if ($login = request()->query($this->loginColumn, "")) {

            dd(__METHOD__);

            $this->form->fill([$this->loginColumn => $login]);
        }
        if (request()->query("reset")) {

            dd(__METHOD__);

            $this->notify("success", __("passwords.reset"), true);
        }

        if (Auth::user()) {

            if (CacheService::getAccountId() === null) {

                redirect(ShopResource::getUrl());
            }
        }


//        //TODO эт че
//        if (Filament::auth()->check()) {
//
////            $shops = Auth::user()->shops();
////
////            if ($shops->count() > 1) {
////
////
////            }
//
////            CacheService::setAccountId(1);
//
//            CacheService::setAccountId(Auth::user()
//                ->shops()
//                ->where('active', true)
//                ->first()->id);
//
//            redirect()->intended(Filament::getUrl());
//        }
//
//        $this->form->fill([
//            'email' => 'admin@filamentphp.com',
//            'password' => 'password',
//            'remember' => true,
//        ]);
    }

//    public function render(): View
//    {
//        return view('filament.pages.login')
//            ->layout('filament.components.login', [
//                'title' => "Вход",
//            ]);
//    }
}



//CacheService::setAccountId(Auth::user()
//    ->shops()
//    ->where('active', true)
//    ->first()->id);
//
//redirect()->intended(Filament::getUrl());
