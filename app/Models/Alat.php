<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan import ini (opsional tapi disarankan)

class Alat extends Model
{
    protected $table = 'alats'; // Memastikan ke tabel alats
    protected $fillable = ['kategori_id', 'nama_alat', 'harga_per_hari', 'stok'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}