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
                'name' => 'Kategori 1',
                'description' => 'Deskripsi kategori 1',
                'topic_count' => 10,
                'created_by' => 3, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kategori 2',
                'description' => 'Deskripsi kategori 2',
                'topic_count' => 5,
                'created_by' => 3, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kategori 3',
                'description' => 'Deskripsi kategori 3',
                'topic_count' => 15,
                'created_by' => 3, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        ForumCategory::insert($categories);
    }
}
