<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Bersihkan cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Pastikan seluruh role tersedia
        foreach (User::ROLES as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
    }

    public function test_new_users_can_register_as_buyer(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Buyer',
            'email' => 'buyer@example.com',
            'phone' => '081234567890',
            'role' => User::ROLE_USER,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::where('email', 'buyer@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue((bool) $user->is_active);
        $this->assertTrue($user->hasRole(User::ROLE_USER));
        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(
            route('user.dashboard', absolute: false)
        );
    }

    public function test_new_users_can_register_as_seller(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Seller',
            'email' => 'seller@example.com',
            'phone' => '081234567891',
            'role' => User::ROLE_PENJUAL,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::where('email', 'seller@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue((bool) $user->is_active);
        $this->assertTrue($user->hasRole(User::ROLE_PENJUAL));
        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(
            route('penjual.dashboard', absolute: false)
        );
    }

    public function test_admin_cannot_register_through_public_form(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Admin',
            'email' => 'admin-public@example.com',
            'role' => User::ROLE_ADMIN,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', [
            'email' => 'admin-public@example.com',
        ]);
    }
}