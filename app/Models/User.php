<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN   = 'admin';
    public const ROLE_PENJUAL = 'penjual';
    public const ROLE_USER    = 'user';

    public const ROLES = [self::ROLE_ADMIN, self::ROLE_PENJUAL, self::ROLE_USER];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Laravel 11+ (untuk Laravel 10 pindahkan ke properti $casts)
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function isAdmin(): bool   { return $this->role === self::ROLE_ADMIN; }
    public function isPenjual(): bool { return $this->role === self::ROLE_PENJUAL; }
    public function isUser(): bool    { return $this->role === self::ROLE_USER; }

    /** Nama route dashboard sesuai role */
    public function dashboardRoute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN   => 'admin.dashboard',
            self::ROLE_PENJUAL => 'penjual.dashboard',
            default            => 'user.dashboard',
        };
    }
}