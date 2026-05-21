@extends('layouts.admin.app')
@section('title', 'Detail Kurir — ' . ($kurir['nama'] ?? 'Kurir'))

@section('content')

@php
    $kurir = $kurir ?? [
        'id'          => 1,
        'nama'        => 'Budi Santoso',
        'email'       => 'budi@cratefit.id',
        'no_hp'       => '081234567890',
        'avatar'      => 'B',
        'status'      => 'aktif',
        'bergabung'   => 'Januari 2025',
        'kendaraan'   => 'Motor',
        'plat'        => 'BK 1234 AB',
        'wilayah'     => 'Medan Kota',
        'total_antar' => 62,
        'bulan_ini'   => 11,
        'rating'      => 4.8,
        'catatan'     => 'Kurir andalan untuk area Medan Kota. Selalu tepat waktu dan komunikatif.',

        // Performa 6 bulan terakhir
        'performa' => [
            ['bulan' => 'Jan', 'antar' => 8,  'rating' => 4.7],
            ['bulan' => 'Feb', 'antar' => 12, 'rating' => 4.8],
            ['bulan' => 'Mar', 'antar' => 9,  'rating' => 4.9],
            ['bulan' => 'Apr', 'antar' => 11, 'rating' => 4.8],
            ['bulan' => 'Mei', 'antar' => 11, 'rating' => 4.9],
            ['bulan' => 'Jun', 'antar' => 11, 'rating' => null],
        ],

        // Riwayat pengiriman terbaru
        'riwayat' => [
            [
                'pelanggan' => 'Aulia Ramadhani',
                'paket'     => 'Style Box',
                'periode'   => 'Juni 2025',
                'alamat'    => 'Medan Baru, Medan',
                'status'    => 'dikirim',
                'label'     => 'Dalam Pengiriman',
                'rating'    => null,
            ],
            [
                'pelanggan' => 'Dafi Maulana',
                'paket'     => 'Premium Box',
                'periode'   => 'Juni 2025',
                'alamat'    => 'Medan Timur, Medan',
                'status'    => 'selesai',
                'label'     => 'Terkirim',
                'rating'    => 5,
            ],
            [
                'pelanggan' => 'Elisa Nuraini',
                'paket'     => 'Starter Box',
                'periode'   => 'Mei 2025',
                'alamat'    => 'Medan Baru, Medan',
                'status'    => 'selesai',
                'label'     => 'Terkirim',
                'rating'    => 5,
            ],
            [
                'pelanggan' => 'Bintang Pratama',
                'paket'     => 'Starter Box',
                'periode'   => 'Mei 2025',
                'alamat'    => 'Medan Kota, Medan',
                'status'    => 'selesai',
                'label'     => 'Terkirim',
                'rating'    => 4,
            ],
            [
                'pelanggan' => 'Citra Dewi',
                'paket'     => 'Style Box',
                'periode'   => 'April 2025',
                'alamat'    => 'Medan Baru, Medan',
                'status'    => 'selesai',
                'label'     => 'Terkirim',
                'rating'    => 5,
            ],
        ],
    ];

    $badgeStatus = [
        'selesai'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'dikirim'  => 'bg-violet-50 text-violet-700 border-violet-200',
        'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
        'menunggu' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
        'gagal'    => 'bg-red-50 text-red-600 border-red-200',
    ];

    $maxAntar   = collect($kurir['performa'])->max('antar') ?: 1;
    $ratingList = collect($kurir['riwayat'])->whereNotNull('rating')->pluck('rating');
    $rataRating = $ratingList->count() ? number_format($ratingList->avg(), 1) : '-';
    $terkirim   = collect($kurir['riwayat'])->where('status', 'selesai')->count();
    $diproses   = collect($kurir['riwayat'])->where('status', 'dikirim')->count();
@endphp

