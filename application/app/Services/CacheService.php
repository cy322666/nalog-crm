<?php

namespace App\Services;

use App\Filament\Resources\Shop\ShopResource;
use App\Models\Shop\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public static function setAccountId(int $accountId)
    {
        Cache::put('user_'.Auth::user()->id.'_account', $accountId);
    }

    public static function deleteAccountId()
    {
        Cache::forget('user_'.Auth::user()->id.'_account');
    }

    public static function getAccountId()
    {
        $accountId = Cache::get('user_'.Auth::user()->id.'_account');

        if (!$accountId) {

            redirect(ShopResource::getUrl());//route('filament.auth.login')
        } else
            return $accountId;
    }

    public static function getAccount()
    {
        $accountId = Cache::get('user_'.Auth::user()->id.'_account');

        if (!$accountId) {

            redirect(ShopResource::getUrl());
        }

        return Shop::query()
            ->find($accountId)
            ->first();//TODO debug
    }

    public static function getRole()
    {
//        Cache::put('user_'.Auth::user()->id.'_role', 'root');
        return Cache::get('user_'.Auth::user()->id.'_role');
    }
}
