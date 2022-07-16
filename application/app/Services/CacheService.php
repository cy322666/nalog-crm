<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public static function setAccountId(int $accountId)
    {
        Cache::put('user_'.Auth::user()?->id.'_account', $accountId);
    }

    public static function getAccountId()
    {
        return Cache::get('user_'.Auth::user()?->id.'_account');
    }
}
