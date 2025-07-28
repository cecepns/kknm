<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ANCHOR: Get the user who performed this activity
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ANCHOR: Scope to filter by activity type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * ANCHOR: Scope to get recent activities
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
