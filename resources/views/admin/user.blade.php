<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-pink-600 leading-tight no-print">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <style>
        @media print {
            /* 1. Sembunyikan Navigasi, Header, Footer, Sidebar, Form Tambah, dan Tombol-tombol */
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
            .max-w-6xl {
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

            /* Sembunyikan kolom AKSI (tombol edit/hapus) saat diprint */
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
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="print-only">
                <h1 style="font-size: 20px; font-weight: bold; text-transform: uppercase; margin: 0;">Laporan Data Pengguna</h1>
                <p style="font-size: 12px; margin: 5px 0;">Dicetak pada: {{ date('d-m-Y H:i') }}</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-pink-100 no-print">
                <div class="flex items-center mb-6">
                    <div class="p-2 bg-pink-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800">Tambah Pengguna Baru</h3>
                </div>

                <form action="{{ route('admin.user.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Lengkap" required
                        class="rounded-xl border-gray-200 shadow-sm focus:border-pink-500 focus:ring-4 focus:ring-pink-100 text-sm py-3">
                    
                    <input type="email" name="email" placeholder="Email" required
                        class="rounded-xl border-gray-200 shadow-sm focus:border-pink-500 focus:ring-4 focus:ring-pink-100 text-sm py-3">
                    
                    <input type="password" name="password" placeholder="Password" required
                        class="rounded-xl border-gray-200 shadow-sm focus:border-pink-500 focus:ring-4 focus:ring-pink-100 text-sm py-3">
                    
                    <select name="role" class="rounded-xl border-gray-200 shadow-sm focus:border-pink-500 focus:ring-4 focus:ring-pink-100 text-sm py-3">
                        <option value="peminjam">Peminjam</option>
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>

                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-pink-100 text-sm">
                        Tambah User
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="p-8 border-b border-pink-50 bg-pink-50/50 flex justify-between items-center no-print">
                    <h3 class="font-bold text-xl text-gray-800">Daftar Pengguna</h3>
                    
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.user.cetak') }}" target="_blank" class="flex items-center bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-xl transition-all shadow-lg text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak PDF
                        </a>

                        <div class="px-6 py-2 bg-pink-50 rounded-full border border-pink-100 text-pink-600 font-bold text-sm">
                            {{ $users->count() }} Pengguna
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-pink-50/50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-pink-600 uppercase tracking-wider">Nama</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-pink-600 uppercase tracking-wider">Email</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-pink-600 uppercase tracking-wider">Role</th>
                                <th class="px-8 py-4 text-right text-xs font-bold text-pink-600 uppercase tracking-wider no-print-col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($users as $u)
                            <tr class="hover:bg-pink-50/30 transition-colors">
                                <td class="px-8 py-5 text-sm text-gray-800 font-medium">{{ $u->name }}</td>
                                <td class="px-8 py-5 text-sm text-gray-500">{{ $u->email }}</td>
                                <td class="px-8 py-5 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-pink-100 text-pink-600 uppercase">
                                        {{ $u->role }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right text-sm font-medium no-print-col">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('admin.user.edit', $u->id) }}" 
                                           class="group p-2 bg-pink-50 hover:bg-pink-500 rounded-lg transition-all duration-300 shadow-sm border border-pink-100"
                                           title="Edit User">
                                            <svg class="w-5 h-5 text-pink-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>

                                        <button type="button" 
                                            onclick="confirmDelete('{{ $u->id }}', '{{ $u->name }}')"
                                            class="group p-2 bg-red-50 hover:bg-red-500 rounded-lg transition-all duration-300 shadow-sm border border-red-100"
                                            title="Hapus User">
                                            <svg class="w-5 h-5 text-red-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>

                                        <form id="delete-form-{{ $u->id }}" action="{{ route('admin.user.destroy', $u->id) }}" method="POST" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus ' + name + '?',
                text: "Data yang dihapus nggak bisa balik lagi lho!",
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