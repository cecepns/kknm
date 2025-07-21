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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id(); // Kolom ID primary key otomatis
            $table->string('title'); // Kolom untuk judul pengumuman
            $table->longText('content'); // Kolom untuk isi konten, bisa sangat panjang
            $table->date('published_date')->nullable(); // Kolom tanggal publikasi, boleh kosong
            
            // Kolom untuk mencatat siapa yang membuat, terhubung ke tabel 'users'
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
