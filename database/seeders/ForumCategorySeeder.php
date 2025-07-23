<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ForumCategory;
use Illuminate\Support\Facades\DB;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        ForumCategory::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            [
                'name' => 'Kegiatan',
                'description' => 'Kegiataan kkn',
                'topic_count' => 10,
                'created_by' => 3, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laporan',
                'description' => 'Laporan kkn',
                'topic_count' => 5,
                'created_by' => 3, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        ForumCategory::insert($categories);
    }
}
