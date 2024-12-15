<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'judul',
        'deskripsi',
        'gambar',
        'isi'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriLesson::class, 'kategori_id');
    }
}