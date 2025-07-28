<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;
use App\Models\Knowledge;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityController extends Controller
{
    /**
     * ANCHOR: Display the activity monitoring dashboard
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $activityType = $request->get('activity_type', 'all');
        
        // Get summary statistics
        $totalUsers = User::count();
        $todayLogins = Activity::where('activity_type', 'login')
            ->whereDate('created_at', Carbon::today())
            ->count();
        $totalRegistrations = Activity::where('activity_type', 'register')->count();
        $totalForumActivities = Activity::whereIn('activity_type', [
            'membuat_diskusi_forum',
            'mengupdate_diskusi_forum', 
            'menghapus_diskusi_forum',
            'menambah_komentar_forum',
            'mengupdate_komentar_forum',
            'menghapus_komentar_forum'
        ])->count();
        
        // Get activity data with filtering
        $activitiesQuery = Activity::with('user')
            ->orderBy('created_at', 'desc');
            
        if ($activityType !== 'all') {
            $activitiesQuery->where('activity_type', $activityType);
        }
        
        $activities = $activitiesQuery->get();
        
        // Get unique activity types for filter dropdown
        $activityTypes = Activity::select('activity_type')
            ->distinct()
            ->pluck('activity_type')
            ->toArray();
        
        return view('monitoring-aktifitas.index', compact(
            'totalUsers',
            'todayLogins', 
            'totalRegistrations',
            'totalForumActivities',
            'activities',
            'activityTypes',
            'activityType'
        ));
    }

    /**
     * ANCHOR: Get Indonesian label for activity type
     */
    public function getActivityTypeLabel($activityType)
    {
        $labels = [
            'login' => 'Login',
            'logout' => 'Logout',
            'register' => 'Registrasi',
            'membuat_diskusi_forum' => 'Membuat Diskusi Forum',
            'mengupdate_diskusi_forum' => 'Mengupdate Diskusi Forum',
            'menghapus_diskusi_forum' => 'Menghapus Diskusi Forum',
            'menambah_komentar_forum' => 'Menambah Komentar Forum',
            'mengupdate_komentar_forum' => 'Mengupdate Komentar Forum',
            'menghapus_komentar_forum' => 'Menghapus Komentar Forum',
        ];

        return $labels[$activityType] ?? ucfirst(str_replace('_', ' ', $activityType));
    }
}
