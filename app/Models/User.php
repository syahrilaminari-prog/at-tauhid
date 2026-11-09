<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->role?->slug === 'admin';
    }

    public function isParent(): bool
    {
        return $this->role?->slug === 'orang_tua';
    }

    public function isSantri(): bool
    {
        return $this->role?->slug === 'santri';
    }

    public function isUstadz(): bool
    {
        return $this->role?->slug === 'ustadz';
    }

    public function getDashboardRoute(): string
    {
        if ($this->isAdmin()) {
            return route('admin.dashboard', absolute: false);
        }

        if ($this->isParent()) {
            return route('orangtua.dashboard', absolute: false);
        }

        if ($this->isSantri()) {
            return route('santri.dashboard', absolute: false);
        }

        if ($this->isUstadz()) {
            return route('ustadz.dashboard', absolute: false);
        }

        return route('dashboard', absolute: false);
    }

    public function parentLinks()
    {
        return $this->hasMany(StudentParentLink::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_parent_links');
    }

    public function imageAttachments(): MorphMany
    {
        return $this->morphMany(ImageAttachment::class, 'imageable');
    }
}
