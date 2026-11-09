<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Dormitory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'nama_kamar',
        'kapasitas',
        'keterangan',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function imageAttachments(): MorphMany
    {
        return $this->morphMany(ImageAttachment::class, 'imageable');
    }
}
