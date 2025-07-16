<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'akses',
        'deskripsi',
    ];

    /**
     * Mendapatkan semua user yang memiliki role ini.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
