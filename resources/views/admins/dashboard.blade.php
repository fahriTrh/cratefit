@extends('layouts.admin.app')
@section('title', 'Dashboard')

@section('content')

<div class="fade-in">

    {{-- ── HEADER ─────────────────────────────────────────────────────── --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <p class="text-crate-orange font-script text-lg mb-0.5">Selamat datang kembali</p>
            <h1 class="font-display text-3xl text-crate-brown font-bold">Dashboard Admin</h1>
            <p class="text-crate-stone font-body mt-1 text-sm">Ringkasan operasional Cratefit — {{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="flex gap-2 shrink-0">
        <a href="{{ url('/admin/kelola-retur') }}"
        class="flex items-center gap-2 bg-white border border-crate-sand text-crate-brown font-body font-semibold px-4 py-2.5 rounded-xl text-sm shadow-sm hover:bg-crate-cream transition-colors">
            <i data-lucide="rotate-ccw" class="w-4 h-4"></i> Kelola Retur
            @if($totalReturMenunggu > 0)
            <span class="bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 leading-none">{{ $totalReturMenunggu }}</span>
            @endif
        </a>
        <a href="{{ url('/admin/inventory') }}"
        class="btn-primary text-white font-body font-semibold px-4 py-2.5 rounded-xl text-sm shadow-lg flex items-center gap-2">
            <i data-lucide="package" class="w-4 h-4"></i> Inventory
            @if($stokHabis > 0)
            <span class="bg-white/30 text-white text-xs rounded-full px-1.5 py-0.5 leading-none">{{ $stokHabis }} habis</span>
            @endif
        </a>
        </div>
    </div>

    {{-- ── STAT CARDS BARIS 1 : PENGGUNA ──────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
        @php
        $statsPengguna = [
            ['label' => 'Total Pelanggan',   'value' => $totalPelanggan,        'icon' => 'users',        'sub' => '+' . $pelangganBaruBulanIni . ' bulan ini', 'color' => 'text-crate-brown',   'link' => '/admin/pelanggan'],
            ['label' => 'Langganan Aktif',   'value' => $totalLanggananAktif,   'icon' => 'badge-check',  'sub' => $totalLanggananBatal . ' dibatalkan',          'color' => 'text-emerald-600',   'link' => '/admin/pelanggan'],
            ['label' => 'Total Kurator',     'value' => $totalKurator,          'icon' => 'scissors',     'sub' => 'Tim kurasi aktif',                            'color' => 'text-crate-orange',  'link' => '/admin/kurator'],
            ['label' => 'Total Kurir',       'value' => $totalKurir,            'icon' => 'truck',        'sub' => 'Armada pengiriman',                           'color' => 'text-admin-blue',    'link' => '/admin/kurir'],
        ];
        @endphp

        @foreach($statsPengguna as $s)
        <a href="{{ url($s['link']) }}" class="card-wood rounded-2xl p-4 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-2">
                <span class="w-9 h-9 rounded-lg bg-crate-cream flex items-center justify-center">
                    <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 {{ $s['color'] }}"></i>
                </span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-crate-stone group-hover:text-crate-orange transition-colors"></i>
            </div>
            <p class="font-display text-3xl font-bold {{ $s['color'] }}">{{ $s['value'] }}</p>
            <p class="text-crate-brown text-xs font-body font-semibold mt-0.5">{{ $s['label'] }}</p>
            <p class="text-crate-stone text-xs font-body mt-0.5">{{ $s['sub'] }}</p>
        </a>
        @endforeach
    </div>

    {{-- ── STAT CARDS BARIS 2 : OPERASIONAL ───────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">

        {{-- Box Pipeline --}}
        <div class="card-wood rounded-2xl p-4 col-span-2">
            <div class="flex items-center gap-2 mb-3">
                <i data-lucide="package" class="w-4 h-4 text-crate-orange"></i>
                <p class="font-body font-semibold text-crate-brown text-sm">Pipeline Box</p>
            </div>
            <div class="grid grid-cols-4 gap-2">
                @php
                $pipeline = [
                    ['label' => 'Menunggu',  'value' => $totalBoxMenunggu,  'color' => 'bg-amber-100 text-amber-700'],
                    ['label' => 'Dikurasi',  'value' => $totalBoxDikurasi,  'color' => 'bg-orange-100 text-orange-700'],
                    ['label' => 'Dikirim',   'value' => $totalBoxDikirim,   'color' => 'bg-blue-100 text-blue-700'],
                    ['label' => 'Tiba',      'value' => $totalBoxSelesai,   'color' => 'bg-emerald-100 text-emerald-700'],
                ];
                @endphp
                @foreach($pipeline as $p)
                <div class="text-center">
                    <span class="inline-block px-2 py-1 rounded-lg text-xs font-semibold {{ $p['color'] }} font-body">
                        {{ $p['label'] }}
                    </span>
                    <p class="font-display text-2xl font-bold text-crate-brown mt-1">{{ $p['value'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Inventory --}}
        <a href="{{ url('/admin/inventory') }}" class="card-wood rounded-2xl p-4 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-2">
                <span class="w-9 h-9 rounded-lg bg-crate-cream flex items-center justify-center">
                    <i data-lucide="archive" class="w-5 h-5 text-crate-brown"></i>
                </span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-crate-stone group-hover:text-crate-orange transition-colors"></i>
            </div>
            <p class="font-display text-3xl font-bold text-crate-brown">{{ $totalInventory }}</p>
            <p class="text-crate-brown text-xs font-body font-semibold mt-0.5">Total Item</p>
            <div class="mt-2 flex gap-1.5 flex-wrap">
                @if($stokHabis > 0)
                <span class="text-xs bg-red-100 text-red-600 rounded-full px-2 py-0.5 font-body font-semibold">{{ $stokHabis }} habis</span>
                @endif
                @if($stokRendah > 0)
                <span class="text-xs bg-amber-100 text-amber-600 rounded-full px-2 py-0.5 font-body font-semibold">{{ $stokRendah }} rendah</span>
                @endif
                @if($stokHabis == 0 && $stokRendah == 0)
                <span class="text-xs bg-emerald-100 text-emerald-600 rounded-full px-2 py-0.5 font-body font-semibold">✓ Stok aman</span>
                @endif
            </div>
        </a>

        {{-- Retur --}}
        <a href="{{ url('/admin/kelola-retur') }}" class="card-wood rounded-2xl p-4 hover:shadow-md transition-shadow group">
            <div class="flex items-start justify-between mb-2">
                <span class="w-9 h-9 rounded-lg bg-crate-cream flex items-center justify-center">
                    <i data-lucide="rotate-ccw" class="w-5 h-5 {{ $totalReturMenunggu > 0 ? 'text-red-500' : 'text-crate-brown' }}"></i>
                </span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 text-crate-stone group-hover:text-crate-orange transition-colors"></i>
            </div>
            <p class="font-display text-3xl font-bold {{ $totalReturMenunggu > 0 ? 'text-red-500' : 'text-crate-brown' }}">{{ $totalReturMenunggu + $totalReturProses }}</p>
            <p class="text-crate-brown text-xs font-body font-semibold mt-0.5">Retur Aktif</p>
            <div class="mt-2 flex gap-1.5 flex-wrap">
                @if($totalReturMenunggu > 0)
                <span class="text-xs bg-red-100 text-red-600 rounded-full px-2 py-0.5 font-body font-semibold">{{ $totalReturMenunggu }} menunggu</span>
                @endif
                <span class="text-xs bg-gray-100 text-gray-600 rounded-full px-2 py-0.5 font-body">{{ $totalReturSelesai }} selesai</span>
            </div>
        </a>

    </div>

    {{-- ── MAIN CONTENT : TABEL + GRAFIK ──────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Kolom Kiri: Box Terbaru + Pelanggan Baru ──────────────────── --}}
        <div class="lg:col-span-2 flex flex-col gap-4">

            {{-- Grafik Langganan --}}
            <div class="card-wood rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="font-body font-semibold text-crate-brown">Tren Langganan Baru</p>
                        <p class="text-crate-stone text-xs font-body">6 bulan terakhir</p>
                    </div>
                    <i data-lucide="trending-up" class="w-6 h-6 text-crate-orange"></i>
                </div>
                @php
                $maxGrafik = $grafikLangganan->max('total') ?: 1;
                @endphp
                <div class="flex items-end gap-2 h-28">
                    @foreach($grafikLangganan as $data)
                    @php $pct = ($data['total'] / $maxGrafik) * 100; @endphp
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <span class="text-xs font-body font-semibold text-crate-brown">{{ $data['total'] ?: '' }}</span>
                        <div class="w-full rounded-t-lg bg-crate-sand overflow-hidden" style="height: 72px;">
                            <div class="w-full rounded-t-lg transition-all duration-700"
                                 style="height: {{ $pct }}%; background: linear-gradient(to top, #3B1F0E, #C85A1A); margin-top: auto;">
                            </div>
                        </div>
                        <span class="text-xs text-crate-stone font-body">{{ $data['bulan'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Box Terbaru --}}
            <div class="card-wood rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="font-body font-semibold text-crate-brown">Box Terbaru</p>
                        <p class="text-crate-stone text-xs font-body">6 box paling baru dibuat</p>
                    </div>
                    <i data-lucide="package" class="w-6 h-6 text-crate-orange"></i>
                </div>

                @if($boxTerbaru->isEmpty())
                <p class="text-crate-stone text-sm font-body text-center py-6">Belum ada data box.</p>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm font-body">
                        <thead>
                            <tr class="border-b border-crate-sand">
                                <th class="text-left py-2 text-crate-stone font-semibold text-xs uppercase tracking-wide">Kode Box</th>
                                <th class="text-left py-2 text-crate-stone font-semibold text-xs uppercase tracking-wide">Pelanggan</th>
                                <th class="text-left py-2 text-crate-stone font-semibold text-xs uppercase tracking-wide hidden sm:table-cell">Kurator</th>
                                <th class="text-left py-2 text-crate-stone font-semibold text-xs uppercase tracking-wide">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($boxTerbaru as $box)
                            @php
                            $statusBox = [
                                'menunggu_kurasi'  => ['label' => 'Menunggu',  'class' => 'bg-amber-100 text-amber-700'],
                                'sedang_dikurasi'  => ['label' => 'Dikurasi',  'class' => 'bg-orange-100 text-orange-700'],
                                'menunggu_kurir'   => ['label' => 'Cari Kurir','class' => 'bg-yellow-100 text-yellow-700'],
                                'dikirim'          => ['label' => 'Dikirim',   'class' => 'bg-blue-100 text-blue-700'],
                                'tiba'             => ['label' => 'Tiba',      'class' => 'bg-emerald-100 text-emerald-700'],
                                'dibatalkan'       => ['label' => 'Batal',     'class' => 'bg-red-100 text-red-600'],
                            ];
                            $st = $statusBox[$box->status] ?? ['label' => $box->status, 'class' => 'bg-gray-100 text-gray-600'];
                            @endphp
                            <tr class="border-b border-crate-sand/50 hover:bg-crate-cream/50 transition-colors">
                                <td class="py-2.5 font-semibold text-crate-brown text-xs">{{ $box->kode_box ?? '-' }}</td>
                                <td class="py-2.5 text-crate-brown">{{ $box->pelanggan->name ?? '-' }}</td>
                                <td class="py-2.5 text-crate-stone hidden sm:table-cell">{{ $box->kurator->name ?? '—' }}</td>
                                <td class="py-2.5">
                                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $st['class'] }}">{{ $st['label'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

        </div>

        {{-- Kolom Kanan: Pelanggan Baru + Retur Pending ──────────────── --}}
        <div class="flex flex-col gap-4">

            {{-- Pelanggan Baru --}}
            <div class="card-wood rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="font-body font-semibold text-crate-brown">Pelanggan Baru</p>
                        <p class="text-crate-stone text-xs font-body">Terdaftar terakhir</p>
                    </div>
                    <a href="{{ url('/admin/pelanggan') }}" class="text-xs text-crate-orange font-body font-semibold hover:underline">Lihat semua →</a>
                </div>

                @if($pelangganTerbaru->isEmpty())
                <p class="text-crate-stone text-sm font-body text-center py-6">Belum ada pelanggan.</p>
                @else
                <div class="flex flex-col gap-3">
                    @foreach($pelangganTerbaru as $p)
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-crate-sand flex items-center justify-center font-display font-bold text-crate-brown text-sm shrink-0">
                            {{ strtoupper(substr($p->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-body font-semibold text-crate-brown text-sm truncate">{{ $p->name }}</p>
                            <p class="text-crate-stone text-xs font-body truncate">{{ $p->email }}</p>
                        </div>
                        <span class="ml-auto text-xs text-crate-stone font-body shrink-0">{{ $p->created_at->diffForHumans(null, true) }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Retur Menunggu --}}
            <div class="card-wood rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="font-body font-semibold text-crate-brown">Retur Perlu Aksi</p>
                        <p class="text-crate-stone text-xs font-body">Menunggu tindakan admin</p>
                    </div>
                    <a href="{{ url('/admin/kelola-retur') }}" class="text-xs text-crate-orange font-body font-semibold hover:underline">Kelola →</a>
                </div>

                @if($returTerbaru->isEmpty())
                <p class="text-crate-stone text-sm font-body text-center py-6">Tidak ada retur aktif. 🎉</p>
                @else
                <div class="flex flex-col gap-3">
                    @foreach($returTerbaru as $r)
                    @php
                    $statusRetur = [
                        'menunggu'  => ['label' => 'Menunggu',  'class' => 'bg-red-100 text-red-600'],
                        'diproses'  => ['label' => 'Diproses',  'class' => 'bg-orange-100 text-orange-600'],
                        'dijemput'  => ['label' => 'Dijemput',  'class' => 'bg-blue-100 text-blue-600'],
                        'selesai'   => ['label' => 'Selesai',   'class' => 'bg-emerald-100 text-emerald-600'],
                        'ditolak'   => ['label' => 'Ditolak',   'class' => 'bg-gray-100 text-gray-600'],
                    ];
                    $sr = $statusRetur[$r->status] ?? ['label' => $r->status, 'class' => 'bg-gray-100 text-gray-600'];
                    @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                            <i data-lucide="rotate-ccw" class="w-4 h-4 text-red-500"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-body font-semibold text-crate-brown text-sm truncate">{{ $r->user->name ?? '-' }}</p>
                            <p class="text-crate-stone text-xs font-body truncate">{{ $r->kode_retur }}</p>
                        </div>
                        <span class="ml-auto text-xs px-2 py-0.5 rounded-full font-semibold {{ $sr['class'] }} shrink-0">{{ $sr['label'] }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Akses Cepat --}}
            <div class="card-wood rounded-2xl p-5">
                <p class="font-body font-semibold text-crate-brown mb-3">Akses Cepat</p>
                <div class="grid grid-cols-2 gap-2">
                    @php
                    $shortcuts = [
                        ['icon' => 'scissors', 'label' => 'Tambah Kurator', 'link' => '/admin/kurator/tambah'],
                        ['icon' => 'truck',    'label' => 'Tambah Kurir',   'link' => '/admin/kurir/tambah'],
                        ['icon' => 'package',  'label' => 'Kelola Paket',   'link' => '/admin/kelola-paket'],
                        ['icon' => 'archive',  'label' => 'Inventory',      'link' => '/admin/inventory'],
                    ];
                    @endphp
                    @foreach($shortcuts as $sc)
                    <a href="{{ url($sc['link']) }}"
                    class="flex items-center gap-2 bg-crate-cream hover:bg-crate-sand rounded-xl px-3 py-2.5 text-sm font-body font-semibold text-crate-brown transition-colors">
                        <i data-lucide="{{ $sc['icon'] }}" class="w-4 h-4 text-crate-orange shrink-0"></i>
                        <span class="leading-tight text-xs">{{ $sc['label'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>

@endsection