<div class="fade-in space-y-6">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm font-body text-crate-stone">
        <a href="{{ url('/admin/kurir') }}"
           class="hover:text-crate-brown transition-colors">← Kelola Kurir</a>
        <span>/</span>
        <span class="text-crate-brown font-medium">{{ $kurir['nama'] }}</span>
    </div>

    {{-- HERO CARD --}}
    <div class="card-wood rounded-2xl p-6">
        <div class="flex flex-col sm:flex-row sm:items-start gap-5">

            {{-- Avatar --}}
            <div class="w-16 h-16 rounded-full flex items-center justify-center shrink-0
                        text-white font-display font-bold text-2xl
                        {{ $kurir['status'] === 'aktif' ? 'bg-crate-orange' : 'bg-crate-stone' }}">
                {{ $kurir['avatar'] }}
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center flex-wrap gap-2 mb-1">
                    <h1 class="font-display text-2xl text-crate-brown font-bold">
                        {{ $kurir['nama'] }}
                    </h1>
                    <span class="text-xs font-body font-semibold px-2.5 py-1 rounded-full border
                        {{ $kurir['status'] === 'aktif'
                            ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                            : 'bg-crate-sand text-crate-stone border-crate-stone/20' }}">
                        {{ $kurir['status'] === 'aktif' ? '● Aktif' : '○ Nonaktif' }}
                    </span>
                </div>
                <p class="text-crate-stone text-sm font-body">
                    {{ $kurir['email'] }}  ·  {{ $kurir['no_hp'] }}
                </p>
                <div class="flex flex-wrap items-center gap-4 mt-2">
                    <span class="text-crate-stone text-xs font-body">
                        🏍️ {{ $kurir['kendaraan'] }}
                        @if($kurir['plat'] !== '-')
                            · <span class="font-semibold text-crate-brown">{{ $kurir['plat'] }}</span>
                        @endif
                    </span>
                    <span class="text-crate-stone text-xs font-body">
                        📍 Wilayah:
                        <span class="font-semibold text-crate-brown">{{ $kurir['wilayah'] }}</span>
                    </span>
                    <span class="text-crate-stone text-xs font-body">
                        🗓️ Bergabung:
                        <span class="font-semibold text-crate-brown">{{ $kurir['bergabung'] }}</span>
                    </span>
                </div>
            </div>

            {{-- CTA Admin --}}
            <div class="flex flex-col gap-2 shrink-0">
                <a href="{{ url('/admin/kurir/' . $kurir['id'] . '/edit') }}"
                   class="btn-primary text-white font-body font-semibold px-5 py-2.5
                          rounded-xl text-sm text-center">
                    ✏️ Edit Kurir
                </a>
                <form action="{{ url('/admin/kurir/' . $kurir['id'] . '/toggle-status') }}"
                      method="POST"
                      onsubmit="return confirm('Ubah status kurir ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="w-full border font-body font-semibold px-5 py-2.5
                                   rounded-xl text-sm text-center transition-colors
                                   {{ $kurir['status'] === 'aktif'
                                        ? 'border-red-200 text-red-500 hover:bg-red-50'
                                        : 'border-emerald-200 text-emerald-600 hover:bg-emerald-50' }}">
                        {{ $kurir['status'] === 'aktif' ? '🔴 Nonaktifkan' : '🟢 Aktifkan' }}
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @php
        $statsK = [
            ['label' => 'Total Pengiriman', 'value' => $kurir['total_antar'], 'icon' => '📬', 'color' => 'text-crate-orange'],
            ['label' => 'Bulan Ini',        'value' => $kurir['bulan_ini'],   'icon' => '🗓️', 'color' => 'text-crate-brown'],
            ['label' => 'Rating',           'value' => $kurir['rating'] . ' ⭐', 'icon' => '⭐', 'color' => 'text-amber-500'],
            ['label' => 'Sedang Diantar',   'value' => $diproses,             'icon' => '🚚', 'color' => 'text-violet-600'],
        ];
        @endphp
        @foreach($statsK as $stat)
        <div class="card-wood rounded-2xl p-4">
            <span class="text-xl block mb-1">{{ $stat['icon'] }}</span>
            <p class="font-display text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            <p class="text-crate-stone text-xs font-body mt-0.5">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- 2 COL: Grafik + Catatan --}}
    <div class="grid lg:grid-cols-2 gap-6">

        {{-- GRAFIK PERFORMA --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-5">
                📊 Performa 6 Bulan Terakhir
            </h2>
            <div class="flex items-end gap-3 h-36">
                @foreach($kurir['performa'] as $p)
                @php
                    $pct = $maxAntar > 0 ? round(($p['antar'] / $maxAntar) * 100) : 0;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-1">
                    <span class="text-crate-orange text-xs font-body font-bold">{{ $p['antar'] }}</span>
                    <div class="w-full rounded-t-lg transition-all duration-500"
                         style="height:{{ $pct }}%;
                                background:{{ $pct >= 80 ? '#C85A1A' : '#EDE0CC' }};
                                min-height:4px">
                    </div>
                    <span class="text-crate-stone text-xs font-body">{{ $p['bulan'] }}</span>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-crate-sand flex items-center gap-4 text-xs font-body">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-sm bg-crate-orange inline-block"></span>
                    <span class="text-crate-stone">Pengiriman terbanyak</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-sm bg-crate-sand inline-block"></span>
                    <span class="text-crate-stone">Bulan lain</span>
                </span>
            </div>
        </div>

        {{-- CATATAN INTERNAL --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-4">
                📝 Catatan Internal
            </h2>
            @if($kurir['catatan'])
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-4">
                <p class="text-crate-brown text-sm font-body leading-relaxed">
                    {{ $kurir['catatan'] }}
                </p>
            </div>
            @else
            <p class="text-crate-stone text-sm font-body italic mb-4">Belum ada catatan.</p>
            @endif

            <form action="{{ url('/admin/kurir/' . $kurir['id'] . '/catatan') }}"
                  method="POST">
                @csrf
                @method('PATCH')
                <textarea name="catatan"
                          rows="3"
                          placeholder="Tambah / perbarui catatan internal kurir..."
                          class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body
                                 text-crate-brown bg-crate-cream placeholder-crate-stone
                                 resize-none transition-all">{{ $kurir['catatan'] }}</textarea>
                <button type="submit"
                        class="mt-2 btn-primary text-white text-xs font-body font-semibold
                               px-4 py-2 rounded-lg">
                    Simpan Catatan
                </button>
            </form>
        </div>

    </div>

    {{-- INFO KENDARAAN --}}
    <div class="card-wood rounded-2xl p-6">
        <h2 class="font-display text-base text-crate-brown font-bold mb-4">
            🏍️ Informasi Kendaraan & Wilayah
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

            <div class="bg-crate-cream rounded-xl border border-crate-sand p-4">
                <p class="text-crate-stone text-xs font-body font-semibold uppercase
                           tracking-wider mb-1">Jenis Kendaraan</p>
                <p class="text-crate-brown font-body font-semibold text-sm">
                    🏍️ {{ $kurir['kendaraan'] }}
                </p>
            </div>

            <div class="bg-crate-cream rounded-xl border border-crate-sand p-4">
                <p class="text-crate-stone text-xs font-body font-semibold uppercase
                           tracking-wider mb-1">Nomor Plat</p>
                <p class="text-crate-brown font-body font-semibold text-sm">
                    {{ $kurir['plat'] !== '-' ? $kurir['plat'] : '—' }}
                </p>
            </div>

            <div class="bg-crate-cream rounded-xl border border-crate-sand p-4">
                <p class="text-crate-stone text-xs font-body font-semibold uppercase
                           tracking-wider mb-1">Wilayah Tugas</p>
                <p class="text-crate-brown font-body font-semibold text-sm">
                    📍 {{ $kurir['wilayah'] }}
                </p>
            </div>

            <div class="bg-crate-cream rounded-xl border border-crate-sand p-4">
                <p class="text-crate-stone text-xs font-body font-semibold uppercase
                           tracking-wider mb-1">Rata-rata Rating</p>
                <p class="text-amber-500 font-display font-bold text-lg">
                    {{ $rataRating }} ⭐
                </p>
            </div>

        </div>
    </div>

    {{-- RIWAYAT PENGIRIMAN --}}
    <div class="card-wood rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base text-crate-brown font-bold">📬 Riwayat Pengiriman</h2>
            <span class="text-crate-stone text-xs font-body">
                {{ count($kurir['riwayat']) }} entri terbaru
            </span>
        </div>

        <div class="divide-y divide-crate-sand/60">
            @forelse($kurir['riwayat'] as $r)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-crate-cream/50 transition-colors">

                {{-- Ikon --}}
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-base
                            {{ $r['status'] === 'dikirim'
                                ? 'bg-violet-50 border border-violet-100'
                                : 'bg-crate-sand border border-crate-sand' }}">
                    {{ $r['status'] === 'dikirim' ? '🚚' : '📬' }}
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="font-body font-semibold text-crate-brown text-sm">
                        {{ $r['pelanggan'] }}
                    </p>
                    <p class="text-crate-stone text-xs font-body mt-0.5">
                        {{ $r['paket'] }}  ·  {{ $r['periode'] }}
                    </p>
                    <p class="text-crate-stone text-xs font-body mt-0.5">
                        📍 {{ $r['alamat'] }}
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
                <p class="text-crate-stone text-sm font-body italic">
                    Belum ada riwayat pengiriman.
                </p>
            </div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-crate-sand">
            <a href="{{ url('/admin/kurir/' . $kurir['id'] . '/riwayat') }}"
               class="text-crate-orange text-xs font-body font-semibold hover:underline">
                Lihat semua riwayat →
            </a>
        </div>

    </div>

    {{-- ACTION FOOTER --}}
    <div class="flex items-center justify-between pt-2 pb-6">
        <a href="{{ url('/admin/kurir') }}"
           class="text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
            ← Kembali ke Daftar
        </a>
        <div class="flex gap-3">
            <form action="{{ url('/admin/kurir/' . $kurir['id']) }}"
                  method="POST"
                  onsubmit="return confirm('Hapus kurir {{ $kurir['nama'] }}? Tindakan ini tidak bisa dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="border border-red-200 text-red-500 hover:bg-red-50
                               font-body font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">
                    🗑 Hapus Kurir
                </button>
            </form>
            <a href="{{ url('/admin/kurir/' . $kurir['id'] . '/edit') }}"
               class="btn-primary text-white font-body font-semibold px-7 py-2.5
                      rounded-xl text-sm shadow-md">
                ✏️ Edit Kurir
            </a>
        </div>
    </div>

</div>
@endsection