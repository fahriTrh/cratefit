@extends('layouts.admin.app')
@section('title', 'Kelola Pelanggan')

@section('content')

@php
    $pelanggan = $pelanggan ?? [
        [
            'id'          => 1,
            'nama'        => 'Aulia Ramadhani',
            'email'       => 'aulia@gmail.com',
            'no_hp'       => '081234567890',
            'avatar'      => 'A',
            'status'      => 'aktif',
            'bergabung'   => 'Januari 2025',
            'paket'       => 'Style Box',
            'total_order' => 6,
            'alamat'      => 'Medan, Sumatera Utara',
        ],
        [
            'id'          => 2,
            'nama'        => 'Bintang Pratama',
            'email'       => 'bintang@gmail.com',
            'no_hp'       => '082345678901',
            'avatar'      => 'B',
            'status'      => 'aktif',
            'bergabung'   => 'Februari 2025',
            'paket'       => 'Starter Box',
            'total_order' => 4,
            'alamat'      => 'Jakarta Selatan, DKI Jakarta',
        ],
        [
            'id'          => 3,
            'nama'        => 'Citra Dewi',
            'email'       => 'citra@gmail.com',
            'no_hp'       => '083456789012',
            'avatar'      => 'C',
            'status'      => 'nonaktif',
            'bergabung'   => 'Maret 2025',
            'paket'       => null,
            'total_order' => 1,
            'alamat'      => 'Bandung, Jawa Barat',
        ],
        [
            'id'          => 4,
            'nama'        => 'Dafi Maulana',
            'email'       => 'dafi@gmail.com',
            'no_hp'       => '084567890123',
            'avatar'      => 'D',
            'status'      => 'aktif',
            'bergabung'   => 'April 2025',
            'paket'       => 'Premium Box',
            'total_order' => 3,
            'alamat'      => 'Surabaya, Jawa Timur',
        ],
        [
            'id'          => 5,
            'nama'        => 'Elisa Nuraini',
            'email'       => 'elisa@gmail.com',
            'no_hp'       => '085678901234',
            'avatar'      => 'E',
            'status'      => 'aktif',
            'bergabung'   => 'Mei 2025',
            'paket'       => 'Starter Box',
            'total_order' => 2,
            'alamat'      => 'Yogyakarta, DIY',
        ],
    ];

    $totalAktif    = collect($pelanggan)->where('status', 'aktif')->count();
    $totalNonaktif = collect($pelanggan)->where('status', 'nonaktif')->count();
    $totalOrder    = collect($pelanggan)->sum('total_order');
@endphp

<div class="fade-in">

    {{-- HEADER --}}
    <div class="mb-6">
        <p class="text-crate-orange font-script text-lg mb-0.5">Panel Admin</p>
        <h1 class="font-display text-3xl text-crate-brown font-bold">Kelola Pelanggan</h1>
        <p class="text-crate-stone font-body mt-1 text-sm">
            Daftar seluruh pelanggan terdaftar di Cratefit.
        </p>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        @php
        $stats = [
            ['label' => 'Total Pelanggan',  'value' => count($pelanggan), 'icon' => '👥',  'color' => 'text-crate-brown'],
            ['label' => 'Pelanggan Aktif',  'value' => $totalAktif,       'icon' => '✅',  'color' => 'text-emerald-600'],
            ['label' => 'Tidak Aktif',      'value' => $totalNonaktif,    'icon' => '⏸️',  'color' => 'text-crate-stone'],
            ['label' => 'Total Langganan',  'value' => $totalOrder,       'icon' => '📦',  'color' => 'text-crate-orange'],
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
                       placeholder="Cari nama / email pelanggan..."
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
                <option value="">Semua Paket</option>
                <option value="starter">Starter Box</option>
                <option value="style">Style Box</option>
                <option value="premium">Premium Box</option>
            </select>
            <select class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all">
                <option value="">Urutkan: Terbaru</option>
                <option value="nama">Nama A–Z</option>
                <option value="order">Total Order ↓</option>
            </select>
        </div>
    </div>

    {{-- TABEL PELANGGAN --}}
    <div class="card-wood rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base font-bold text-crate-brown">Daftar Pelanggan</h2>
            <span class="text-crate-stone text-xs font-body">{{ count($pelanggan) }} pelanggan terdaftar</span>
        </div>

        <div class="divide-y divide-crate-sand/60">
            @forelse($pelanggan as $p)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-crate-cream/50 transition-colors group">

                {{-- Avatar --}}
                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0
                            text-white font-display font-bold text-sm
                            {{ $p['status'] === 'aktif' ? 'bg-crate-orange' : 'bg-crate-stone' }}">
                    {{ $p['avatar'] }}
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-0.5">
                        <p class="font-body font-semibold text-crate-brown text-sm">{{ $p['nama'] }}</p>
                        <span class="text-xs font-body font-semibold px-2 py-0.5 rounded-full
                            {{ $p['status'] === 'aktif'
                                ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                : 'bg-crate-sand text-crate-stone border border-crate-stone/20' }}">
                            {{ $p['status'] === 'aktif' ? '● Aktif' : '○ Nonaktif' }}
                        </span>
                    </div>
                    <p class="text-crate-stone text-xs font-body">{{ $p['email'] }}</p>
                    <p class="text-crate-stone text-xs font-body mt-0.5">📍 {{ $p['alamat'] }}</p>
                </div>

                {{-- Paket & Order --}}
                <div class="hidden md:flex items-center gap-6 shrink-0">
                    <div class="text-center">
                        @if($p['paket'])
                        <p class="text-xs font-body font-semibold text-crate-orange
                                  bg-crate-orange/10 border border-crate-orange/20
                                  px-3 py-1 rounded-full">
                            {{ $p['paket'] }}
                        </p>
                        @else
                        <p class="text-xs font-body text-crate-stone italic">Tidak berlangganan</p>
                        @endif
                    </div>
                    <div class="text-center">
                        <p class="font-display font-bold text-crate-brown text-lg">{{ $p['total_order'] }}</p>
                        <p class="text-crate-stone text-xs font-body">Total Order</p>
                    </div>
                </div>

                {{-- Bergabung --}}
                <div class="hidden sm:block text-right shrink-0">
                    <p class="text-crate-stone text-xs font-body">Bergabung</p>
                    <p class="text-crate-brown font-semibold text-xs font-body">{{ $p['bergabung'] }}</p>
                </div>

                {{-- Aksi --}}
                <div class="flex items-center gap-2 shrink-0 opacity-0 group-hover:opacity-100 transition-all">

                    {{-- Detail --}}
                    <a href="{{ url('/admin/pelanggan/' . $p['id']) }}"
                       title="Lihat Detail"
                       class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                              text-crate-stone hover:text-crate-brown hover:bg-crate-sand transition-colors text-sm">
                        👁
                    </a>

                    {{-- Hapus --}}
                    <form action="{{ url('/admin/pelanggan/' . $p['id']) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus pelanggan {{ $p['nama'] }}? Tindakan ini tidak bisa dibatalkan.')">
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
                <p class="text-4xl mb-3">👥</p>
                <p class="text-crate-brown font-display text-lg font-bold">Belum ada pelanggan</p>
                <p class="text-crate-stone text-sm font-body mt-1">
                    Pelanggan yang mendaftar akan muncul di sini.
                </p>
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