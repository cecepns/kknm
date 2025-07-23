<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Rename columns in roles table using raw SQL
        DB::statement('ALTER TABLE roles CHANGE nama name VARCHAR(255)');
        DB::statement('ALTER TABLE roles CHANGE akses access TEXT');
        DB::statement('ALTER TABLE roles CHANGE deskripsi description VARCHAR(255)');

        // Rename columns in users table using raw SQL
        DB::statement('ALTER TABLE users CHANGE nama name VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE tipe_akun account_type ENUM("eksternal", "internal")');
        DB::statement('ALTER TABLE users CHANGE nim student_id VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE nip_nidn employee_id VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE fakultas faculty VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE program_studi study_program VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE angkatan batch_year VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE jenis_kkn kkn_type VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE no_kelompok_kkn kkn_group_number VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE lokasi_kkn kkn_location VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE tahun_kkn kkn_year VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert columns in roles table using raw SQL
        DB::statement('ALTER TABLE roles CHANGE name nama VARCHAR(255)');
        DB::statement('ALTER TABLE roles CHANGE access akses TEXT');
        DB::statement('ALTER TABLE roles CHANGE description deskripsi VARCHAR(255)');

        // Revert columns in users table using raw SQL
        DB::statement('ALTER TABLE users CHANGE name nama VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE account_type tipe_akun ENUM("eksternal", "internal")');
        DB::statement('ALTER TABLE users CHANGE student_id nim VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE employee_id nip_nidn VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE faculty fakultas VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE study_program program_studi VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE batch_year angkatan VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE kkn_type jenis_kkn VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE kkn_group_number no_kelompok_kkn VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE kkn_location lokasi_kkn VARCHAR(255)');
        DB::statement('ALTER TABLE users CHANGE kkn_year tahun_kkn VARCHAR(255)');
    }
};
