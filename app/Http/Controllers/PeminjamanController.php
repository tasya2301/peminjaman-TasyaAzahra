<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman; 
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Mengambil data peminjaman beserta relasi user dan alat (jika ada)
        $peminjamans = Peminjaman::with(['user', 'alat'])->get(); 
        return view('admin.peminjaman', compact('peminjamans'));
    }

    public function destroy($id)
    {
        Peminjaman::destroy($id);
        return back()->with('success', 'Data peminjaman berhasil dihapus');
    }

    public function cetak_pdf()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])->get();
        
        // Memanggil view khusus untuk tampilan PDF
        $pdf = Pdf::loadView('admin.peminjaman_pdf', compact('peminjamans'));
        
        // Download file PDF-nya
        return $pdf->download('laporan-peminjaman.pdf');
    }
}