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
        'title',
        'description',
        'additional_info',
        'kkn_type',
        'kkn_year',
        'file_type',
        'field_category',
        'kkn_location',
        'group_number',
        'file_name',
        'file_path',
        'file_mime_type',
        'file_size',
        'status',
        'review_notes',
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
        return Storage::url($this->file_path);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pedding' => 'Menunggu Review',
            'verified' => 'Terverifikasi',
            'validated' => 'Tervalidasi',
            'classified' => 'Terklasifikasi',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pedding' => 'badge-warning',
            'verified' => 'badge-info',
            'validated' => 'badge-primary',
            'classified' => 'badge-success',
            'rejected' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    // ANCHOR: Scopes
    public function scopePedding($query)
    {
        return $query->where('status', 'pedding');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeValidated($query)
    {
        return $query->where('status', 'validated');
    }

    public function scopeClassified($query)
    {
        return $query->where('status', 'classified');
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
            'status' => 'verified',
            'approved_at' => now(),
            'approved_by' => $approvedBy,
            'review_notes' => $notes,
        ]);
    }

    public function validate($validatedBy, $notes = null): void
    {
        $this->update([
            'status' => 'validated',
            'approved_at' => now(),
            'approved_by' => $validatedBy,
            'review_notes' => $notes,
        ]);
    }

    public function reject($rejectedBy, $notes = null): void
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $rejectedBy,
            'review_notes' => $notes,
        ]);
    }

    public function deleteFile(): bool
    {
        if (Storage::exists($this->file_path)) {
            return Storage::delete($this->file_path);
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
