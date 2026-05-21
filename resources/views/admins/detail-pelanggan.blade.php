@extends('layouts.admin.app')
@section('title', 'Detail Pelanggan — ' . ($pelanggan['nama'] ?? 'Pelanggan'))

@section('content')

@php
    $pelanggan = $pelanggan ?? [
        'id'         => 1,
        'nama'       => 'Aulia Ramadhani',
        'email'      => 'aulia@gmail.com',
        'no_hp'      => '081234567890',
        'avatar'     => 'A',
        'status'     => 'aktif',
        'bergabung'  => 'Januari 2025',
        'alamat'     => 'Jl. Bunga Melati No. 12, Medan Baru, Medan, Sumatera Utara 20154',
        'preferensi' => [
            'ukuran'  => 'M',
            'warna'   => ['Earthy', 'Pastel', 'Monokrom'],
            'gaya'    => ['Casual', 'Minimalis'],
            'hindari' => ['Motif ramai', 'Warna neon'],
        ],

        // Langganan aktif
        'langganan' => [
            'paket'   => 'Style Box',
            'periode' => 'Juni 2025',
            'status'  => 'diproses',
            'label'   => 'Sedang Diproses',
            'harga'   => 'Rp 149.000',
        ],

        // Riwayat order
        'riwayat' => [
            [
                'paket'   => 'Style Box',
                'periode' => 'Mei 2025',
                'status'  => 'selesai',
                'label'   => 'Selesai',
                'item'    => 5,
                'harga'   => 'Rp 149.000',
                'rating'  => 5,
            ],
            [
                'paket'   => 'Style Box',
                'periode' => 'April 2025',
                'status'  => 'selesai',
                'label'   => 'Selesai',
                'item'    => 5,
                'harga'   => 'Rp 149.000',
                'rating'  => 4,
            ],
            [
                'paket'   => 'Starter Box',
                'periode' => 'Maret 2025',
                'status'  => 'selesai',
                'label'   => 'Selesai',
                'item'    => 3,
                'harga'   => 'Rp 99.000',
                'rating'  => 5,
            ],
            [
                'paket'   => 'Starter Box',
                'periode' => 'Februari 2025',
                'status'  => 'retur',
                'label'   => 'Diretur',
                'item'    => 3,
                'harga'   => 'Rp 99.000',
                'rating'  => null,
            ],
            [
                'paket'   => 'Starter Box',
                'periode' => 'Januari 2025',
                'status'  => 'selesai',
                'label'   => 'Selesai',
                'item'    => 3,
                'harga'   => 'Rp 99.000',
                'rating'  => 4,
            ],
        ],

        // Retur
        'retur' => [
            [
                'periode' => 'Februari 2025',
                'alasan'  => 'Ukuran tidak sesuai',
                'status'  => 'selesai',
                'label'   => 'Selesai',
            ],
        ],
    ];

    $badgeStatus = [
        'selesai'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
        'dikirim'  => 'bg-violet-50 text-violet-700 border-violet-200',
        'menunggu' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'retur'    => 'bg-red-50 text-red-600 border-red-200',
    ];

    $totalOrder   = count($pelanggan['riwayat']);
    $totalRetur   = count($pelanggan['retur']);
    $ratingList   = collect($pelanggan['riwayat'])->whereNotNull('rating')->pluck('rating');
    $rataRating   = $ratingList->count() ? number_format($ratingList->avg(), 1) : '-';
    $totalBelanja = collect($pelanggan['riwayat'])
                        ->where('status', '!=', 'retur')
                        ->count();
@endphp

