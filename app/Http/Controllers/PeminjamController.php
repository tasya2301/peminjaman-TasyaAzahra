<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');
        $alats = Alat::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_alat', 'like', "%{$search}%"); 
            })
            ->get();

        $riwayats = Peminjaman::with('alat')
            ->where('user_id', Auth::id())
            ->latest()
            ->get(); 

        return view('peminjam.dashboard', compact('alats', 'riwayats')); 
    }

    // Store
    public function store(Request $req)
    {
        $req->validate([
            'alat_id' => 'required', 
            'jumlah' => 'required|numeric|min:1', 
            'tanggal_pinjam' => 'required|date|after_or_equal:today', 
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam', 
        ], [
            'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam minimal hari ini.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali salah.',
        ]);

        $alat = Alat::findOrFail($req->alat_id);

        
        if ($req->jumlah > $alat->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia!'); 
        }

        // Simpam peminjam
        Peminjaman::create([
            'user_id' => Auth::id(), 
            'alat_id' => $req->alat_id, 
            'jumlah' => $req->jumlah, 
            'tgl_pinjam' => $req->tanggal_pinjam, 
            'tgl_kembali' => $req->tanggal_kembali, 
            'total_harga' => $alat->harga * $req->jumlah,
            'status' => 'pending',
]);

        // Kurangi stok alat 
        $alat->stok -= $req->jumlah;
        $alat->save();
        return back()->with('success', 'Berhasil Diajukan'); 
    }
}