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
        // Kepala PPM (role_id: 1)
        User::updateOrCreate(
            ['email' => 'kepala.ppm@kms.kkn'],
            [
                'name' => 'Kepala PPM',
                'password' => Hash::make('12345678'),
                'role_id' => 1,
                'account_type' => 'internal',
                'status' => 'aktif',
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
            ]
        );
    }
}
