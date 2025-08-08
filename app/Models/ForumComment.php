<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'forum_discussion_id',
        'likes_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discussion()
    {
        return $this->belongsTo(ForumDiscussion::class, 'forum_discussion_id');
    }

    /**
     * ANCHOR: Polymorphic likes relation (users who liked this comment)
     */
    public function likes()
    {
        return $this->morphMany(\App\Models\ForumLike::class, 'likeable');
    }
}
