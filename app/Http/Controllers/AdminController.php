<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Alat;
use App\Models\User;
use App\Models\Peminjaman;

class AdminController extends Controller
{
    // ==========================================
    // BAGIAN KATEGORI
    // ==========================================
    
    public function kategori()
    {
        // Pastikan tabel 'kategori' sudah ada di DB
        $kategoris = Kategori::all();
        return view('admin.kategori', compact('kategoris'));
    }

    public function storeKategori(Request $req)
    {
        $req->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        Kategori::create([
            'nama_kategori' => $req->nama_kategori
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function destroyKategori($id)
    {
        Kategori::destroy($id);
        return back()->with('success', 'Kategori dihapus');
    }

    public function editKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.edit_kategori', compact('kategori'));
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diupdate');
    }

    // ==========================================
    // BAGIAN ALAT
    // ==========================================
    public function alat()
    {
        $alats = Alat::with('kategori')->get();
        $kategoris = Kategori::all();
        return view('admin.alat', compact('alats', 'kategoris'));
    }

    public function storeAlat(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga_per_hari' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('alat', 'public');
        }

        Alat::create([
            'nama_alat' => $request->nama_alat,
            'kategori_id' => $request->kategori_id,
            'harga_per_hari' => $request->harga_per_hari,
            'stok' => $request->stok,
            'foto' => $fotoPath 
        ]);

        return redirect()->route('admin.alat')->with('success', 'Alat berhasil ditambahkan!');
    }

    public function editAlat($id)
    {
        $alat = Alat::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.edit_alat', compact('alat', 'kategoris'));
    }

    public function updateAlat(Request $request, $id)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga_per_hari' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $alat = Alat::findOrFail($id);
        
        // Data yang akan diupdate
        $data = [
            'nama_alat' => $request->nama_alat,
            'kategori_id' => $request->kategori_id,
            'harga_per_hari' => $request->harga_per_hari,
            'stok' => $request->stok,
        ];

        // Logika Update Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
                Storage::disk('public')->delete($alat->foto);
            }
            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        $alat->update($data);

        return redirect()->route('admin.alat')->with('success', 'Data alat berhasil diupdate!');
    }

    public function destroyAlat($id)
    {
        $alat = Alat::findOrFail($id);

        // Hapus file foto dari folder storage agar tidak menumpuk
        if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();
        return redirect()->route('admin.alat')->with('success', 'Alat berhasil dihapus!');
    }
    // ==========================================
    // BAGIAN USER
    // ==========================================

    public function user()
    {
        $users = User::all(); 
        return view('admin.user', compact('users'));
    }

    public function storeUser(Request $req)
    {
        $req->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required'
        ]);

        User::create([
            'name'     => $req->name,
            'email'    => $req->email,
            'password' => bcrypt($req->password), 
            'role'     => $req->role,
        ]);

        return back()->with('success', 'User Berhasil Ditambah');
    }

    public function destroyUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User Dihapus');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);  
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,'.$id, // Agar email sendiri tidak dianggap duplikat
            'role'  => 'required'
        ]);

        $user = User::findOrFail($id);
        
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user')->with('success', 'User berhasil diupdate');
    }

    // ==========================================
    // BAGIAN PEMINJAMAN (ADMIN VIEW)
    // ==========================================
    public function peminjaman()
    {
        // Admin bisa melihat semua data peminjaman dari semua user
        $peminjamans = Peminjaman::with(['user', 'alat'])->latest()->get();
        return view('admin.peminjaman', compact('peminjamans'));
    }

    public function destroyPeminjaman($id)
    {
        Peminjaman::destroy($id);
        return back()->with('success', 'Data peminjaman dihapus');
    }
}
