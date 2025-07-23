<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ForumDiscussion;
use App\Models\ForumComment;
use App\Models\User;
use App\Models\ForumCategory;

class ForumDiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and categories
        $users = User::all();
        $categories = ForumCategory::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->info('Users or categories not found. Please run UserSeeder and ForumCategorySeeder first.');
            return;
        }

        // Sample discussions
        $discussions = [
            [
                'title' => 'Diskusi tentang kegiatan sosial di desa',
                'content' => 'Mari kita bahas kegiatan sosial apa saja yang bisa kita lakukan di desa ini. Saya punya beberapa ide, tapi saya ingin mendengar masukan dari teman-teman juga.',
                'category_name' => 'Kegiatan',
                'author_name' => 'Amelia Surya',
                'comments' => [
                    [
                        'content' => 'Saya setuju dengan ide kegiatan sosial. Mungkin kita bisa mulai dengan survei kecil untuk mengetahui kebutuhan masyarakat desa.',
                        'author_name' => 'Budi Santoso'
                    ],
                    [
                        'content' => 'Ide bagus, Budi! Survei bisa membantu kita merencanakan kegiatan yang tepat sasaran.',
                        'author_name' => 'Citra Dewi'
                    ],
                    [
                        'content' => 'Saya punya beberapa ide kegiatan, seperti pelatihan keterampilan, penyuluhan kesehatan, atau kegiatan lingkungan.',
                        'author_name' => 'Dimas Pratama'
                    ]
                ]
            ],
            [
                'title' => 'Laporan kegiatan KKN untuk bulan April',
                'content' => 'Berikut adalah laporan lengkap kegiatan KKN yang telah dilaksanakan selama bulan April. Semua kegiatan berjalan sesuai rencana dan mendapat respon positif dari masyarakat.',
                'category_name' => 'Laporan',
                'author_name' => 'Budi Santoso',
                'comments' => []
            ],
            [
                'title' => 'Ide kegiatan KKN yang menarik',
                'content' => 'Saya ingin berbagi beberapa ide kegiatan KKN yang menurut saya menarik dan bermanfaat untuk masyarakat. Bagaimana menurut teman-teman?',
                'category_name' => 'Kegiatan',
                'author_name' => 'Citra Dewi',
                'comments' => []
            ],
            [
                'title' => 'Diskusi tentang laporan keuangan KKN',
                'content' => 'Mari kita diskusikan tentang pengelolaan keuangan KKN dan bagaimana cara membuat laporan keuangan yang transparan dan akurat.',
                'category_name' => 'Laporan',
                'author_name' => 'Dimas Pratama',
                'comments' => []
            ],
            [
                'title' => 'Kegiatan KKN yang telah dilaksanakan',
                'content' => 'Berikut adalah ringkasan kegiatan KKN yang telah berhasil dilaksanakan selama periode ini. Semua kegiatan mendapat dukungan penuh dari masyarakat.',
                'category_name' => 'Kegiatan',
                'author_name' => 'Eka Putri',
                'comments' => []
            ]
        ];

        foreach ($discussions as $discussionData) {
            // Find or create user
            $user = $users->where('name', $discussionData['author_name'])->first();
            if (!$user) {
                $user = $users->first(); // Use first user if author not found
            }

            // Find category
            $category = $categories->where('name', $discussionData['category_name'])->first();
            if (!$category) {
                $category = $categories->first(); // Use first category if not found
            }

            // Create discussion
            $discussion = ForumDiscussion::create([
                'title' => $discussionData['title'],
                'content' => $discussionData['content'],
                'user_id' => $user->id,
                'forum_category_id' => $category->id,
                'likes_count' => rand(0, 10),
                'comments_count' => count($discussionData['comments'])
            ]);

            // Create comments
            foreach ($discussionData['comments'] as $commentData) {
                $commentUser = $users->where('name', $commentData['author_name'])->first();
                if (!$commentUser) {
                    $commentUser = $users->first();
                }

                ForumComment::create([
                    'content' => $commentData['content'],
                    'user_id' => $commentUser->id,
                    'forum_discussion_id' => $discussion->id,
                    'likes_count' => rand(0, 5)
                ]);
            }
        }

        $this->command->info('Forum discussions seeded successfully!');
    }
}
