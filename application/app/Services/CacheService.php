<?php

namespace App\Services;

use App\Filament\Pages\Auth\Login;
use App\Filament\Resources\Shop\ShopResource;
use App\Models\Shop\Shop;
use App\Services\Roles\RoleManager;
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

    public static function existAccount(): bool
    {
        return !empty(Cache::get('user_'.Auth::user()->id.'_account'));
    }

    public static function getAccountId()
    {
        if (Auth::user()) {

            $accountId = Cache::get('user_'.Auth::user()->id.'_account');

            if (!$accountId) {

                //redirect(ShopResource::getUrl());//route('filament.auth.login')
            } else
                return $accountId;
        } else {
//            redirect(env('APP_URL').'/login');
        }
    }

    public static function getAccount()
    {
        $accountId = Cache::get('user_'.Auth::user()->id.'_account');

        if ($accountId == null) {

            redirect(ShopResource::getUrl());
        } else {

            return Shop::query()
                ->find($accountId)
                ->first();//TODO debug
        }
    }

    public static function reset()
    {
        self::deleteAccountId();

        self::deleteRole();
    }

    public static function deleteRole()
    {
        Cache::forget('user_'.Auth::user()->id.'_role');
    }

    public static function setRole(string $role)
    {
        Cache::put('user_'.Auth::user()->id.'_role', $role);
    }

    public static function getRole()
    {
        $role = Cache::get('user_'.Auth::user()->id.'_role');

        if (!$role) {

            $role = RoleManager::map(CacheService::getAccount());

            self::setRole($role);
        }

        return $role;
    }
}
