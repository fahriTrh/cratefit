@extends('layouts.admin.app')
@section('title', 'Kelola Kurir')

@section('content')

@php
    $kurir = $kurir ?? [
        [
            'id'           => 1,
            'nama'         => 'Budi Santoso',
            'email'        => 'budi@cratefit.id',
            'no_hp'        => '081234567890',
            'avatar'       => 'B',
            'status'       => 'aktif',
            'bergabung'    => 'Januari 2025',
            'kendaraan'    => 'Motor',
            'plat'         => 'BK 1234 AB',
            'wilayah'      => 'Medan Kota',
            'total_antar'  => 62,
            'bulan_ini'    => 11,
            'rating'       => 4.8,
        ],
        [
            'id'           => 2,
            'nama'         => 'Eko Prasetyo',
            'email'        => 'eko@cratefit.id',
            'no_hp'        => '082345678901',
            'avatar'       => 'E',
            'status'       => 'aktif',
            'bergabung'    => 'Februari 2025',
            'kendaraan'    => 'Motor',
            'plat'         => 'BK 5678 CD',
            'wilayah'      => 'Medan Selatan',
            'total_antar'  => 45,
            'bulan_ini'    => 9,
            'rating'       => 4.7,
        ],
        [
            'id'           => 3,
            'nama'         => 'Fajar Hidayat',
            'email'        => 'fajar@cratefit.id',
            'no_hp'        => '083456789012',
            'avatar'       => 'F',
            'status'       => 'nonaktif',
            'bergabung'    => 'Maret 2025',
            'kendaraan'    => 'Sepeda',
            'plat'         => '-',
            'wilayah'      => 'Medan Baru',
            'total_antar'  => 18,
            'bulan_ini'    => 0,
            'rating'       => 4.5,
        ],
        [
            'id'           => 4,
            'nama'         => 'Gilang Ramadhan',
            'email'        => 'gilang@cratefit.id',
            'no_hp'        => '084567890123',
            'avatar'       => 'G',
            'status'       => 'aktif',
            'bergabung'    => 'April 2025',
            'kendaraan'    => 'Motor',
            'plat'         => 'BK 9012 EF',
            'wilayah'      => 'Medan Timur',
            'total_antar'  => 27,
            'bulan_ini'    => 7,
            'rating'       => 4.9,
        ],
    ];

    $totalAktif   = collect($kurir)->where('status', 'aktif')->count();
    $totalNonaktif = collect($kurir)->where('status', 'nonaktif')->count();
    $totalAntar   = collect($kurir)->sum('total_antar');
    $rataRating   = collect($kurir)->avg('rating');
@endphp

