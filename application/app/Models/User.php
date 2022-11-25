<?php

namespace App\Models;

use App\Models\Shop\Shop;
use App\Models\Shop\Task;
use App\Policies\Traits\HasRolesAndPermissions;
use App\Services\CacheService;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\HasDatabaseNotifications;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRolesAndPermissions;
    use HasDatabaseNotifications;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canAccessFilament(): bool
    {
        //TODO эт шо
        return true;
        //return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }

    public function shops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'responsible_id', 'id');
    }

    public function roles() : belongsToMany
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    public function role()
    {
        return $this
            ->belongsToMany(Role::class,'users_roles')
            ->where('shop_id', CacheService::getAccount()->id);
    }

    /**
     * @return mixed
     */
    public function permissions() : belongsToMany
    {
        return $this->belongsToMany(Permission::class,'shop_users_permissions');
    }

    public function isAdmin(): bool
    {
        return (bool)CacheService::getRole() == ('admin' || 'root');//TODO root?
    }

    public static function cacheAll()
    {
        $shop = CacheService::getAccount();

        $collections = Cache::get('users_shop_'.$shop->id);

        if (!$collections) {

            $collections = $shop->users;

            Cache::put('users_shop_'.$shop->id, $collections);
        }

        return $collections;
    }
}
