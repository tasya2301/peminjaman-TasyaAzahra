<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-pink-600 leading-tight no-print">
            {{ __('Manajemen Alat & Inventaris') }}
        </h2>
    </x-slot>

    <style>
        @media print {
            nav, header, footer, aside, .no-print, [role="navigation"], button, form { display: none !important; }
            body, .py-12, .bg-pink-50\/30 { background: white !important; padding: 0 !important; margin: 0 !important; }
            @page { size: landscape; margin: 1cm; }
            .max-w-7xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; }
            table { width: 100% !important; border-collapse: collapse !important; margin-top: 10px !important; }
            th, td { border: 1px solid black !important; padding: 8px !important; text-align: left !important; font-size: 10px !important; color: black !important; }
            .no-print-col { display: none !important; }
            .print-only { display: block !important; text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        }
        .print-only { display: none; }
    </style>

    <div class="py-12 bg-pink-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="print-only">
                <h1 style="font-size: 20px; font-weight: bold; text-transform: uppercase;">Laporan Inventaris Alat</h1>
                <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-pink-100 no-print">
                <div class="flex items-center mb-6">
                    <div class="p-2 bg-pink-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-gray-800">Tambah Alat Baru</h3>
                    </div>
                </div>

                <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    @csrf
                    <input type="text" name="nama_alat" placeholder="Nama Alat" required class="rounded-xl border-gray-200 text-sm py-3 px-4">
                    <select name="kategori_id" required class="rounded-xl border-gray-200 text-sm py-3 px-4">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="harga_per_hari" placeholder="Harga/Hari" required class="rounded-xl border-gray-200 text-sm py-3 px-4">
                    <input type="number" name="stok" placeholder="Stok" required class="rounded-xl border-gray-200 text-sm py-3 px-4">
                    <input type="file" name="foto" accept="image/*" class="rounded-xl border-gray-200 text-sm py-3 px-4">
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-4 rounded-xl text-sm">Simpan</button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="p-8 bg-pink-50/50 flex justify-between items-center no-print">
                    <h3 class="font-bold text-xl text-gray-800">Daftar Inventaris</h3>
                    <button onclick="window.print()" class="bg-pink-600 text-white px-4 py-2 rounded-xl text-sm font-bold">Cetak Laporan</button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-pink-50/50">
                            <tr>
                                <th class="px-8 py-4 text-pink-600">Foto</th>
                                <th class="px-8 py-4 text-pink-600">Alat</th>
                                <th class="px-8 py-4 text-pink-600">Kategori</th>
                                <th class="px-8 py-4 text-pink-600">Harga</th>
                                <th class="px-8 py-4 text-pink-600">Stok</th>
                                <th class="px-8 py-4 text-right text-pink-600 no-print-col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($alats as $a)
                        <tr>
                            <td class="px-8 py-5">
                                @if($a->foto)
                                    <img src="{{ asset('storage/'.$a->foto) }}" class="w-16 h-16 object-cover rounded-xl border">
                                @else
                                    <span class="text-xs text-gray-400 italic">No Image</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 font-bold text-gray-800">{{ $a->nama_alat }}</td>
                            <td class="px-8 py-5">{{ $a->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-8 py-5">Rp {{ number_format($a->harga_per_hari, 0, ',', '.') }}</td>
                            <td class="px-8 py-5">{{ $a->stok }} Unit</td>
                            <td class="px-8 py-5 text-right no-print-col">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.alat.edit', $a->id) }}" class="p-2 bg-pink-50 text-pink-600 rounded-lg">✏️</a>
                                    
                                    <button onclick="confirmDelete('{{ $a->id }}', '{{ $a->nama_alat }}')" class="p-2 bg-red-50 text-red-600 rounded-lg">🗑️</button>
                                    
                                    <form id="delete-form-{{ $a->id }}" action="{{ route('admin.alat.destroy', $a->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-10">Data Kosong</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus ' + name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ec4899',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>