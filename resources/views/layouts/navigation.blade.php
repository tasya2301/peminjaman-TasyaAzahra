<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LOGO -->
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- MENU DESKTOP -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    {{-- ================= ADMIN ================= --}}
                    @if(Auth::user()->role === 'admin')

                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link :href="route('admin.kategori')" :active="request()->routeIs('admin.kategori')">
                            Kategori
                        </x-nav-link>

                        <x-nav-link :href="route('admin.alat')" :active="request()->routeIs('admin.alat')">
                            Alat
                        </x-nav-link>

                        <x-nav-link :href="route('admin.user')" :active="request()->routeIs('admin.user')">
                            User
                        </x-nav-link>

                        <x-nav-link :href="route('admin.peminjaman')" :active="request()->routeIs('admin.peminjaman')">
                            Peminjaman
                        </x-nav-link>

                    @endif


                    {{-- ================= PEMINJAM ================= --}}
                    @if(Auth::user()->role === 'peminjam')

                        <x-nav-link :href="route('peminjam.dashboard')" :active="request()->routeIs('peminjam.dashboard')">
                            Dashboard
                        </x-nav-link>

                    @endif

                </div>
            </div>

            <!-- USER DROPDOWN -->
            <div class="hidden sm:flex sm:items-center sm:ms-auto">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white rounded-md hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 
                                        10.586l3.293-3.293a1 1 0 
                                        111.414 1.414l-4 4a1 1 0 
                                        01-1.414 0l-4-4a1 1 0 
                                        010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>
                </x-dropdown>
            </div>

            <!-- MOBILE BUTTON -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                            class="inline-flex" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                            class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MENU MOBILE -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            {{-- ADMIN --}}
            @if(Auth::user()->role === 'admin')

                <x-responsive-nav-link :href="route('admin.dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.kategori')">
                    Kategori
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.alat')">
                    Alat
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.user')">
                    User
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.peminjaman')">
                    Peminjaman
                </x-responsive-nav-link>

            @endif

            {{-- PEMINJAM --}}
            @if(Auth::user()->role === 'peminjam')

                <x-responsive-nav-link :href="route('peminjam.dashboard')">
                    Dashboard
                </x-responsive-nav-link>

            @endif

        </div>

        <!-- PROFILE MOBILE -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>

            </div>
        </div>
    </div>
</nav>