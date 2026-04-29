<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PetugasController extends Controller
{
    public function petugas()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])->latest()->get();
         dd($peminjamans->first()->alat->foto);
        return view('petugas.dashboard', compact('peminjamans'));
    }

    // SETUJUI
    public function approve($id)
    {
        $p = Peminjaman::findOrFail($id);
        $p->status = 'disewa'; 
        $p->save();
        return redirect()->back()->with('success', 'Peminjaman disetujui!');
    }

    // TOLAK
    public function tolak($id)
    {
        $p = Peminjaman::findOrFail($id);
        $p->status = 'ditolak'; 
        $p->save();
        return redirect()->back()->with('success', 'Peminjaman ditolak!');
    }

    // KEMBALI
    public function kembali($id)
    {
        $p = Peminjaman::findOrFail($id);
        $p->status = 'kembali'; // Pakai 'selesai' sebagai tanda alat sudah balik
        $p->tgl_dikembalikan = now(); // Mencatat tanggal pengembalian otomatis
        $p->save();
        return redirect()->back()->with('success', 'Alat telah dikembalikan!');
    }
}