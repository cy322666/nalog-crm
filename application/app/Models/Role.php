<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'shop_roles';

    protected $fillable = [
        'name',
        'guard_name',
        'is_system',
        'shop_id',
    ];

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class,'roles_permissions',  'role_id', 'permission_id');
    }
}
