<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    /**
     * ANCHOR: Run the database seeds for activity monitoring
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        $activityTypes = [
            'login' => 'User berhasil login ke sistem',
            'logout' => 'User berhasil logout dari sistem',
            'register' => 'Pengguna baru mendaftar',
            'membuat_diskusi_forum' => 'Membuat diskusi forum',
            'mengupdate_diskusi_forum' => 'Mengupdate diskusi forum',
            'menghapus_diskusi_forum' => 'Menghapus diskusi forum',
            'menambah_komentar_forum' => 'Menambahkan komentar pada diskusi',
            'mengupdate_komentar_forum' => 'Mengupdate komentar pada diskusi',
            'menghapus_komentar_forum' => 'Menghapus komentar pada diskusi',
        ];

        $sampleNames = [
            'Rina Wijaya',
            'Budi Santoso',
            'Siti Nurhaliza',
            'Ahmad Fauzi',
            'Dewi Sartika',
            'Muhammad Rizki',
            'Nina Safitri',
            'Joko Widodo',
            'Sri Mulyani',
            'Prabowo Subianto'
        ];

        // Create sample activities for the last 30 days
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $activityType = array_rand($activityTypes);
            $description = $activityTypes[$activityType];
            
            // Add more specific descriptions for some activities
            if ($activityType === 'register') {
                $description = 'Pengguna baru mendaftar: ' . $sampleNames[array_rand($sampleNames)];
            } elseif ($activityType === 'membuat_diskusi_forum') {
                $discussionTitles = [
                    'Tips KKN di Desa',
                    'Pengalaman KKN Kesehatan',
                    'Strategi KKN Pendidikan',
                    'Inovasi KKN Lingkungan',
                    'Teknologi dalam KKN'
                ];
                $description = 'Membuat diskusi forum: ' . $discussionTitles[array_rand($discussionTitles)];
            } elseif ($activityType === 'mengupdate_diskusi_forum') {
                $discussionTitles = [
                    'Tips KKN di Desa',
                    'Pengalaman KKN Kesehatan',
                    'Strategi KKN Pendidikan'
                ];
                $description = 'Mengupdate diskusi forum: ' . $discussionTitles[array_rand($discussionTitles)];
            } elseif ($activityType === 'menghapus_diskusi_forum') {
                $discussionTitles = [
                    'Tips KKN di Desa',
                    'Pengalaman KKN Kesehatan'
                ];
                $description = 'Menghapus diskusi forum: ' . $discussionTitles[array_rand($discussionTitles)];
            } elseif ($activityType === 'menambah_komentar_forum') {
                $discussionTitles = [
                    'Tips KKN di Desa',
                    'Pengalaman KKN Kesehatan',
                    'Strategi KKN Pendidikan'
                ];
                $description = 'Menambahkan komentar pada diskusi: ' . $discussionTitles[array_rand($discussionTitles)];
            }

            Activity::create([
                'user_id' => $user->id,
                'activity_type' => $activityType,
                'description' => $description,
                'created_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
            ]);
        }

        $this->command->info('ActivitySeeder completed successfully!');
    }
}
