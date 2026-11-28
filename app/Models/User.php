<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public const ROLE_ADMIN   = 'admin';
    public const ROLE_PENJUAL = 'penjual';
    public const ROLE_PEMBELI = 'pembeli';
    public const ROLE_USER    = 'user';

    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_PENJUAL,
        self::ROLE_PEMBELI,
        self::ROLE_USER,
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function isAdmin(): bool   { return $this->hasRole(self::ROLE_ADMIN); }
    public function isPenjual(): bool { return $this->hasRole(self::ROLE_PENJUAL); }
    public function isUser(): bool    { return $this->hasRole(self::ROLE_USER); }

    /** Nama route dashboard sesuai role */
    public function dashboardRoute(): string
    {
        return match (true) {
            $this->hasRole(self::ROLE_ADMIN)   => 'admin.dashboard',
            $this->hasRole(self::ROLE_PENJUAL) => 'penjual.dashboard',
            default                            => 'user.dashboard',
        };
    }
}