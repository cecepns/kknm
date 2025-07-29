<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeCategory extends Model
{
    use HasFactory;

    // ANCHOR: Fillable Fields
    protected $fillable = [
        'name',
    ];

    // ANCHOR: Relationships
    public function knowledgeItems(): HasMany
    {
        return $this->hasMany(Knowledge::class, 'category_id');
    }
}
