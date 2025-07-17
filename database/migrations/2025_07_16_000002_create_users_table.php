<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');

            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->enum('tipe_akun', ['eksternal', 'internal']);
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');

            $table->string('nim')->unique()->nullable();
            $table->string('nip_nidn')->unique()->nullable();

            $table->string('fakultas')->nullable();
            $table->string('program_studi')->nullable();

            $table->string('angkatan')->nullable();
            $table->string('jenis_kkn')->nullable();
            $table->string('no_kelompok_kkn')->nullable();
            $table->string('lokasi_kkn')->nullable();
            $table->string('tahun_kkn')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
