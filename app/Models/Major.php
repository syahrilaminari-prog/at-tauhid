<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'jurusan_id');
    }

    public function imageAttachments(): MorphMany
    {
        return $this->morphMany(ImageAttachment::class, 'imageable');
    }
}
