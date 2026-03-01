<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'UMKM Padang'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-xl font-bold text-green-600">UMKM</span>
                    <span class="text-xl font-bold text-gray-800">Padang</span>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-green-600 text-sm font-medium {{ request()->routeIs('home') ? 'text-green-600' : '' }}">Beranda</a>
                    <a href="{{ route('katalog') }}" class="text-gray-600 hover:text-green-600 text-sm font-medium {{ request()->routeIs('katalog*') ? 'text-green-600' : '' }}">Katalog</a>
                    <a href="{{ route('umkm.index') }}" class="text-gray-600 hover:text-green-600 text-sm font-medium {{ request()->routeIs('umkm.*') ? 'text-green-600' : '' }}">UMKM</a>
                    <a href="{{ route('peta') }}" class="text-gray-600 hover:text-green-600 text-sm font-medium {{ request()->routeIs('peta') ? 'text-green-600' : '' }}">Peta</a>
                    <a href="{{ route('tentang') }}" class="text-gray-600 hover:text-green-600 text-sm font-medium {{ request()->routeIs('tentang') ? 'text-green-600' : '' }}">Tentang</a>
                </div>

                <!-- Auth -->
                <div class="flex items-center space-x-3">
                    @auth
                        @php $role = auth()->user()->role; @endphp
                        @if($role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-green-600">Dashboard</a>
                        @elseif($role === 'umkm')
                            <a href="{{ route('umkm.dashboard') }}" class="text-sm text-gray-600 hover:text-green-600">Dashboard</a>
                        @elseif($role === 'customer')
                            <a href="{{ route('customer.dashboard') }}" class="text-sm text-gray-600 hover:text-green-600">Dashboard</a>
                        @elseif($role === 'dinas')
                            <a href="{{ route('dinas.dashboard') }}" class="text-sm text-gray-600 hover:text-green-600">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-500 hover:text-red-700">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-green-600">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-white font-bold text-lg mb-3">UMKM Padang</h3>
                    <p class="text-sm">Platform digital untuk mendukung dan mempromosikan UMKM lokal Kota Padang.</p>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-3">Tautan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('katalog') }}" class="hover:text-white">Katalog Produk</a></li>
                        <li><a href="{{ route('umkm.index') }}" class="hover:text-white">Direktori UMKM</a></li>
                        <li><a href="{{ route('peta') }}" class="hover:text-white">Peta UMKM</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:text-white">Tentang Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold text-lg mb-3">Kontak</h3>
                    <p class="text-sm">Dinas Koperasi dan UMKM Kota Padang</p>
                    <p class="text-sm mt-1">Padang, Sumatera Barat</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm">
                <p>&copy; {{ date('Y') }} UMKM Padang. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>