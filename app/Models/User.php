<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasPermissions;

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
