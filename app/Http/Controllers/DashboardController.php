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
     * ANCHOR: Display utility classes demo page
     */
    public function utilityDemo()
    {
        return view('examples.utility-demo');
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
            // For Kepala PPM (role 1)
            return [
                'totalKnowledge' => $this->getTotalKnowledge(),
                'totalUnvalidated' => $this->getTotalUnvalidatedKnowledge(),
                'totalValidated' => $this->getTotalValidatedKnowledge(),
                'totalRepositoryFiles' => $this->getTotalApprovedKnowledge()
            ];
        } elseif ($roleId == 2) {
            // For Koordinator KKN (role 2)
            return [
                'totalUnverified' => $this->getTotalUnverifiedKnowledge(),
                'totalVerified' => $this->getTotalVerifiedKnowledge(),
                'totalClassified' => $this->getTotalClassifiedKnowledge(),
                'totalRepositoryFiles' => $this->getTotalValidatedKnowledge()
            ];
        } elseif ($roleId == 3) {
            // For Admin (role 3)
            return [
                'totalUsers' => $this->getTotalUsers(),
                'totalKnowledge' => $this->getTotalKnowledge(),
                'totalActiveForums' => $this->getTotalActiveForums(),
                'totalRepositoryFiles' => $this->getTotalRepositoryFiles()
            ];
        } elseif (in_array($roleId, [4, 5])) {
            // For Dosen Pembimbing Lapangan KKN (roles 5) & Mahasiswa KKN (role 4)
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
     * ANCHOR: Get total unverified knowledge (pending)
     */
    private function getTotalUnverifiedKnowledge()
    {
        return Knowledge::where('status', 'pedding')->count();
    }
    
    /**
     * ANCHOR: Get total verified knowledge
     */
    private function getTotalVerifiedKnowledge()
    {
        return Knowledge::where('status', 'verified')->count();
    }
    
    /**
     * ANCHOR: Get total classified knowledge
     */
    private function getTotalClassifiedKnowledge()
    {
        return Knowledge::where('status', 'validated')->count();
    }
    
        /**
     * ANCHOR: Get quick access links based on role
     */
    private function getQuickAccessLinks($roleId)
    {
        // Define common links that are shared across roles
        $commonLinks = [
            'akses_pengumuman' => [
                'title' => 'Akses Pengumuman',
                'url' => route('akses.pengumuman')
            ],
            'akses_faq' => [
                'title' => 'Akses FAQ',
                'url' => route('akses.faq')
            ],
            'forum_diskusi' => [
                'title' => 'Forum Diskusi',
                'url' => route('forum.diskusi')
            ],
            'repositori_publik' => [
                'title' => 'Repositori Publik',
                'url' => '#'
            ]
        ];
        
        // Define role-specific links
        $roleSpecificLinks = [
            1 => [ // Kepala PPM
                'validasi_pengetahuan' => [
                    'title' => 'Validasi Pengetahuan',
                    'url' => route('validasi.pengetahuan')
                ],
                'monitoring_aktivitas' => [
                    'title' => 'Monitoring Aktivitas',
                    'url' => '#'
                ]
            ],
            2 => [ // Verifikator
                'verifikasi_pengetahuan' => [
                    'title' => 'Verifikasi Pengetahuan',
                    'url' => route('verifikasi.pengetahuan')
                ],
                'kelola_repositori' => [
                    'title' => 'Kelola Repositori',
                    'url' => route('validasi.pengetahuan')
                ],
                'monitoring_aktivitas' => [
                    'title' => 'Monitoring Aktivitas',
                    'url' => '#'
                ]
            ],
            3 => [ // Admin
                'kelola_pengguna' => [
                    'title' => 'Kelola Pengguna',
                    'url' => route('daftar.pengguna.internal')
                ],
                'kelola_pengumuman' => [
                    'title' => 'Kelola Pengumuman',
                    'url' => route('daftar.kelola.pengumuman')
                ],
                'kelola_faq' => [
                    'title' => 'Kelola FAQ',
                    'url' => route('daftar.kelola.faq')
                ],
                'kelola_repositori' => [
                    'title' => 'Kelola Repositori',
                    'url' => route('validasi.pengetahuan')
                ],
                'kelola_kategori_forum' => [
                    'title' => 'Kelola Kategori Forum',
                    'url' => route('daftar.kelola.kategori.forum')
                ],
                'kelola_forum_diskusi' => [
                    'title' => 'Kelola Forum Diskusi',
                    'url' => route('forum.diskusi')
                ]
            ],
            4 => [ // Dosen Pembimbing
                 'unggah_pengetahuan' => [
                     'title' => 'Unggah Pengetahuan',
                     'url' => route('unggah.pengetahuan')
                 ]
             ],
             5 => [ // Dosen Pembimbing
                 'unggah_pengetahuan' => [
                     'title' => 'Unggah Pengetahuan',
                     'url' => route('unggah.pengetahuan')
                 ]
             ]
        ];
        
        // Build links based on role
        $baseLinks = [];
        
        // Add common links for all roles
        $baseLinks = array_merge($baseLinks, array_values($commonLinks));
        
        // Add role-specific links
        if (isset($roleSpecificLinks[$roleId])) {
            $baseLinks = array_merge($baseLinks, array_values($roleSpecificLinks[$roleId]));
        }
        
        return $baseLinks;
    }
} 