<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class InstitutionProfileSection extends Model
{
    use HasFactory;

    public const SECTION_TYPES = [
        'history' => 'Sejarah',
        'vision' => 'Visi',
        'mission' => 'Misi',
        'organization' => 'Struktur Organisasi',
        'program' => 'Program Inti',
    ];

    protected $fillable = [
        'section_type',
        'slug',
        'title',
        'content',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getSectionTypeLabelAttribute(): string
    {
        return self::SECTION_TYPES[$this->section_type] ?? 'Lainnya';
    }

    public function imageAttachments(): MorphMany
    {
        return $this->morphMany(ImageAttachment::class, 'imageable');
    }
}