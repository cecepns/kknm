<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

trait ActivityLogger
{
    /**
     * ANCHOR: Log user activity
     */
    protected function logActivity($activityType, $description, Request $request = null)
    {
        if (!Auth::check()) {
            return;
        }

        $request = $request ?? request();

        Activity::create([
            'user_id' => Auth::id(),
            'activity_type' => $activityType,
            'description' => $description,
        ]);
    }

    /**
     * ANCHOR: Log login activity
     */
    protected function logLogin()
    {
        $this->logActivity('login', 'User berhasil login ke sistem');
    }

    /**
     * ANCHOR: Log logout activity
     */
    protected function logLogout()
    {
        $this->logActivity('logout', 'User berhasil logout dari sistem');
    }

    /**
     * ANCHOR: Log user registration activity
     */
    protected function logRegistration($userName)
    {
        $this->logActivity('register', "Pengguna baru mendaftar: {$userName}");
    }

    /**
     * ANCHOR: Log forum discussion creation
     */
    protected function logForumDiscussion($discussionTitle)
    {
        $this->logActivity('membuat_diskusi_forum', "Membuat diskusi forum: {$discussionTitle}");
    }

    /**
     * ANCHOR: Log forum discussion update
     */
    protected function logForumDiscussionUpdate($discussionTitle)
    {
        $this->logActivity('mengupdate_diskusi_forum', "Mengupdate diskusi forum: {$discussionTitle}");
    }

    /**
     * ANCHOR: Log forum discussion delete
     */
    protected function logForumDiscussionDelete($discussionTitle)
    {
        $this->logActivity('menghapus_diskusi_forum', "Menghapus diskusi forum: {$discussionTitle}");
    }

    /**
     * ANCHOR: Log forum comment creation
     */
    protected function logForumComment($discussionTitle)
    {
        $this->logActivity('menambah_komentar_forum', "Menambahkan komentar pada diskusi: {$discussionTitle}");
    }

    /**
     * ANCHOR: Log forum comment update
     */
    protected function logForumCommentUpdate($discussionTitle)
    {
        $this->logActivity('mengupdate_komentar_forum', "Mengupdate komentar pada diskusi: {$discussionTitle}");
    }

    /**
     * ANCHOR: Log forum comment delete
     */
    protected function logForumCommentDelete($discussionTitle)
    {
        $this->logActivity('menghapus_komentar_forum', "Menghapus komentar pada diskusi: {$discussionTitle}");
    }
} 