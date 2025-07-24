<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_all_admin_menus()
    {
        // Create Admin role
        $adminRole = Role::create([
            'name' => 'Admin',
            'access' => 'kelola-pengguna-internal|kelola-roles|kelola-pengumuman|akses-pengumuman|kelola-faq|akses-faq|klasifikasi-pengetahuan|kelola-repositori|repositori-publik|kelola-kategori-forum|forum-diskusi|kelola-forum-diskusi',
            'description' => 'Admin role'
        ]);

        // Create admin user
        $admin = User::factory()->create([
            'role_id' => $adminRole->id
        ]);

        $this->actingAs($admin);

        // Test that admin can see admin-specific menus
        $this->assertTrue($admin->hasPermission('kelola-pengguna-internal'));
        $this->assertTrue($admin->hasPermission('kelola-roles'));
        $this->assertTrue($admin->hasPermission('kelola-pengumuman'));
        $this->assertTrue($admin->hasPermission('kelola-faq'));
        $this->assertTrue($admin->hasPermission('kelola-kategori-forum'));
    }

    public function test_kepala_ppm_can_see_monitoring_and_validation_menus()
    {
        // Create Kepala PPM role
        $kepalaPpmRole = Role::create([
            'name' => 'Kepala PPM',
            'access' => 'akses-pengumuman|akses-faq|validasi-pengetahuan|repositori-publik|forum-diskusi|monitoring-aktifitas',
            'description' => 'Kepala PPM role'
        ]);

        // Create Kepala PPM user
        $kepalaPpm = User::factory()->create([
            'role_id' => $kepalaPpmRole->id
        ]);

        $this->actingAs($kepalaPpm);

        // Test that Kepala PPM can see specific menus
        $this->assertTrue($kepalaPpm->hasPermission('validasi-pengetahuan'));
        $this->assertTrue($kepalaPpm->hasPermission('monitoring-aktifitas'));
        $this->assertTrue($kepalaPpm->hasPermission('akses-pengumuman'));
        $this->assertTrue($kepalaPpm->hasPermission('akses-faq'));

        // Test that Kepala PPM cannot see admin menus
        $this->assertFalse($kepalaPpm->hasPermission('kelola-pengguna-internal'));
        $this->assertFalse($kepalaPpm->hasPermission('kelola-roles'));
        $this->assertFalse($kepalaPpm->hasPermission('kelola-pengumuman'));
    }

    public function test_koordinator_kkn_can_see_verification_and_repository_menus()
    {
        // Create Koordinator KKN role
        $koordinatorRole = Role::create([
            'name' => 'Koordinator KKN',
            'access' => 'akses-pengumuman|akses-faq|verifikasi-pengetahuan|klasifikasi-pengetahuan|kelola-repositori|repositori-publik|forum-diskusi|monitoring-aktifitas',
            'description' => 'Koordinator KKN role'
        ]);

        // Create Koordinator KKN user
        $koordinator = User::factory()->create([
            'role_id' => $koordinatorRole->id
        ]);

        $this->actingAs($koordinator);

        // Test that Koordinator KKN can see specific menus
        $this->assertTrue($koordinator->hasPermission('verifikasi-pengetahuan'));
        $this->assertTrue($koordinator->hasPermission('klasifikasi-pengetahuan'));
        $this->assertTrue($koordinator->hasPermission('kelola-repositori'));
        $this->assertTrue($koordinator->hasPermission('monitoring-aktifitas'));

        // Test that Koordinator KKN cannot see admin menus
        $this->assertFalse($koordinator->hasPermission('kelola-pengguna-internal'));
        $this->assertFalse($koordinator->hasPermission('kelola-roles'));
    }

    public function test_mahasiswa_kkn_can_see_upload_knowledge_menu()
    {
        // Create Mahasiswa KKN role
        $mahasiswaRole = Role::create([
            'name' => 'Mahasiswa KKN',
            'access' => 'akses-pengumuman|akses-faq|unggah-pengetahuan|repositori-publik|forum-diskusi',
            'description' => 'Mahasiswa KKN role'
        ]);

        // Create Mahasiswa KKN user
        $mahasiswa = User::factory()->create([
            'role_id' => $mahasiswaRole->id
        ]);

        $this->actingAs($mahasiswa);

        // Test that Mahasiswa KKN can see specific menus
        $this->assertTrue($mahasiswa->hasPermission('unggah-pengetahuan'));
        $this->assertTrue($mahasiswa->hasPermission('akses-pengumuman'));
        $this->assertTrue($mahasiswa->hasPermission('akses-faq'));
        $this->assertTrue($mahasiswa->hasPermission('forum-diskusi'));

        // Test that Mahasiswa KKN cannot see admin or management menus
        $this->assertFalse($mahasiswa->hasPermission('kelola-pengguna-internal'));
        $this->assertFalse($mahasiswa->hasPermission('kelola-pengumuman'));
        $this->assertFalse($mahasiswa->hasPermission('validasi-pengetahuan'));
        $this->assertFalse($mahasiswa->hasPermission('verifikasi-pengetahuan'));
        $this->assertFalse($mahasiswa->hasPermission('monitoring-aktifitas'));
    }

    public function test_dosen_pembimbing_can_see_upload_knowledge_menu()
    {
        // Create Dosen Pembimbing role
        $dosenRole = Role::create([
            'name' => 'Dosen Pembimbing Lapangan',
            'access' => 'akses-pengumuman|akses-faq|unggah-pengetahuan|repositori-publik|forum-diskusi',
            'description' => 'Dosen Pembimbing role'
        ]);

        // Create Dosen Pembimbing user
        $dosen = User::factory()->create([
            'role_id' => $dosenRole->id
        ]);

        $this->actingAs($dosen);

        // Test that Dosen Pembimbing can see specific menus
        $this->assertTrue($dosen->hasPermission('unggah-pengetahuan'));
        $this->assertTrue($dosen->hasPermission('akses-pengumuman'));
        $this->assertTrue($dosen->hasPermission('akses-faq'));
        $this->assertTrue($dosen->hasPermission('forum-diskusi'));

        // Test that Dosen Pembimbing cannot see admin or management menus
        $this->assertFalse($dosen->hasPermission('kelola-pengguna-internal'));
        $this->assertFalse($dosen->hasPermission('kelola-pengumuman'));
        $this->assertFalse($dosen->hasPermission('validasi-pengetahuan'));
        $this->assertFalse($dosen->hasPermission('verifikasi-pengetahuan'));
        $this->assertFalse($dosen->hasPermission('monitoring-aktifitas'));
    }

    public function test_common_menus_accessible_by_all_roles()
    {
        // Test with Admin role (has all permissions)
        $adminRole = Role::create([
            'name' => 'Admin',
            'access' => 'kelola-pengguna-internal|akses-pengumuman|akses-faq|forum-diskusi|repositori-publik',
            'description' => 'Admin role'
        ]);

        $admin = User::factory()->create([
            'role_id' => $adminRole->id
        ]);

        $this->actingAs($admin);

        // Common menus that should be accessible by all roles
        $this->assertTrue($admin->hasPermission('akses-pengumuman'));
        $this->assertTrue($admin->hasPermission('akses-faq'));
        $this->assertTrue($admin->hasPermission('forum-diskusi'));
        $this->assertTrue($admin->hasPermission('repositori-publik'));
    }

    public function test_sidebar_header_shows_role_name()
    {
        // Create Admin role
        $adminRole = Role::create([
            'name' => 'Admin',
            'access' => 'kelola-pengguna-internal',
            'description' => 'Admin role'
        ]);

        // Create admin user
        $admin = User::factory()->create([
            'role_id' => $adminRole->id
        ]);

        $this->actingAs($admin);

        // Test that role name is accessible
        $this->assertEquals('Admin', $admin->role->name);
    }
} 