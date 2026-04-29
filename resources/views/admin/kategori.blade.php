<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-pink-600 leading-tight no-print">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <style>
        @media print {
            nav, header, .no-print, button, form {
                display: none !important;
            }
            body, .py-12, .bg-pink-50\/30 {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            @page { size: portrait; margin: 1cm; }
            .max-w-6xl { max-width: 100% !important; width: 100% !important; }
            .bg-white { border: none !important; box-shadow: none !important; }
            table { width: 100% !important; border-collapse: collapse !important; }
            th, td { border: 1px solid black !important; padding: 10px !important; color: black !important; }
            .no-print-col { display: none !important; }
            .print-only { display: block !important; text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        }
        .print-only { display: none; }
    </style>

    <div class="py-12 bg-pink-50/30 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="print-only">
                <h1 style="font-size: 20px; font-weight: bold;">LAPORAN DATA KATEGORI ALAT</h1>
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
                        <h3 class="font-bold text-xl text-gray-800">Tambah Kategori</h3>
                        <p class="text-sm text-pink-400">Buat kategori alat baru di sini.</p>
                    </div>
                </div>

                <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex flex-col md:flex-row gap-4">
                    @csrf
                    <input type="text" name="nama_kategori" placeholder="Nama Kategori (misal: Elektronik, Kayu...)" required 
                        class="flex-1 rounded-xl border-gray-200 shadow-sm focus:border-pink-500 focus:ring-4 focus:ring-pink-100 text-sm py-3 px-4">
                    
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-pink-100 text-sm">
                        Simpan Kategori
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="p-8 border-b border-pink-50 bg-pink-50/50 flex justify-between items-center no-print">
                    <h3 class="font-bold text-xl text-gray-800">Daftar Kategori</h3>
                    <a href="{{ route('admin.kategori.cetak') }}" target="_blank" class="flex items-center bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-xl transition-all shadow-lg text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Kategori
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-pink-50/50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-pink-600 uppercase w-24">ID</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-pink-600 uppercase">Nama Kategori</th>
                                <th class="px-8 py-4 text-right text-xs font-bold text-pink-600 uppercase no-print-col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($kategoris as $k)
                            <tr class="hover:bg-pink-50/30 transition-colors">
                                <td class="px-8 py-5 text-sm text-pink-300 font-mono">#{{ $k->id }}</td>
                                <td class="px-8 py-5 text-sm text-gray-800 font-medium">{{ $k->nama_kategori }}</td>
                                <td class="px-8 py-5 text-right text-sm font-medium no-print-col">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('admin.kategori.edit', $k->id) }}" class="p-2 bg-pink-50 hover:bg-pink-500 rounded-lg text-pink-600 hover:text-white transition-all border border-pink-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <button onclick="confirmDelete('{{ $k->id }}', '{{ $k->nama_kategori }}')" class="p-2 bg-red-50 hover:bg-red-500 rounded-lg text-red-600 hover:text-white transition-all border border-red-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <form id="delete-form-{{ $k->id }}" action="{{ route('admin.kategori.destroy', $k->id) }}" method="POST" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-8 py-12 text-center text-pink-300 italic">Belum ada kategori.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-4 bg-pink-50/50 border-t border-pink-50 text-xs text-pink-400 font-bold no-print">
                    TOTAL: {{ $kategoris->count() }} KATEGORI
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus ' + name + '?',
                text: "Kategori ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ec4899', 
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-3xl' }
            }).then((result) => {
                if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); }
            })
        }
    </script>
</x-app-layout>