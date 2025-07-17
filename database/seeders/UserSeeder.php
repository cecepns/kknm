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
        User::updateOrCreate(
            ['email' => 'admin@kms.kkn'],
            [
                'nama' => 'Admin',
                'password' => Hash::make('admin123456'),
                'role_id' => 3,
                'tipe_akun' => 'internal',
                'status' => 'aktif',
            ]
        );
    }
}
