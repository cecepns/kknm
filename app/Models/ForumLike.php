<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ForumLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'likeable_type',
        'likeable_id',
    ];

    /**
     * ANCHOR: The parent likeable model (discussion or comment)
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}


