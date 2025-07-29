<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ANCHOR: Run the migrations.
     */
    public function up(): void
    {
        Schema::table('knowledge', function (Blueprint $table) {
            // ANCHOR: Remove field_category column if it exists
            if (Schema::hasColumn('knowledge', 'field_category')) {
                $table->dropColumn('field_category');
            }
        });
    }

    /**
     * ANCHOR: Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knowledge', function (Blueprint $table) {
            // ANCHOR: Add back field_category column
            $table->enum('field_category', ['pendidikan', 'kesehatan', 'ekonomi', 'lingkungan', 'teknologi', 'sosial'])->after('file_type');
        });
    }
};
