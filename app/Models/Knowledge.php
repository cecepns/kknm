<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Knowledge extends Model
{
    use HasFactory;

    // ANCHOR: Fillable Fields
    protected $fillable = [
        'judul',
        'deskripsi',
        'informasi_tambahan',
        'jenis_kkn',
        'tahun_kkn',
        'jenis_file',
        'kategori_bidang',
        'lokasi_kkn',
        'nomor_kelompok',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
        'status',
        'catatan_review',
        'approved_at',
        'approved_by',
        'user_id',
    ];

    // ANCHOR: Casts
    protected $casts = [
        'approved_at' => 'datetime',
        'ukuran_file' => 'integer',
        'nomor_kelompok' => 'integer',
        'tahun_kkn' => 'integer',
    ];

    // ANCHOR: Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ANCHOR: Accessors
    public function getFileUrlAttribute(): string
    {
        return Storage::url($this->path_file);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->ukuran_file;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Review',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'approved' => 'badge-success',
            'rejected' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    // ANCHOR: Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ANCHOR: Methods
    public function approve($approvedBy, $notes = null): void
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approvedBy,
            'catatan_review' => $notes,
        ]);
    }

    public function reject($rejectedBy, $notes = null): void
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $rejectedBy,
            'catatan_review' => $notes,
        ]);
    }

    public function deleteFile(): bool
    {
        if (Storage::exists($this->path_file)) {
            return Storage::delete($this->path_file);
        }
        return false;
    }

    // ANCHOR: Boot Method
    protected static function boot()
    {
        parent::boot();

        // Delete file when knowledge is deleted
        static::deleting(function ($knowledge) {
            $knowledge->deleteFile();
        });
    }
}
