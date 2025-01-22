<?php

namespace App\Models;

use App\Models\LessonRead;
use App\Models\KategoriLesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function lessonReads(): HasMany
    {
        return $this->hasMany(LessonRead::class);
    }
}