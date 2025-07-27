<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Knowledge;
use App\Models\ForumDiscussion;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * ANCHOR: Display dashboard with role-specific data
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $roleId = $user->role_id;
            
            // Get dashboard data based on user role
            $dashboardData = $this->getDashboardData($user, $roleId);
            
            return view('dashboard.dashboard', $dashboardData);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Dashboard error: ' . $e->getMessage());
            
            // Return dashboard with default data
            return view('dashboard.dashboard', [
                'welcomeMessage' => 'Selamat Datang',
                'stats' => [
                    'totalUploaded' => 0,
                    'totalValidated' => 0,
                    'totalRejected' => 0,
                    'totalForums' => 0
                ],
                'quickAccessLinks' => []
            ]);
        }
    }
    
    /**
     * ANCHOR: Get dashboard data based on user role
     */
    private function getDashboardData($user, $roleId)
    {
        $data = [
            'welcomeMessage' => 'Selamat Datang, ' . $user->name,
            'stats' => $this->getStats($user, $roleId),
            'quickAccessLinks' => $this->getQuickAccessLinks($roleId)
        ];
        
        return $data;
    }
    
    /**
     * ANCHOR: Get welcome message based on role
     */
    private function getWelcomeMessage($roleId)
    {
        return match($roleId) {
            4, 5 => 'Selamat Datang, Dosen Pembimbing Lapangan KKN',
            default => 'Selamat Datang'
        };
    }
    
    /**
     * ANCHOR: Get statistics based on user role
     */
    private function getStats($user, $roleId)
    {
        if ($roleId == 1) {
            // For Mahasiswa KKN (role 1)
            return [
                'totalKnowledge' => $this->getTotalKnowledge(),
                'totalUnvalidated' => $this->getTotalUnvalidatedKnowledge(),
                'totalValidated' => $this->getTotalValidatedKnowledge(),
                'totalRepositoryFiles' => $this->getTotalApprovedKnowledge()
            ];
        } elseif ($roleId == 3) {
            // For Admin (role 3) - System-wide statistics
            return [
                'totalUsers' => $this->getTotalUsers(),
                'totalKnowledge' => $this->getTotalKnowledge(),
                'totalActiveForums' => $this->getTotalActiveForums(),
                'totalRepositoryFiles' => $this->getTotalRepositoryFiles()
            ];
        } elseif (in_array($roleId, [4, 5])) {
            // For Dosen Pembimbing Lapangan KKN (roles 4 & 5)
            return [
                'totalUploaded' => $this->getTotalKnowledgeUploaded($user),
                'totalValidated' => $this->getTotalKnowledgeValidated($user),
                'totalRejected' => $this->getTotalKnowledgeRejected($user),
                'totalForums' => $this->getTotalForumsFollowed($user)
            ];
        }
        
        // Default stats for other roles
        return [
            'totalUploaded' => 0,
            'totalValidated' => 0,
            'totalRejected' => 0,
            'totalForums' => 0
        ];
    }
    
    /**
     * ANCHOR: Get total knowledge uploaded by user
     */
    private function getTotalKnowledgeUploaded($user)
    {
        return Knowledge::where('user_id', $user->id)->count();
    }
    
    /**
     * ANCHOR: Get total knowledge validated by user
     */
    private function getTotalKnowledgeValidated($user)
    {
        return Knowledge::where('user_id', $user->id)
            ->where('status', 'validated')
            ->count();
    }
    
    /**
     * ANCHOR: Get total knowledge rejected by user
     */
    private function getTotalKnowledgeRejected($user)
    {
        return Knowledge::where('user_id', $user->id)
            ->where('status', 'rejected')
            ->count();
    }
    
    /**
     * ANCHOR: Get total forums followed by user
     */
    private function getTotalForumsFollowed($user)
    {
        return ForumDiscussion::whereHas('comments', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
    }
    
    /**
     * ANCHOR: Get total users in system (for admin)
     */
    private function getTotalUsers()
    {
        return User::count();
    }
    
    /**
     * ANCHOR: Get total knowledge entries in system (for admin)
     */
    private function getTotalKnowledge()
    {
        return Knowledge::count();
    }
    
    /**
     * ANCHOR: Get total active forums in system (for admin)
     */
    private function getTotalActiveForums()
    {
        return ForumDiscussion::count();
    }
    
    /**
     * ANCHOR: Get total repository files in system (for admin)
     */
    private function getTotalRepositoryFiles()
    {
        // Count all knowledge files that are validated/classified
        return Knowledge::whereIn('status', ['validated', 'classified'])->count();
    }
    
    /**
     * ANCHOR: Get total unvalidated knowledge (pending or verified)
     */
    private function getTotalUnvalidatedKnowledge()
    {
        return Knowledge::whereIn('status', ['pedding', 'verified'])->count();
    }
    
    /**
     * ANCHOR: Get total validated knowledge
     */
    private function getTotalValidatedKnowledge()
    {
        return Knowledge::where('status', 'validated')->count();
    }
    
    /**
     * ANCHOR: Get total approved knowledge (for repository)
     */
    private function getTotalApprovedKnowledge()
    {
        return Knowledge::where('status', 'approved')->count();
    }
    
        /**
     * ANCHOR: Get quick access links based on role
     */
    private function getQuickAccessLinks($roleId)
    {
        $baseLinks = [];

        if ($roleId == 1) {
            // For Mahasiswa KKN (role 1)
            $baseLinks = [
                [
                    'title' => 'Akses Pengumuman',
                    'url' => route('akses.pengumuman')
                ],
                [
                    'title' => 'Akses FAQ',
                    'url' => route('akses.faq')
                ],
                [
                    'title' => 'Validasi Pengetahuan',
                    'url' => route('validasi.pengetahuan')
                ],
                [
                    'title' => 'Repositori Publik',
                    'url' => '#'
                ],
                [
                    'title' => 'Forum Diskusi',
                    'url' => route('forum.diskusi')
                ],
                [
                    'title' => 'Monitoring Aktivitas',
                    'url' => '#'
                ]
            ];
        } elseif ($roleId == 3) {
             $baseLinks = [
                 [
                     'title' => 'Kelola Pengguna',
                     'url' => route('daftar.pengguna.internal')
                 ],
                 [
                     'title' => 'Kelola Role',
                     'url' => '#'
                 ],
                 [
                     'title' => 'Kelola Pengumuman',
                     'url' => route('daftar.kelola.pengumuman')
                 ],
                 [
                     'title' => 'Akses Pengumuman',
                     'url' => route('akses.pengumuman')
                 ],
                 [
                     'title' => 'Kelola FAQ',
                     'url' => route('daftar.kelola.faq')
                 ],
                 [
                     'title' => 'Akses FAQ',
                     'url' => route('akses.faq')
                 ],
                 [
                     'title' => 'Klasifikasi Pengetahuan',
                     'url' => route('verifikasi.pengetahuan')
                 ],
                 [
                     'title' => 'Kelola Repositori',
                     'url' => route('validasi.pengetahuan')
                 ],
                 [
                     'title' => 'Repositori Publik',
                     'url' => '#'
                 ],
                 [
                     'title' => 'Kelola Kategori Forum',
                     'url' => route('daftar.kelola.kategori.forum')
                 ],
                 [
                     'title' => 'Forum Diskusi',
                     'url' => route('forum.diskusi')
                 ],
                 [
                     'title' => 'Kelola Forum Diskusi',
                     'url' => route('forum.diskusi')
                 ]
             ];
                 } elseif (in_array($roleId, [4, 5])) {
             $baseLinks = [
                 [
                     'title' => 'Akses Pengumuman',
                     'url' => route('akses.pengumuman')
                 ],
                 [
                     'title' => 'Akses FAQ',
                     'url' => route('akses.faq')
                 ],
                 [
                     'title' => 'Unggah Pengetahuan',
                     'url' => route('unggah.pengetahuan')
                 ],
                 [
                     'title' => 'Repositori Publik',
                     'url' => '#'
                 ],
                 [
                     'title' => 'Forum Diskusi',
                     'url' => route('forum.diskusi')
                 ]
             ];
        }
        
        return $baseLinks;
    }
} 