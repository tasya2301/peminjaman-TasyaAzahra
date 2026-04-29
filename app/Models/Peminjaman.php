<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    
    protected $fillable = [
        'user_id',
        'alat_id',
        'jumlah',
        'tgl_pinjam',
        'tgl_kembali',
        'total_harga',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class);
    }
}
