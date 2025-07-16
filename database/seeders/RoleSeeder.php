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
        // Nonaktifkan Foreign Key Check untuk sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Kosongkan tabel. Sekarang ini aman untuk dijalankan.
        Role::truncate();

        // Aktifkan kembali Foreign Key Check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat data roles baru
        $roles = [
            [
                'nama' => 'Kepala PPM',
                'akses' => 'semua',
                'deskripsi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Koordinator KKN',
                'akses' => 'semua',
                'deskripsi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Admin',
                'akses' => 'semua',
                'deskripsi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Mahasiswa KKN',
                'akses' => 'semua',
                'deskripsi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dosen Pembimbing Lapangan',
                'akses' => 'semua',
                'deskripsi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Masukkan data ke dalam tabel 'roles'
        Role::insert($roles);
    }
}
