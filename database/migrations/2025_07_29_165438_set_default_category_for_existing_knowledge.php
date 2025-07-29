<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * ANCHOR: Run the migrations.
     */
    public function up(): void
    {
        // ANCHOR: Set default category (Pendidikan) for existing knowledge records that have null category_id
        DB::table('knowledge')
            ->whereNull('category_id')
            ->update(['category_id' => 1]); // Default to Pendidikan category
    }

    /**
     * ANCHOR: Reverse the migrations.
     */
    public function down(): void
    {
        // ANCHOR: Set category_id back to null for records that were updated
        // Note: This is a destructive operation, use with caution
        DB::table('knowledge')
            ->where('category_id', 1)
            ->update(['category_id' => null]);
    }
};
