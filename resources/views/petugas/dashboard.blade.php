<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-pink-600 leading-tight">
            {{ __('Dashboard Petugas') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-pink-100 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-2xl text-gray-800">Halo, Petugas {{ Auth::user()->name }}! ✨</h3>
                    <p class="text-pink-400">Kelola permintaan peminjaman alat di sini.</p>
                </div>
                <div class="bg-pink-100 text-pink-600 px-4 py-2 rounded-2xl font-bold text-sm">
                    {{ $peminjamans->count() }} Total Data
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="p-6 border-b border-pink-50 bg-pink-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-800">Daftar Aktivitas Peminjaman</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-pink-50/30">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase">Peminjam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase">Alat</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase">Tanggal Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-pink-600 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($peminjamans as $p)
                            <tr class="hover:bg-pink-50/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-800">{{ $p->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $p->user->email }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex-shrink-0">
                                            @if($p->alat->foto)
                                                <img src="{{ asset('storage/' . $p->alat->foto) }}" 
                                                     class="w-full h-full object-cover rounded-lg border border-pink-100 shadow-sm">
                                            @else
                                                <div class="w-full h-full bg-gray-100 rounded-lg flex items-center justify-center text-[10px] text-gray-400 border border-dashed">No Img</div>
                                            @endif
                                        </div>
                                        <span class="text-sm text-gray-700 font-medium">{{ $p->alat->nama_alat }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500 font-mono">
                                    {{ $p->tgl_pinjam }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($p->status == 'pending' || $p->status == 'menunggu')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-[10px] font-bold uppercase">Menunggu</span>
                                    @elseif($p->status == 'disewa' || $p->status == 'pinjam')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-[10px] font-bold uppercase">Dipinjam</span>
                                    @elseif($p->status == 'ditolak' || $p->status == 'tolak')
                                        <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-[10px] font-bold uppercase">Ditolak</span>
                                    @else
                                        <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-[10px] font-bold uppercase">Selesai</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if($p->status == 'pending' || $p->status == 'menunggu')
                                            <form action="{{ route('petugas.approve', $p->id) }}" method="POST">
                                                @csrf
                                                <button class="bg-pink-500 hover:bg-pink-600 text-white text-[10px] font-bold py-2 px-3 rounded-xl transition-all">Setujui</button>
                                            </form>
                                            <form action="{{ route('petugas.tolak', $p->id) }}" method="POST">
                                                @csrf
                                                <button class="bg-gray-400 hover:bg-gray-500 text-white text-[10px] font-bold py-2 px-3 rounded-xl transition-all">Tolak</button>
                                            </form>
                                        @elseif($p->status == 'disewa' || $p->status == 'pinjam')
                                            <form action="{{ route('petugas.kembali', $p->id) }}" method="POST">
                                                @csrf
                                                <button class="bg-green-500 hover:bg-green-600 text-white text-[10px] font-bold py-2 px-3 rounded-xl transition-all">Selesai/Kembali</button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-gray-400 italic font-bold uppercase">Selesai</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-pink-300 italic">Belum ada data peminjaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>