<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role_id',
        'nim',
        'nip_nidn',
        'fakultas',
        'program_studi',
        'angkatan',
        'jenis_kkn',
        'no_kelompok_kkn',
        'lokasi_kkn',
        'tahun_kkn',
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
}
