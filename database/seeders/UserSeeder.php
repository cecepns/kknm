<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ANCHOR: Create internal users with custom IDs
        // Kepala PPM (role_id: 1)
        User::updateOrCreate(
            ['email' => 'kepala.ppm@kms.kkn'],
            [
                'name' => 'Kepala PPM',
                'password' => Hash::make('12345678'),
                'role_id' => 1,
                'account_type' => 'internal',
                'status' => 'aktif',
                'custom_id' => 'Kep001',
            ]
        );

        // Koordinator KKN (role_id: 2)
        User::updateOrCreate(
            ['email' => 'koordinator.kkn@kms.kkn'],
            [
                'name' => 'Koordinator KKN',
                'password' => Hash::make('12345678'),
                'role_id' => 2,
                'account_type' => 'internal',
                'status' => 'aktif',
                'custom_id' => 'Kor001',
            ]
        );

        // Admin (role_id: 3)
        User::updateOrCreate(
            ['email' => 'admin@kms.kkn'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'role_id' => 3,
                'account_type' => 'internal',
                'status' => 'aktif',
                'custom_id' => 'Adm001',
            ]
        );

        // ANCHOR: Create external users with custom IDs
        // Rocky (role_id: 4) - Mahasiswa KKN
        User::updateOrCreate(
            ['email' => 'rocky@kms.kkn'],
            [
                'name' => 'Rocky',
                'password' => Hash::make('12345678'),
                'role_id' => 4,
                'account_type' => 'eksternal',
                'status' => 'aktif',
                'custom_id' => 'Mah001',
                'faculty' => 'FISIP',
                'study_program' => 'pgmi',
                'batch_year' => 2022,
                'kkn_type' => 'reguler',
                'kkn_group_number' => 15,
                'kkn_location' => 'Subang Raya',
                'kkn_year' => 2025,
            ]
        );

        // Rocky Dosen (role_id: 5) - Dosen Pembimbing Lapangan
        User::updateOrCreate(
            ['email' => 'rockydosen@kms.kkn'],
            [
                'name' => 'Rocky Dosen',
                'password' => Hash::make('12345678'),
                'role_id' => 5,
                'account_type' => 'eksternal',
                'status' => 'aktif',
                'custom_id' => 'Dos001',
                'employee_id' => '122332344',
                'faculty' => 'FST',
                'study_program' => 'pkim',
            ]
        );
    }
}
