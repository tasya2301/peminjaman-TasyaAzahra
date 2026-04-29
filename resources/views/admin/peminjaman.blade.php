<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-pink-600 leading-tight no-print">
            {{ __('Daftar Peminjaman Alat') }}
        </h2>
    </x-slot>

    <style>
        @media print {
            /* 1. Sembunyikan Navigasi, Header, Footer, Sidebar, dan Tombol-tombol */
            nav, header, footer, aside, .no-print, [role="navigation"], button, form {
                display: none !important;
            }

            /* 2. Bersihkan Background dan Padding agar muat 1 halaman */
            body, .py-12, .bg-pink-50\/30 {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            @page {
                size: portrait;
                margin: 1cm;
            }

            /* 3. Lebarkan Konten ke seluruh kertas */
            .max-w-7xl {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* 4. Percantik Tabel (Garis Hitam Tegas) */
            .bg-white {
                border: none !important;
                box-shadow: none !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin-top: 10px !important;
                table-layout: fixed !important;
            }

            th, td {
                border: 1px solid black !important;
                padding: 8px !important;
                text-align: left !important;
                font-size: 11px !important; 
                color: black !important;
                word-wrap: break-word !important;
            }

            thead {
                display: table-header-group !important;
                background-color: #f2f2f2 !important;
            }

            /* Sembunyikan kolom AKSI (tombol hapus) saat diprint */
            .no-print-col {
                display: none !important;
            }

            /* 5. Tampilkan Judul Laporan di bagian atas kertas */
            .print-only {
                display: block !important;
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 2px solid black;
                padding-bottom: 10px;
            }
        }

        /* Sembunyikan judul laporan di layar browser biasa */
        .print-only {
            display: none;
        }
    </style>

    <div class="py-12 bg-pink-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="print-only">
                <h1 style="font-size: 20px; font-weight: bold; text-transform: uppercase; margin: 0;">Laporan Peminjaman Alat</h1>
                <p style="font-size: 12px; margin: 5px 0;">Dicetak pada: {{ date('d-m-Y H:i') }}</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-pink-100 flex justify-between items-center no-print">
                <div>
                    <h3 class="font-bold text-xl text-gray-800">Riwayat Peminjaman</h3>
                    <p class="text-sm text-pink-400">Pantau dan kelola data peminjaman alat di sini.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.peminjaman.cetak') }}" target="_blank" class="flex items-center bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-xl transition-all shadow-lg shadow-pink-100 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak PDF
                    </a>

                    <div class="px-6 py-2 bg-pink-50 rounded-full border border-pink-100 text-pink-600 font-bold text-sm">
                        {{ $peminjamans->count() }} Transaksi
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-pink-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase tracking-wider">Nama Alat</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-pink-600 uppercase tracking-wider no-print-col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($peminjamans as $p)
                            <tr class="hover:bg-pink-50/30 transition-colors">
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-gray-800">{{ $p->user->name ?? 'User Dihapus' }}</div>
                                    <div class="text-xs text-pink-300 italic">{{ $p->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-600">
                                    {{ $p->alat->nama_alat ?? 'Alat Tidak Ada' }}
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-500 font-mono">
                                    {{ $p->tgl_pinjam }}
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $p->status == 'dipinjam' ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600' }}">
                                        {{ strtoupper($p->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right no-print-col">
                                    <div class="flex justify-end items-center">
                                        <button type="button" 
                                            onclick="confirmDelete('{{ $p->id }}', 'Peminjaman {{ $p->user->name ?? '' }}')"
                                            class="group p-2 bg-red-50 hover:bg-red-500 rounded-lg transition-all duration-300 shadow-sm border border-red-100">
                                            <svg class="w-5 h-5 text-red-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <form id="delete-form-{{ $p->id }}" action="{{ route('admin.peminjaman.destroy', $p->id) }}" method="POST" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-pink-300 italic">
                                    Belum ada riwayat peminjaman.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data " + name + " akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ec4899', 
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-3xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>