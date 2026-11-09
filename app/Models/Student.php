<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nis',
        'jenis_kelamin',
        'tanggal_lahir',
        'kelas',
        'tahun_masuk',
        'status',
        'alamat',
        'telepon',
        'nama_ayah',
        'nama_ibu',
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function healthRecords(): HasMany
    {
        return $this->hasMany(HealthRecord::class);
    }

    public function dormitories(): HasMany
    {
        return $this->hasMany(Dormitory::class);
    }

    public function parentLinks(): HasMany
    {
        return $this->hasMany(StudentParentLink::class);
    }

    public function parents()
    {
        return $this->belongsToMany(User::class, 'student_parent_links');
    }

    public function imageAttachments(): MorphMany
    {
        return $this->morphMany(ImageAttachment::class, 'imageable');
    }
}
