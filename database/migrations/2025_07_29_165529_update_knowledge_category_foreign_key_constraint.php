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
            // ANCHOR: Drop existing foreign key constraint
            $table->dropForeign(['category_id']);
            
            // ANCHOR: Re-add foreign key constraint with proper settings
            $table->foreign('category_id')
                  ->references('id')
                  ->on('knowledge_categories')
                  ->onDelete('restrict'); // Change from 'set null' to 'restrict'
        });
    }

    /**
     * ANCHOR: Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knowledge', function (Blueprint $table) {
            // ANCHOR: Drop foreign key constraint
            $table->dropForeign(['category_id']);
            
            // ANCHOR: Re-add original foreign key constraint
            $table->foreign('category_id')
                  ->references('id')
                  ->on('knowledge_categories')
                  ->onDelete('set null');
        });
    }
};
