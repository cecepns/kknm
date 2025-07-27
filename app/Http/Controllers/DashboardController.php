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
        if (in_array($roleId, [4, 5])) {
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
     * ANCHOR: Get quick access links based on role
     */
    private function getQuickAccessLinks($roleId)
    {
        $baseLinks = [];
        
        if (in_array($roleId, [4, 5])) {
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
            return $baseLinks;
        }
        
        return $baseLinks;
    }
} 