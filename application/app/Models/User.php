<?php

namespace App\Models;

use App\Models\Shop\Notification;
use App\Models\Shop\Shop;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

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
        return true;
        //return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }

    public function shops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class);
    }

    public function notifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this
            ->hasMany(Notification::class, 'notifiable_id', 'id')
            ->where('notifiable_type', __CLASS__);
    }

    public function unreadNotifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this
            ->hasMany(Notification::class, 'notifiable_id', 'id')
            ->where('notifiable_type', __CLASS__)
            ->where('is_read', false);
    }
}