<div class="fade-in">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-crate-orange font-script text-lg mb-0.5">Panel Admin</p>
            <h1 class="font-display text-3xl text-crate-brown font-bold">Kelola Kurir</h1>
            <p class="text-crate-stone font-body mt-1 text-sm">
                Manajemen akun dan performa tim kurir pengiriman Cratefit.
            </p>
        </div>
        <a href="{{ url('/admin/kurir/tambah') }}"
           class="btn-primary text-white font-body font-semibold px-6 py-3 rounded-2xl text-sm
                  shadow-lg text-center shrink-0 flex items-center gap-2">
            <span>+</span> Tambah Kurir
        </a>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        @php
        $stats = [
            ['label' => 'Total Kurir',      'value' => count($kurir),              'icon' => '🚚', 'color' => 'text-crate-brown'],
            ['label' => 'Kurir Aktif',      'value' => $totalAktif,                'icon' => '✅', 'color' => 'text-emerald-600'],
            ['label' => 'Total Pengiriman', 'value' => $totalAntar,                'icon' => '📬', 'color' => 'text-crate-orange'],
            ['label' => 'Rata-rata Rating', 'value' => number_format($rataRating, 1), 'icon' => '⭐', 'color' => 'text-amber-500'],
        ];
        @endphp
        @foreach($stats as $stat)
        <div class="card-wood rounded-2xl p-4">
            <span class="text-xl block mb-1">{{ $stat['icon'] }}</span>
            <p class="font-display text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            <p class="text-crate-stone text-xs font-body mt-0.5">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="card-wood rounded-2xl p-4 mb-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-stone text-sm">🔍</span>
                <input type="text"
                       placeholder="Cari nama / email kurir..."
                       class="pl-9 pr-4 py-2.5 rounded-xl border border-crate-sand bg-white
                              text-sm font-body text-crate-brown placeholder-crate-stone w-full transition-all">
            </div>
            <select class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
            <select class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all">
                <option value="">Semua Kendaraan</option>
                <option value="motor">Motor</option>
                <option value="sepeda">Sepeda</option>
            </select>
            <select class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all">
                <option value="">Urutkan: Terbaru</option>
                <option value="antar">Total Antar ↓</option>
                <option value="rating">Rating ↓</option>
                <option value="nama">Nama A–Z</option>
            </select>
        </div>
    </div>

    {{-- TABEL KURIR --}}
    <div class="card-wood rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base font-bold text-crate-brown">Daftar Kurir</h2>
            <span class="text-crate-stone text-xs font-body">
                {{ count($kurir) }} kurir terdaftar
            </span>
        </div>

        <div class="divide-y divide-crate-sand/60">
            @forelse($kurir as $k)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-crate-cream/50 transition-colors group">

                {{-- Avatar --}}
                <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0
                            text-white font-display font-bold text-sm
                            {{ $k['status'] === 'aktif' ? 'bg-crate-orange' : 'bg-crate-stone' }}">
                    {{ $k['avatar'] }}
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-0.5">
                        <p class="font-body font-semibold text-crate-brown text-sm">{{ $k['nama'] }}</p>
                        <span class="text-xs font-body font-semibold px-2 py-0.5 rounded-full
                            {{ $k['status'] === 'aktif'
                                ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                : 'bg-crate-sand text-crate-stone border border-crate-stone/20' }}">
                            {{ $k['status'] === 'aktif' ? '● Aktif' : '○ Nonaktif' }}
                        </span>
                    </div>
                    <p class="text-crate-stone text-xs font-body">{{ $k['email'] }}</p>
                    <div class="flex items-center gap-3 mt-1 flex-wrap">
                        <span class="text-crate-stone text-xs font-body">
                            🏍️ {{ $k['kendaraan'] }}
                            @if($k['plat'] !== '-')
                                · {{ $k['plat'] }}
                            @endif
                        </span>
                        <span class="text-crate-stone text-xs font-body">
                            📍 {{ $k['wilayah'] }}
                        </span>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="hidden md:flex items-center gap-6 shrink-0">
                    <div class="text-center">
                        <p class="font-display font-bold text-crate-orange text-lg">
                            {{ $k['total_antar'] }}
                        </p>
                        <p class="text-crate-stone text-xs font-body">Total Antar</p>
                    </div>
                    <div class="text-center">
                        <p class="font-display font-bold text-crate-brown text-lg">
                            {{ $k['bulan_ini'] }}
                        </p>
                        <p class="text-crate-stone text-xs font-body">Bulan Ini</p>
                    </div>
                    <div class="text-center">
                        <p class="font-display font-bold text-amber-500 text-lg">
                            {{ $k['rating'] }}
                        </p>
                        <p class="text-crate-stone text-xs font-body">⭐ Rating</p>
                    </div>
                </div>

                {{-- Bergabung --}}
                <div class="hidden sm:block text-right shrink-0">
                    <p class="text-crate-stone text-xs font-body">Bergabung</p>
                    <p class="text-crate-brown font-semibold text-xs font-body">{{ $k['bergabung'] }}</p>
                </div>

                {{-- Aksi --}}
                <div class="flex items-center gap-2 shrink-0 opacity-0 group-hover:opacity-100 transition-all">

                    {{-- Detail --}}
                    <a href="{{ url('/admin/kurir/' . $k['id']) }}"
                       title="Detail"
                       class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                              text-crate-stone hover:text-crate-brown hover:bg-crate-sand transition-colors text-sm">
                        👁
                    </a>

                    {{-- Edit --}}
                    <a href="{{ url('/admin/kurir/' . $k['id'] . '/edit') }}"
                       title="Edit"
                       class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                              text-crate-stone hover:text-crate-brown hover:bg-crate-sand transition-colors text-sm">
                        ✏️
                    </a>

                    {{-- Toggle Status --}}
                    <form action="{{ url('/admin/kurir/' . $k['id'] . '/toggle-status') }}"
                          method="POST"
                          onsubmit="return confirm('Ubah status kurir ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                title="{{ $k['status'] === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                                       text-crate-stone hover:bg-crate-sand transition-colors text-sm
                                       {{ $k['status'] === 'aktif' ? 'hover:text-red-500' : 'hover:text-emerald-600' }}">
                            {{ $k['status'] === 'aktif' ? '🔴' : '🟢' }}
                        </button>
                    </form>

                    {{-- Hapus --}}
                    <form action="{{ url('/admin/kurir/' . $k['id']) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus kurir {{ $k['nama'] }}? Tindakan ini tidak bisa dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                title="Hapus"
                                class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                                       text-crate-stone hover:text-red-600 hover:bg-red-50
                                       hover:border-red-200 transition-colors text-sm">
                            🗑
                        </button>
                    </form>

                </div>

            </div>
            @empty
            <div class="px-6 py-16 text-center">
                <p class="text-4xl mb-3">🚚</p>
                <p class="text-crate-brown font-display text-lg font-bold">Belum ada kurir</p>
                <p class="text-crate-stone text-sm font-body mt-1">
                    Tambahkan kurir baru untuk memulai pengiriman box.
                </p>
                <a href="{{ url('/admin/kurir/tambah') }}"
                   class="inline-block mt-4 btn-primary text-white font-body font-semibold
                          px-6 py-2.5 rounded-xl text-sm">
                    + Tambah Kurir
                </a>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-crate-sand flex items-center justify-between">
            <p class="text-crate-stone text-xs font-body">Halaman 1 dari 1</p>
            <div class="flex gap-2">
                <button disabled
                        class="px-3 py-1.5 rounded-lg border border-crate-sand text-xs font-body
                               text-crate-stone disabled:opacity-40">
                    ← Sebelumnya
                </button>
                <button disabled
                        class="px-3 py-1.5 rounded-lg border border-crate-sand text-xs font-body
                               text-crate-stone disabled:opacity-40">
                    Berikutnya →
                </button>
            </div>
        </div>

    </div>

</div>
@endsection