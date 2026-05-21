@extends('layouts.admin.app')
@section('title', 'Kelola Kurator')

@section('content')

@php
    $kurators = $kurators ?? [
        [
            'id'           => 1,
            'nama'         => 'Sari Indah Lestari',
            'email'        => 'sari@cratefit.id',
            'no_hp'        => '081234567890',
            'avatar'       => 'S',
            'status'       => 'aktif',
            'bergabung'    => 'Januari 2025',
            'total_kurasi' => 48,
            'bulan_ini'    => 8,
            'rating'       => 4.9,
            'spesialisasi' => ['Casual', 'Minimalis', 'Vintage'],
        ],
        [
            'id'           => 2,
            'nama'         => 'Rizky Fajar Nugroho',
            'email'        => 'rizky@cratefit.id',
            'no_hp'        => '082345678901',
            'avatar'       => 'R',
            'status'       => 'aktif',
            'bergabung'    => 'Februari 2025',
            'total_kurasi' => 31,
            'bulan_ini'    => 5,
            'rating'       => 4.7,
            'spesialisasi' => ['Streetwear', 'Eclectic', 'Smart Casual'],
        ],
        [
            'id'           => 3,
            'nama'         => 'Dinda Permata Sari',
            'email'        => 'dinda@cratefit.id',
            'no_hp'        => '083456789012',
            'avatar'       => 'D',
            'status'       => 'nonaktif',
            'bergabung'    => 'Maret 2025',
            'total_kurasi' => 12,
            'bulan_ini'    => 0,
            'rating'       => 4.5,
            'spesialisasi' => ['Feminine', 'Boho'],
        ],
        [
            'id'           => 4,
            'nama'         => 'Ahmad Fauzan',
            'email'        => 'fauzan@cratefit.id',
            'no_hp'        => '084567890123',
            'avatar'       => 'A',
            'status'       => 'aktif',
            'bergabung'    => 'April 2025',
            'total_kurasi' => 19,
            'bulan_ini'    => 6,
            'rating'       => 4.8,
            'spesialisasi' => ['Casual', 'Boho', 'Smart Casual'],
        ],
    ];

    $totalAktif    = collect($kurators)->where('status', 'aktif')->count();
    $totalNonaktif = collect($kurators)->where('status', 'nonaktif')->count();
    $totalKurasi   = collect($kurators)->sum('total_kurasi');
    $rataRating    = collect($kurators)->avg('rating');
@endphp

