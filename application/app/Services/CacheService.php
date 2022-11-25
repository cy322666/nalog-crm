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

    public static function deleteAccount()
    {
        Cache::forget('user_'.Auth::user()->id.'_account');
    }

    public static function existAccount(): bool
    {
        return !empty(Cache::get('user_'.Auth::user()->id.'_account'));
    }

    public static function setAccount(Shop $shop)
    {
        Cache::put('user_'.Auth::user()->id.'_account', $shop);
    }

    public static function getAccount()
    {
        $shop = Cache::get('user_'.Auth::user()->id.'_account');

        if ($shop !== null) {

            return $shop;
        }

        redirect(ShopResource::getUrl());
    }

    public static function reset()
    {
        self::deleteAccount();

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
