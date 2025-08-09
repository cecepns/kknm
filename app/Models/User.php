<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasPermissions;
use App\Helpers\UserHelper;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissions;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'student_id',
        'employee_id',
        'faculty',
        'study_program',
        'batch_year',
        'account_type',
        'status',
        'kkn_type',
        'kkn_group_number',
        'kkn_location',
        'kkn_year',
        'custom_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * ANCHOR: Boot method to handle custom ID generation
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($user) {
            if (empty($user->custom_id)) {
                $user->custom_id = UserHelper::generateCustomId($user->role_id);
            }
        });
    }

    /**
     * ANCHOR: Generate custom ID for new users
     */
    public static function generateCustomId($roleId)
    {
        return UserHelper::generateCustomId($roleId);
    }

    /**
     * ANCHOR: Get role name from custom_id prefix
     */
    public function getRoleNameFromCustomId()
    {
        if (!$this->custom_id) {
            return 'Unknown';
        }
        
        $prefix = substr($this->custom_id, 0, 3);
        return UserHelper::getRoleNameFromPrefix($prefix);
    }

    /**
     * ANCHOR: Get formatted custom ID for display
     */
    public function getFormattedCustomId()
    {
        return UserHelper::formatCustomId($this->custom_id);
    }

    /**
     * ANCHOR: Get display name with custom ID
     */
    public function getDisplayName()
    {
        return UserHelper::getUserDisplayName($this);
    }

    /**
     * Mendapatkan role dari user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    /**
     * ANCHOR: Get knowledge uploaded by this user
     */
    public function knowledge()
    {
        return $this->hasMany(Knowledge::class);
    }
    
    /**
     * ANCHOR: Get forum discussions created by this user
     */
    public function forumDiscussions()
    {
        return $this->hasMany(ForumDiscussion::class);
    }
    
    /**
     * ANCHOR: Get activities performed by this user
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    

}
