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
            // ANCHOR: Make category_id not nullable
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
        });
    }

    /**
     * ANCHOR: Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knowledge', function (Blueprint $table) {
            // ANCHOR: Make category_id nullable again
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });
    }
};