<div class="fade-in">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-crate-orange font-script text-lg mb-0.5">Panel Admin</p>
            <h1 class="font-display text-3xl text-crate-brown font-bold">Kelola Kurator</h1>
            <p class="text-crate-stone font-body mt-1 text-sm">Manajemen akun dan performa tim kurator fashion Cratefit.</p>
        </div>
        <a href="{{ url('/admin/kurator/tambah') }}"
           class="btn-primary text-white font-body font-semibold px-6 py-3 rounded-2xl text-sm
                  shadow-lg text-center shrink-0 flex items-center gap-2">
            <span>+</span> Tambah Kurator
        </a>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        @php
        $stats = [
            ['label' => 'Total Kurator',    'value' => count($kurators),            'icon' => '✂️',  'color' => 'text-crate-brown'],
            ['label' => 'Kurator Aktif',    'value' => $totalAktif,                 'icon' => '✅',  'color' => 'text-emerald-600'],
            ['label' => 'Total Kurasi',     'value' => $totalKurasi,                'icon' => '📦', 'color' => 'text-crate-orange'],
            ['label' => 'Rata-rata Rating', 'value' => number_format($rataRating, 1), 'icon' => '⭐', 'color' => 'text-amber-500'],
        ];
        @endphp
        @foreach($stats as $stat)
        <div class="card-wood rounded-2xl p-4">
            <div class="flex items-center justify-between mb-1">
                <span class="text-xl">{{ $stat['icon'] }}</span>
            </div>
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
                <input type="text" placeholder="Cari nama / email kurator..."
                       class="pl-9 pr-4 py-2.5 rounded-xl border border-crate-sand bg-white text-sm font-body
                              text-crate-brown placeholder-crate-stone w-full transition-all">
            </div>
            <select class="border border-crate-sand bg-white rounded-xl px-3 py-2.5 text-sm font-body text-crate-brown transition-all">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
            <select class="border border-crate-sand bg-white rounded-xl px-3 py-2.5 text-sm font-body text-crate-brown transition-all">
                <option value="">Urutkan: Terbaru</option>
                <option value="kurasi">Total Kurasi ↓</option>
                <option value="rating">Rating ↓</option>
                <option value="nama">Nama A–Z</option>
            </select>
        </div>
    </div>

    {{-- TABEL KURATOR --}}
    <div class="card-wood rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base font-bold text-crate-brown">Daftar Kurator</h2>
            <span class="text-crate-stone text-xs font-body">{{ count($kurators) }} kurator terdaftar</span>
        </div>

        <div class="divide-y divide-crate-sand/60">
            @forelse($kurators as $k)
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
                    <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                        @foreach($k['spesialisasi'] as $sp)
                        <span class="bg-crate-sand text-crate-brown text-xs font-body px-2 py-0.5 rounded-full">
                            {{ $sp }}
                        </span>
                        @endforeach
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="hidden md:flex items-center gap-6 shrink-0">
                    <div class="text-center">
                        <p class="font-display font-bold text-crate-orange text-lg">{{ $k['total_kurasi'] }}</p>
                        <p class="text-crate-stone text-xs font-body">Total Kurasi</p>
                    </div>
                    <div class="text-center">
                        <p class="font-display font-bold text-crate-brown text-lg">{{ $k['bulan_ini'] }}</p>
                        <p class="text-crate-stone text-xs font-body">Bulan Ini</p>
                    </div>
                    <div class="text-center">
                        <p class="font-display font-bold text-amber-500 text-lg">{{ $k['rating'] }}</p>
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
                    <a href="{{ url('/admin/kurator/' . $k['id']) }}"
                       title="Detail"
                       class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                              text-crate-stone hover:text-crate-brown hover:bg-crate-sand transition-colors text-sm">
                        👁
                    </a>
                    <a href="{{ url('/admin/kurator/' . $k['id'] . '/edit') }}"
                       title="Edit"
                       class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                              text-crate-stone hover:text-crate-brown hover:bg-crate-sand transition-colors text-sm">
                        ✏️
                    </a>
                    <form action="{{ url('/admin/kurator/' . $k['id'] . '/toggle-status') }}" method="POST"
                          onsubmit="return confirm('Ubah status kurator ini?')">
                        @csrf @method('PATCH')
                        <button type="submit"
                                title="{{ $k['status'] === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                                       text-crate-stone hover:bg-crate-sand transition-colors text-sm
                                       {{ $k['status'] === 'aktif' ? 'hover:text-red-500' : 'hover:text-emerald-600' }}">
                            {{ $k['status'] === 'aktif' ? '🔴' : '🟢' }}
                        </button>
                    </form>
                    <form action="{{ url('/admin/kurator/' . $k['id']) }}" method="POST"
                          onsubmit="return confirm('Hapus kurator ini? Tindakan tidak bisa dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                title="Hapus"
                                class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                                       text-crate-stone hover:text-red-600 hover:bg-red-50 hover:border-red-200 transition-colors text-sm">
                            🗑
                        </button>
                    </form>
                </div>

            </div>
            @empty
            <div class="px-6 py-16 text-center">
                <p class="text-4xl mb-3">✂️</p>
                <p class="text-crate-brown font-display text-lg font-bold">Belum ada kurator</p>
                <p class="text-crate-stone text-sm font-body mt-1">Tambahkan kurator baru untuk memulai kurasi box.</p>
                <a href="{{ url('/admin/kurator/tambah') }}"
                   class="inline-block mt-4 btn-primary text-white font-body font-semibold px-6 py-2.5 rounded-xl text-sm">
                    + Tambah Kurator
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
                               text-crate-stone disabled:opacity-40">← Sebelumnya</button>
                <button disabled
                        class="px-3 py-1.5 rounded-lg border border-crate-sand text-xs font-body
                               text-crate-stone disabled:opacity-40">Berikutnya →</button>
            </div>
        </div>
    </div>

</div>
@endsection