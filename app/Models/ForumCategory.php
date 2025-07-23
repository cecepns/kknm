<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumCategory extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'topic_count',
        'created_by',
    ];

    /**
     * Mendefinisikan relasi bahwa setiap kategori forum 'dimiliki oleh' satu pengguna.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Mendefinisikan relasi bahwa setiap kategori forum 'memiliki banyak' diskusi.
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(ForumDiscussion::class, 'forum_category_id');
    }

    /**
     * Mendapatkan jumlah topik/diskusi dalam kategori ini.
     */
    public function getTopicCountAttribute()
    {
        return $this->discussions()->count();
    }
}
