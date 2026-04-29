<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            {{ __('Dashboard Peminjam') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-pink-400">
                
                <!-- Pesan Sukses -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                 <!-- Pesan Error Stok -->
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!--  PESAN ERROR VALIDASI TANGGAL -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORM PEMINJAMAN -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2 md:mb-0">Ajukan Peminjaman</h3>
                    <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari nama alat..." 
                            class="rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 text-sm w-full md:w-64">
                        <button type="submit" 
                            class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                            Cari
                        </button>
                        @if (request('search'))
                            <a href="{{ route('dashboard') }}" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm flex items-center transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- DAFTAR ALAT -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    @forelse ($alats as $alat)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 hover:border-pink-300 transition">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="font-bold text-lg text-gray-800">{{ $alat->nama_alat }} </h4>
                                <span class="bg-pink-100 text-pink-600 text-xs px-2 py-1 rounded">Stok: 
                                    {{ $alat->stok }}</span>
                            </div>

                                <form action="{{ route('peminjam.pinjam.store') }}" method="POST">                                @csrf
                                <input type="hidden" name="alat_id" value="{{ $alat->id }}">

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Jumlah Pinjam (Maks: {{ $alat->stok }})
                                    </label>
                                    <input type="number" name="jumlah" min="1" max="{{ $alat->stok }}" 
                                        value="1" required 
                                        class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-pink-500 focus:ring-pink-500"> 
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Pinjam</label>
                                    <input type="date" name="tanggal_pinjam" required min="{{ date('Y-m-d') }}" 
                                        class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-pink-500 focus:ring-pink-500"> 
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Kembali</label>
                                    <input type="date" name="tanggal_kembali" required min="{{ date('Y-m-d') }}" 
                                        class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-pink-500 focus:ring-pink-500"> 

                                </div>

                                @if ($alat->stok > 0) 
                                    <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                                        PINJAM
                                    </button>
                                @else 
                                    <button type="button" disabled class="w-full bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded text-sm cursor-not-allowed">
                                        HABIS 
                                    </button>
                                @endif
                            </form>
                        </div>
                    @empty 
                        <div class="col-span-1 md:col-span-3 text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="text-gray-500">Alat tidak ditemukan atau stok kosong.</p>
                        </div>
                    @endforelse
                </div>

                <!-- TABEL RIWAYAT PEMINJAMAN  -->
                <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Peminjaman Saya</h3>
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-pink-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Alat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Jml</th> 
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Durasi Pinjam</th> 
                                    <th class="px-6 py-3 text-left text-xs font-medium text-pink-700 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($riwayats as $r)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $r->alat->nama_alat }} 
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $r->jumlah }} Unit 
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $r->tanggal_pinjam }} <span class="mx-1 text-gray-400">s/d</span> {{ $r->tanggal_kembali }} 
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($r->status == 'menunggu') 
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">MENUNGGU</span> 
                                            @elseif ($r->status == 'disetujui') 
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">DISETUJUI</span>
                                            @elseif($r->status == 'kembali') 
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">KEMBALI</span> 
                                                <div class="text-xs text-gray-400 mt-1">Balik: {{ $r->tgl_dikembalikan }}</div>
                                            @else 
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ strtoupper($r->status) }}</span> 
                                            @endif
                                        </td>
                                    </tr>
                                @empty 
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada riwayat. </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>