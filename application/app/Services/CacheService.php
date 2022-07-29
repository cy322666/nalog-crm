<?php

namespace App\Services;

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

            redirect(route('filament.auth.login'));
        } else
            return $accountId;
    }
}
