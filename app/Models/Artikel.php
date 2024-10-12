<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;
    protected $table = 'artikel';

    protected $fillable = [
        'user_id',
        'judul',
        'ringkasan',
        'foto',
        'konten',
        'view_count',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ArtikelLike::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(ArtikelBookmark::class);
    }

    public function getLikeCountAttribute(): int
    {
        return $this->likes()->count();
    }
}
