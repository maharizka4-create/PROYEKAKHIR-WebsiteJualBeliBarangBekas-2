<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        foreach (User::ROLES as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $accounts = [
            ['Admin',   'admin@example.com',   User::ROLE_ADMIN],
            ['Penjual', 'penjual@example.com', User::ROLE_PENJUAL],
            ['User',    'user@example.com',    User::ROLE_USER],
        ];

        foreach ($accounts as [$name, $email, $role]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'      => $name,
                    'password'  => 'password',
                    'is_active' => true,
                ]
            );

            $user->syncRoles($role);
        }
    }
}