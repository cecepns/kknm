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
            $table->string('title');
            $table->text('description');
            $table->text('additional_info')->nullable();
            
            // ANCHOR: KKN Information
            $table->string('kkn_type');
            $table->year('kkn_year');
            $table->enum('file_type', ['dokumen', 'presentasi', 'video', 'gambar', 'lainnya']);
            $table->enum('field_category', ['pendidikan', 'kesehatan', 'ekonomi', 'lingkungan', 'teknologi', 'sosial']);
            $table->string('kkn_location')->nullable();
            $table->integer('group_number')->nullable();
            
            // ANCHOR: File Information
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_mime_type');
            $table->bigInteger('file_size'); // in bytes
            
            // ANCHOR: Status and Approval
            $table->enum('status', ['pending', 'verified', 'validated', 'rejected'])->default('pending');
            $table->text('review_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            
            // ANCHOR: User Relationship
            $table->unsignedBigInteger('user_id');
            
            $table->timestamps();
            
            // ANCHOR: Indexes
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['status', 'created_at']);
            $table->index(['kkn_type', 'kkn_year']);
            $table->index(['field_category', 'kkn_location']);
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
