<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriLesson extends Model
{
    use HasFactory;

    protected $table = 'kategori_lessons';

    protected $fillable = [
        'nama'
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'kategori_id');
    }
}