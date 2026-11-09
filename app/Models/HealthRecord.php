<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'jenis_pemeriksaan',
        'tanggal_pemeriksaan',
        'status_kesehatan',
        'catatan',
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
