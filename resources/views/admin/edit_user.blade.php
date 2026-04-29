<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-pink-600 leading-tight">
            Edit User: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/30 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-pink-100">
                
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-bold text-pink-600 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" required
                            class="w-full rounded-xl border-pink-100 focus:border-pink-500 focus:ring-4 focus:ring-pink-100 py-3 px-4 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-pink-600 mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" required
                            class="w-full rounded-xl border-pink-100 focus:border-pink-500 focus:ring-4 focus:ring-pink-100 py-3 px-4 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-pink-600 mb-2">Role</label>
                        <select name="role" class="w-full rounded-xl border-pink-100 focus:border-pink-500 focus:ring-4 focus:ring-pink-100 py-3 px-4 transition-all">
                            <option value="peminjam" {{ $user->role == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                            <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold px-8 py-3 rounded-xl transition-all shadow-lg shadow-pink-100">
                            Update User
                        </button>
                        <a href="{{ route('admin.user') }}" class="bg-pink-50 hover:bg-pink-100 text-pink-600 font-bold px-8 py-3 rounded-xl transition-all">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>