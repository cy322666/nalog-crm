<?php

namespace App\Services;

use App\Services\Roles\RoleManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public static function reset()
    {
//        self::deleteAccount();

//        self::deleteRole();
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

            $role = RoleManager::map();

            self::setRole($role);
        }

        return $role;
    }
}
