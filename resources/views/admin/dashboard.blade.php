<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-pink-600 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/30 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- WELCOME -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-pink-100">
                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    Selamat Datang, Admin 👋
                </h3>
                <p class="text-sm text-gray-500">
                    Kelola data alat, kategori, user, dan peminjaman dengan mudah.
                </p>
            </div>

            <!-- MENU CARD -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- KATEGORI -->
                <a href="{{ route('admin.kategori') }}" 
                   class="bg-white p-6 rounded-2xl shadow-sm border border-pink-100 hover:border-pink-300 transition">
                    <div class="flex items-center">
                        <div class="p-3 bg-pink-100 rounded-lg mr-4">
                            📁
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Kategori</h4>
                            <p class="text-sm text-gray-500">Kelola kategori alat</p>
                        </div>
                    </div>
                </a>

                <!-- ALAT -->
                <a href="{{ route('admin.alat') }}" 
                   class="bg-white p-6 rounded-2xl shadow-sm border border-pink-100 hover:border-pink-300 transition">
                    <div class="flex items-center">
                        <div class="p-3 bg-pink-100 rounded-lg mr-4">
                            🛠️
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Alat</h4>
                            <p class="text-sm text-gray-500">Kelola data alat</p>
                        </div>
                    </div>
                </a>

                <!-- USER -->
                <a href="{{ route('admin.user') }}" 
                   class="bg-white p-6 rounded-2xl shadow-sm border border-pink-100 hover:border-pink-300 transition">
                    <div class="flex items-center">
                        <div class="p-3 bg-pink-100 rounded-lg mr-4">
                            👤
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">User</h4>
                            <p class="text-sm text-gray-500">Kelola pengguna</p>
                        </div>
                    </div>
                </a>

                <!-- PEMINJAMAN -->
                <a href="{{ route('admin.peminjaman') }}" 
                   class="bg-white p-6 rounded-2xl shadow-sm border border-pink-100 hover:border-pink-300 transition">
                    <div class="flex items-center">
                        <div class="p-3 bg-pink-100 rounded-lg mr-4">
                            📦
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Peminjaman</h4>
                            <p class="text-sm text-gray-500">Data peminjaman</p>
                        </div>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>