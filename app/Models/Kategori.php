<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori'; // Memaksa menggunakan nama tunggal
    protected $fillable = ['nama_kategori'];

    public function alats()
    {
        return $this->hasMany(Alat::class, 'kategori_id');
    }
}