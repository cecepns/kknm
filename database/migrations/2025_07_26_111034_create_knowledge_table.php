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
        Schema::create('knowledge', function (Blueprint $table) {
            $table->id();
            
            // ANCHOR: Basic Information
            $table->string('judul');
            $table->text('deskripsi');
            $table->text('informasi_tambahan')->nullable();
            
            // ANCHOR: KKN Information
            $table->string('jenis_kkn');
            $table->year('tahun_kkn');
            $table->enum('jenis_file', ['dokumen', 'presentasi', 'video', 'gambar', 'lainnya']);
            $table->enum('kategori_bidang', ['pendidikan', 'kesehatan', 'ekonomi', 'lingkungan', 'teknologi', 'sosial']);
            $table->string('lokasi_kkn');
            $table->integer('nomor_kelompok');
            
            // ANCHOR: File Information
            $table->string('nama_file');
            $table->string('path_file');
            $table->string('tipe_file');
            $table->bigInteger('ukuran_file'); // in bytes
            
            // ANCHOR: Status and Approval
            $table->enum('status', ['pedding', 'verified', 'validated', 'classified', 'rejected'])->default('pedding');
            $table->text('catatan_review')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            
            // ANCHOR: User Relationship
            $table->unsignedBigInteger('user_id');
            
            $table->timestamps();
            
            // ANCHOR: Indexes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['status', 'created_at']);
            $table->index(['jenis_kkn', 'tahun_kkn']);
            $table->index(['kategori_bidang', 'lokasi_kkn']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge');
    }
};
