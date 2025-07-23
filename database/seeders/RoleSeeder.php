<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Role::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Define all available permissions
        $permissions = [
            'kelola-pengguna-internal',
            'kelola-roles',
            'kelola-pengumuman',
            'akses-pengumuman',
            'kelola-faq',
            'akses-faq',
            'klasifikasi-pengetahuan',
            'kelola-repositori',
            'repositori-publik',
            'kelola-katergori-forum',
            'forum-diskusi',
            'kelola-forum-diskusi',
            'validasi-pengetahuan',
            'verifikasi-pengetahuan',
            'unggah-pengetahuan',
            'monitoring-aktifitas',
        ];

        // Helper function to create access string from permission array
        $createAccess = function(array $perms) use ($permissions) {
            return implode('|', $perms);
        };

        // Define role permissions
        $rolePermissions = [
            'Kepala PPM' => [
                'akses-pengumuman',
                'akses-faq',
                'validasi-pengetahuan',
                'repositori-publik',
                'forum-diskusi',
                'monitoring-aktifitas',
            ],
            'Koordinator KKN' => [
                'akses-pengumuman',
                'akses-faq',
                'verifikasi-pengetahuan',
                'klasifikasi-pengetahuan',
                'kelola-repositori',
                'repositori-publik',
                'forum-diskusi',
                'monitoring-aktifitas',
            ],
            'Admin' => [
                'kelola-pengguna-internal',
                'kelola-roles',
                'kelola-pengumuman',
                'akses-pengumuman',
                'kelola-faq',
                'akses-faq',
                'klasifikasi-pengetahuan',
                'kelola-repositori',
                'repositori-publik',
                'kelola-katergori-forum',
                'forum-diskusi',
                'kelola-forum-diskusi',
            ],
            'Mahasiswa KKN' => [
                'akses-pengumuman',
                'akses-faq',
                'unggah-pengetahuan',
                'repositori-publik',
                'forum-diskusi',
            ],
            'Dosen Pembimbing Lapangan' => [
                'akses-pengumuman',
                'akses-faq',
                'unggah-pengetahuan',
                'repositori-publik',
                'forum-diskusi',
            ],
        ];

        // Build roles array
        $roles = [];
        foreach ($rolePermissions as $roleName => $perms) {
            $roles[] = [
                'name' => $roleName,
                'access' => $createAccess($perms),
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Role::insert($roles);
    }
}
