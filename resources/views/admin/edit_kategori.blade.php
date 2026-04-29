<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-pink-600 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 bg-pink-100 border-l-4 border-pink-500 text-pink-700 shadow-sm rounded-r-lg" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-pink-100 p-8">
                <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-pink-600 mb-2">Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}"
                            class="w-full rounded-xl border-pink-100 shadow-sm focus:border-pink-500 focus:ring-4 focus:ring-pink-100 text-sm py-3 px-4 transition-all"
                            required>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" 
                            onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan ini?')"
                            class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-8 rounded-xl text-sm transition-all shadow-lg shadow-pink-100">
                            Update
                        </button>

                        <a href="{{ route('admin.kategori') }}" class="text-sm font-medium text-pink-400 hover:text-pink-600 hover:underline transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>