<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KnowledgeCategory;

class KnowledgeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Pendidikan'],
            ['name' => 'Kesehatan'],
            ['name' => 'Ekonomi'],
            ['name' => 'Lingkungan'],
            ['name' => 'Teknologi'],
            ['name' => 'Sosial'],
            ['name' => 'Test Category for Delete'], // Test category
        ];

        foreach ($categories as $category) {
            KnowledgeCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
