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
        Schema::create('forum_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Kategori
            $table->text('description')->nullable(); // Deskripsi
            $table->integer('topic_count')->default(0); // Jumlah Topik
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Dibuat oleh siapa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_categories');
    }
};
