<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function twoFactor(): HasOne
    {
        return $this->hasOne(AdminTwoFactor::class);
    }

    public function hasPermission(string $key): bool
    {
        if (!$this->role) {
            return false;
        }
        return $this->role->permissions()->where('key', $key)->exists();
    }

    public function isSuperAdmin(): bool
    {
        return $this->role && $this->role->name === 'Super Admin';
    }
}
