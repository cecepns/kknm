<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_route_with_permission()
    {
        // Create role with permission
        $role = Role::create([
            'name' => 'Test Role',
            'access' => 'kelola-pengguna-internal',
            'description' => 'Test role'
        ]);

        // Create user with role
        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        $this->actingAs($user);

        // Test access to protected route
        $response = $this->get('/kelola-pengguna-internal');
        $response->assertStatus(200);
    }

    public function test_user_cannot_access_route_without_permission()
    {
        // Create role without permission
        $role = Role::create([
            'name' => 'Test Role',
            'access' => 'akses-faq',
            'description' => 'Test role'
        ]);

        // Create user with role
        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        $this->actingAs($user);

        // Test access to protected route
        $response = $this->get('/kelola-pengguna-internal');
        $response->assertStatus(403);
    }

    public function test_user_has_permission_method()
    {
        // Create role with permission
        $role = Role::create([
            'name' => 'Test Role',
            'access' => 'kelola-pengguna-internal|akses-faq',
            'description' => 'Test role'
        ]);

        // Create user with role
        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        // Test permission methods
        $this->assertTrue($user->hasPermission('kelola-pengguna-internal'));
        $this->assertTrue($user->hasPermission('akses-faq'));
        $this->assertFalse($user->hasPermission('invalid-permission'));
    }

    public function test_user_has_any_permission_method()
    {
        // Create role with permission
        $role = Role::create([
            'name' => 'Test Role',
            'access' => 'kelola-pengguna-internal',
            'description' => 'Test role'
        ]);

        // Create user with role
        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        // Test hasAnyPermission method
        $this->assertTrue($user->hasAnyPermission(['kelola-pengguna-internal', 'akses-faq']));
        $this->assertFalse($user->hasAnyPermission(['invalid-permission', 'another-invalid']));
    }

    public function test_user_has_all_permissions_method()
    {
        // Create role with permissions
        $role = Role::create([
            'name' => 'Test Role',
            'access' => 'kelola-pengguna-internal|akses-faq',
            'description' => 'Test role'
        ]);

        // Create user with role
        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        // Test hasAllPermissions method
        $this->assertTrue($user->hasAllPermissions(['kelola-pengguna-internal', 'akses-faq']));
        $this->assertFalse($user->hasAllPermissions(['kelola-pengguna-internal', 'invalid-permission']));
    }

    public function test_user_get_permissions_method()
    {
        // Create role with permissions
        $role = Role::create([
            'name' => 'Test Role',
            'access' => 'kelola-pengguna-internal|akses-faq|forum-diskusi',
            'description' => 'Test role'
        ]);

        // Create user with role
        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        // Test getPermissions method
        $permissions = $user->getPermissions();
        $this->assertCount(3, $permissions);
        $this->assertContains('kelola-pengguna-internal', $permissions);
        $this->assertContains('akses-faq', $permissions);
        $this->assertContains('forum-diskusi', $permissions);
    }

    public function test_user_without_role_has_no_permissions()
    {
        // Create role without permissions
        $role = Role::create([
            'name' => 'No Permission Role',
            'access' => '',
            'description' => 'Role without any permissions'
        ]);

        // Create user with role that has no permissions
        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        // Test permission methods
        $this->assertFalse($user->hasPermission('kelola-pengguna-internal'));
        $this->assertFalse($user->hasAnyPermission(['kelola-pengguna-internal', 'akses-faq']));
        $this->assertFalse($user->hasAllPermissions(['kelola-pengguna-internal', 'akses-faq']));
        $this->assertEmpty($user->getPermissions());
    }
} 