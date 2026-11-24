<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['Admin',   'admin@example.com',   User::ROLE_ADMIN],
            ['Penjual', 'penjual@example.com', User::ROLE_PENJUAL],
            ['User',    'user@example.com',    User::ROLE_USER],
        ];

        foreach ($accounts as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name'      => $name,
                    'password'  => 'password',
                    'role'      => $role,
                    'is_active' => true,
                ]
            );
        }
    }
}