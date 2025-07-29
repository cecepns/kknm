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
            // ANCHOR: Add category_id column if it doesn't exist
            if (!Schema::hasColumn('knowledge', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('field_category');
                
                // ANCHOR: Add foreign key constraint
                $table->foreign('category_id')->references('id')->on('knowledge_categories')->onDelete('set null');
                
                // ANCHOR: Add index for better performance
                $table->index('category_id');
            }
        });
    }

    /**
     * ANCHOR: Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knowledge', function (Blueprint $table) {
            // ANCHOR: Drop foreign key and index
            $table->dropForeign(['category_id']);
            $table->dropIndex(['category_id']);
            
            // ANCHOR: Drop category_id column
            $table->dropColumn('category_id');
        });
    }
};