<div class="fade-in space-y-6">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm font-body text-crate-stone">
        <a href="{{ url('/admin/pelanggan') }}"
           class="hover:text-crate-brown transition-colors">← Kelola Pelanggan</a>
        <span>/</span>
        <span class="text-crate-brown font-medium">{{ $pelanggan['nama'] }}</span>
    </div>

    {{-- HERO CARD --}}
    <div class="card-wood rounded-2xl p-6">
        <div class="flex flex-col sm:flex-row sm:items-start gap-5">

            {{-- Avatar --}}
            <div class="w-16 h-16 rounded-full flex items-center justify-center shrink-0
                        text-white font-display font-bold text-2xl
                        {{ $pelanggan['status'] === 'aktif' ? 'bg-crate-orange' : 'bg-crate-stone' }}">
                {{ $pelanggan['avatar'] }}
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center flex-wrap gap-2 mb-1">
                    <h1 class="font-display text-2xl text-crate-brown font-bold">
                        {{ $pelanggan['nama'] }}
                    </h1>
                    <span class="text-xs font-body font-semibold px-2.5 py-1 rounded-full border
                        {{ $pelanggan['status'] === 'aktif'
                            ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                            : 'bg-crate-sand text-crate-stone border-crate-stone/20' }}">
                        {{ $pelanggan['status'] === 'aktif' ? '● Aktif' : '○ Nonaktif' }}
                    </span>
                </div>
                <p class="text-crate-stone text-sm font-body">
                    {{ $pelanggan['email'] }}  ·  {{ $pelanggan['no_hp'] }}
                </p>
                <p class="text-crate-stone text-xs font-body mt-1">
                    📍 {{ $pelanggan['alamat'] }}
                </p>
                <p class="text-crate-stone text-xs font-body mt-1">
                    Bergabung:
                    <span class="text-crate-brown font-semibold">{{ $pelanggan['bergabung'] }}</span>
                </p>
            </div>

            {{-- Aksi --}}
            <div class="shrink-0">
                <form action="{{ url('/admin/pelanggan/' . $pelanggan['id']) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus pelanggan {{ $pelanggan['nama'] }}? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-2 border border-red-200 text-red-500
                                   hover:bg-red-50 font-body font-semibold px-5 py-2.5
                                   rounded-xl text-sm transition-colors">
                        🗑 Hapus Pelanggan
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @php
        $statsP = [
            ['label' => 'Total Order',    'value' => $totalOrder,   'icon' => '📦', 'color' => 'text-crate-orange'],
            ['label' => 'Order Selesai',  'value' => $totalBelanja, 'icon' => '✅', 'color' => 'text-emerald-600'],
            ['label' => 'Total Retur',    'value' => $totalRetur,   'icon' => '↩️', 'color' => 'text-red-500'],
            ['label' => 'Rata-rata Rating','value' => $rataRating,  'icon' => '⭐', 'color' => 'text-amber-500'],
        ];
        @endphp
        @foreach($statsP as $stat)
        <div class="card-wood rounded-2xl p-4">
            <span class="text-xl block mb-1">{{ $stat['icon'] }}</span>
            <p class="font-display text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            <p class="text-crate-stone text-xs font-body mt-0.5">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- 2 COL: Preferensi + Langganan Aktif --}}
    <div class="grid lg:grid-cols-2 gap-6">

        {{-- PREFERENSI FASHION --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-4">
                👗 Preferensi Fashion
            </h2>

            <div class="space-y-4">

                {{-- Ukuran --}}
                <div class="flex items-start gap-3">
                    <span class="text-crate-stone text-xs font-body font-semibold uppercase
                                 tracking-wider w-20 shrink-0 pt-0.5">Ukuran</span>
                    <span class="bg-crate-orange text-white text-xs font-body font-bold
                                 px-3 py-1 rounded-full">
                        {{ $pelanggan['preferensi']['ukuran'] }}
                    </span>
                </div>

                {{-- Gaya --}}
                <div class="flex items-start gap-3">
                    <span class="text-crate-stone text-xs font-body font-semibold uppercase
                                 tracking-wider w-20 shrink-0 pt-0.5">Gaya</span>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($pelanggan['preferensi']['gaya'] as $g)
                        <span class="bg-crate-orange/10 border border-crate-orange/20 text-crate-orange
                                     text-xs font-body font-semibold px-2.5 py-1 rounded-full">
                            {{ $g }}
                        </span>
                        @endforeach
                    </div>
                </div>

                {{-- Warna --}}
                <div class="flex items-start gap-3">
                    <span class="text-crate-stone text-xs font-body font-semibold uppercase
                                 tracking-wider w-20 shrink-0 pt-0.5">Warna</span>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($pelanggan['preferensi']['warna'] as $w)
                        <span class="bg-crate-sand text-crate-brown text-xs font-body
                                     px-2.5 py-1 rounded-full border border-crate-sand">
                            {{ $w }}
                        </span>
                        @endforeach
                    </div>
                </div>

                {{-- Hindari --}}
                <div class="flex items-start gap-3">
                    <span class="text-crate-stone text-xs font-body font-semibold uppercase
                                 tracking-wider w-20 shrink-0 pt-0.5">Hindari</span>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($pelanggan['preferensi']['hindari'] as $h)
                        <span class="bg-red-50 border border-red-200 text-red-500
                                     text-xs font-body px-2.5 py-1 rounded-full">
                            {{ $h }}
                        </span>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- LANGGANAN AKTIF --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-4">
                📬 Langganan Aktif
            </h2>

            @if($pelanggan['langganan'])
            @php $l = $pelanggan['langganan']; @endphp
            <div class="bg-crate-cream rounded-xl border border-crate-sand p-5 space-y-3">
                <div class="flex items-center justify-between">
                    <p class="font-display text-lg font-bold text-crate-brown">
                        {{ $l['paket'] }}
                    </p>
                    <span class="text-xs font-body font-semibold px-2.5 py-1 rounded-full border
                                 {{ $badgeStatus[$l['status']] ?? 'bg-crate-sand text-crate-stone border-crate-sand' }}">
                        {{ $l['label'] }}
                    </span>
                </div>
                <div class="flex items-center gap-4 text-xs font-body text-crate-stone">
                    <span>🗓️ {{ $l['periode'] }}</span>
                    <span>💰 {{ $l['harga'] }}</span>
                </div>
                <a href="{{ url('/admin/langganan') }}"
                   class="inline-block text-xs font-body font-semibold text-crate-orange
                          hover:underline transition-colors">
                    Lihat di halaman langganan →
                </a>
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <p class="text-3xl mb-2">📭</p>
                <p class="text-crate-brown font-body font-semibold text-sm">
                    Tidak ada langganan aktif
                </p>
                <p class="text-crate-stone text-xs font-body mt-1">
                    Pelanggan belum memiliki paket subscription saat ini.
                </p>
            </div>
            @endif
        </div>

    </div>

    {{-- RIWAYAT ORDER --}}
    <div class="card-wood rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base text-crate-brown font-bold">📦 Riwayat Order</h2>
            <span class="text-crate-stone text-xs font-body">
                {{ count($pelanggan['riwayat']) }} order
            </span>
        </div>

        <div class="divide-y divide-crate-sand/60">
            @forelse($pelanggan['riwayat'] as $r)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-crate-cream/50 transition-colors">

                {{-- Ikon paket --}}
                <div class="w-9 h-9 rounded-xl bg-crate-sand flex items-center justify-center
                            shrink-0 text-base">
                    📦
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="font-body font-semibold text-crate-brown text-sm">{{ $r['paket'] }}</p>
                    <p class="text-crate-stone text-xs font-body mt-0.5">
                        {{ $r['item'] }} item  ·  {{ $r['harga'] }}  ·  {{ $r['periode'] }}
                    </p>
                </div>

                {{-- Rating bintang --}}
                <div class="hidden sm:flex items-center gap-0.5 shrink-0">
                    @if($r['rating'])
                        @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $r['rating'] ? 'text-amber-400' : 'text-crate-sand' }} text-sm">
                            ★
                        </span>
                        @endfor
                    @else
                        <span class="text-crate-stone text-xs font-body italic">Belum dinilai</span>
                    @endif
                </div>

                {{-- Badge status --}}
                <span class="text-xs font-body font-semibold px-2.5 py-1 rounded-full border shrink-0
                             {{ $badgeStatus[$r['status']] ?? 'bg-crate-sand text-crate-stone border-crate-sand' }}">
                    {{ $r['label'] }}
                </span>

            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <p class="text-crate-stone text-sm font-body italic">Belum ada riwayat order.</p>
            </div>
            @endforelse
        </div>

    </div>

    {{-- RIWAYAT RETUR --}}
    <div class="card-wood rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base text-crate-brown font-bold">↩️ Riwayat Retur</h2>
            <span class="text-crate-stone text-xs font-body">
                {{ count($pelanggan['retur']) }} retur
            </span>
        </div>

        <div class="divide-y divide-crate-sand/60">
            @forelse($pelanggan['retur'] as $r)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-crate-cream/50 transition-colors">

                <div class="w-9 h-9 rounded-xl bg-red-50 border border-red-100
                            flex items-center justify-center shrink-0 text-base">
                    ↩️
                </div>

                <div class="flex-1 min-w-0">
                    <p class="font-body font-semibold text-crate-brown text-sm">
                        Retur — {{ $r['periode'] }}
                    </p>
                    <p class="text-crate-stone text-xs font-body mt-0.5">
                        Alasan: {{ $r['alasan'] }}
                    </p>
                </div>

                <span class="text-xs font-body font-semibold px-2.5 py-1 rounded-full border shrink-0
                             {{ $badgeStatus[$r['status']] ?? 'bg-crate-sand text-crate-stone border-crate-sand' }}">
                    {{ $r['label'] }}
                </span>

            </div>
            @empty
            <div class="px-6 py-10 text-center">
                <p class="text-crate-stone text-sm font-body italic">Belum pernah mengajukan retur.</p>
            </div>
            @endforelse
        </div>

    </div>

    {{-- ACTION FOOTER --}}
    <div class="flex items-center justify-between pt-2 pb-6">
        <a href="{{ url('/admin/pelanggan') }}"
           class="text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
            ← Kembali ke Daftar
        </a>
        <form action="{{ url('/admin/pelanggan/' . $pelanggan['id']) }}"
              method="POST"
              onsubmit="return confirm('Hapus pelanggan {{ $pelanggan['nama'] }}? Tindakan ini tidak bisa dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="flex items-center gap-2 border border-red-200 text-red-500
                           hover:bg-red-50 font-body font-semibold px-5 py-2.5
                           rounded-xl text-sm transition-colors">
                🗑 Hapus Pelanggan
            </button>
        </form>
    </div>

</div>
@endsection