<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriClass extends Model
{
    use HasFactory;
    protected $table = 'kategori_class';
    protected $fillable = ['nama'];

    public function artikle()
    {
        return $this->hasMany(ArtikleClass::class, 'kategori_id', 'id');
    }
}
