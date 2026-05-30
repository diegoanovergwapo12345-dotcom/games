<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'role',
        'status',
        'phone',
        'address',
        'bio',
        'avatar',
        'last_seen'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'last_seen'         => 'datetime',
    ];

    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute(): string
{
    if (!$this->avatar) {
        return asset('images/blankpfp.jpg');
    }

    $path = 'uploads/' . $this->avatar;

    if (Storage::disk('public')->exists($path)) {
        return asset('storage/' . $path) . '?v=' . Storage::disk('public')->lastModified($path);
    }

    return asset('images/blankpfp.jpg');
}
    public function isOnline(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }
        return $this->last_seen && $this->last_seen->gt(now()->subMinutes(5));
    }
}