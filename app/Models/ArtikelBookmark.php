<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtikelBookmark extends Model
{
    use HasFactory;
    protected $table = 'artikel_bookmarks';

    protected $fillable = [
        'user_id',
        'artikel_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function artikel(): BelongsTo
    {
        return $this->belongsTo(Artikel::class);
    }
}
