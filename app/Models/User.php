<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'avatar',
        'fcm_token',
        'otp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function artikel(): HasMany
    {
        return $this->hasMany(Artikel::class);
    }

    public function artikelLikes(): HasMany
    {
        return $this->hasMany(ArtikelLike::class);
    }

    public function artikelBookmarks(): HasMany
    {
        return $this->hasMany(ArtikelBookmark::class);
    }
}