<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtikleClass extends Model
{
    use HasFactory;
    protected $table = 'artkle_class';
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'konten'];

    public function kategori()
    {
        return $this->belongsTo(KategoriClass::class, 'kategori_id', 'id');
    }
}
