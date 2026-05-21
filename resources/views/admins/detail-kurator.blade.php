@extends('layouts.admin.app')
@section('title', 'Detail Kurator — ' . ($kurator['nama'] ?? 'Kurator'))

@section('content')

@php
    $kurator = $kurator ?? [];

    $badgeStatus = [
        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'dikirim' => 'bg-blue-50 text-blue-700 border-blue-200',
        'diproses'=> 'bg-amber-50 text-amber-700 border-amber-200',
        'menunggu'=> 'bg-crate-sand text-crate-stone border-crate-stone/20',
    ];

    $maxKurasi = collect($kurator['performa'] ?? [])->max('kurasi') ?: 1;
@endphp

<div class="fade-in space-y-6">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm font-body text-crate-stone">
        <a href="{{ url('/admin/kurator') }}" class="hover:text-crate-brown transition-colors">← Kelola Kurator</a>
        <span>/</span>
        <span class="text-crate-brown font-medium">{{ $kurator['nama'] }}</span>
    </div>

    {{-- HERO CARD --}}
    <div class="card-wood rounded-2xl p-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-5">

            {{-- Avatar --}}
            <div class="w-16 h-16 rounded-full flex items-center justify-center shrink-0
                        text-white font-display font-bold text-2xl
                        {{ $kurator['status'] === 'aktif' ? 'bg-crate-orange' : 'bg-crate-stone' }}">
                {{ $kurator['avatar'] }}
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center flex-wrap gap-2 mb-1">
                    <h1 class="font-display text-2xl text-crate-brown font-bold">{{ $kurator['nama'] }}</h1>
                    <span class="text-xs font-body font-semibold px-2.5 py-1 rounded-full border
                        {{ $kurator['status'] === 'aktif'
                            ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                            : 'bg-crate-sand text-crate-stone border-crate-stone/20' }}">
                        {{ $kurator['status'] === 'aktif' ? '● Aktif' : '○ Nonaktif' }}
                    </span>
                </div>
                <p class="text-crate-stone text-sm font-body">{{ $kurator['email'] }}  ·  {{ $kurator['no_hp'] }}</p>
                <p class="text-crate-stone text-xs font-body mt-1">
                    Bergabung: <span class="text-crate-brown font-medium">{{ $kurator['bergabung'] }}</span>
                </p>
                <div class="flex flex-wrap gap-1.5 mt-2">
                    @foreach($kurator['spesialisasi'] as $sp)
                    <span class="bg-crate-orange/10 border border-crate-orange/20 text-crate-orange
                                 text-xs font-body font-semibold px-2.5 py-1 rounded-full">{{ $sp }}</span>
                    @endforeach
                </div>
            </div>

            {{-- CTA Admin --}}
            <div class="flex flex-col gap-2 shrink-0">
                <a href="{{ url('/admin/kurator/' . $kurator['id'] . '/edit') }}"
                   class="btn-primary text-white font-body font-semibold px-5 py-2.5 rounded-xl text-sm text-center">
                    ✏️ Edit Kurator
                </a>
                <form action="{{ url('/admin/kurator/' . $kurator['id'] . '/toggle-status') }}" method="POST"
                      onsubmit="return confirm('Ubah status kurator ini?')">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="w-full border font-body font-semibold px-5 py-2.5 rounded-xl text-sm text-center transition-colors
                                   {{ $kurator['status'] === 'aktif'
                                        ? 'border-red-200 text-red-500 hover:bg-red-50'
                                        : 'border-emerald-200 text-emerald-600 hover:bg-emerald-50' }}">
                        {{ $kurator['status'] === 'aktif' ? '🔴 Nonaktifkan' : '🟢 Aktifkan' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @php
        $statsKurator = [
            ['label' => 'Total Kurasi',   'value' => $kurator['total_kurasi'], 'icon' => '📦', 'color' => 'text-crate-orange'],
            ['label' => 'Kurasi Bulan Ini','value' => $kurator['bulan_ini'],   'icon' => '🗓️', 'color' => 'text-crate-brown'],
            ['label' => 'Rating',         'value' => $kurator['rating'] . ' ⭐','icon' => '⭐', 'color' => 'text-amber-500'],
            ['label' => 'Spesialisasi',   'value' => count($kurator['spesialisasi']), 'icon' => '🎨', 'color' => 'text-cur-teal'],
        ];
        @endphp
        @foreach($statsKurator as $stat)
        <div class="card-wood rounded-2xl p-4">
            <span class="text-xl block mb-1">{{ $stat['icon'] }}</span>
            <p class="font-display text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            <p class="text-crate-stone text-xs font-body mt-0.5">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- 2 COL --}}
    <div class="grid lg:grid-cols-2 gap-6">

        {{-- ===== GRAFIK PERFORMA (Bar sederhana CSS) ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-5">📊 Performa 6 Bulan Terakhir</h2>
            <div class="flex items-end gap-3 h-36">
                @foreach($kurator['performa'] as $p)
                @php
                    $pct = $maxKurasi > 0 ? round(($p['kurasi'] / $maxKurasi) * 100) : 0;
                @endphp
                <div class="flex-1 flex flex-col items-center gap-1">
                    <span class="text-crate-orange text-xs font-body font-bold">{{ $p['kurasi'] }}</span>
                    <div class="w-full rounded-t-lg transition-all duration-500"
                         style="height:{{ $pct }}%;background:{{ $pct >= 80 ? '#C85A1A' : '#EDE0CC' }};min-height:4px">
                    </div>
                    <span class="text-crate-stone text-xs font-body">{{ $p['bulan'] }}</span>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-crate-sand flex items-center gap-4 text-xs font-body">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-sm bg-crate-orange inline-block"></span>
                    <span class="text-crate-stone">Kurasi terbanyak</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-sm bg-crate-sand inline-block"></span>
                    <span class="text-crate-stone">Bulan lain</span>
                </span>
            </div>
        </div>

        {{-- ===== CATATAN INTERNAL ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-4">📝 Catatan Internal</h2>
            @if($kurator['catatan'])
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-4">
                <p class="text-crate-brown text-sm font-body leading-relaxed">{{ $kurator['catatan'] }}</p>
            </div>
            @else
            <p class="text-crate-stone text-sm font-body italic mb-4">Belum ada catatan.</p>
            @endif

            {{-- Update catatan --}}
            <form action="{{ url('/admin/kurator/' . $kurator['id'] . '/catatan') }}" method="POST">
                @csrf @method('PATCH')
                <textarea name="catatan" rows="3"
                          placeholder="Tambah / perbarui catatan internal kurator..."
                          class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body
                                 text-crate-brown bg-crate-cream placeholder-crate-stone resize-none transition-all">{{ $kurator['catatan'] }}</textarea>
                <button type="submit"
                        class="mt-2 btn-primary text-white text-xs font-body font-semibold px-4 py-2 rounded-lg">
                    Simpan Catatan
                </button>
            </form>
        </div>
    </div>

    {{-- ===== RIWAYAT KURASI ===== --}}
    <div class="card-wood rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base text-crate-brown font-bold">📦 Riwayat Kurasi</h2>
            <span class="text-crate-stone text-xs font-body">{{ count($kurator['riwayat']) }} entri terbaru</span>
        </div>

        <div class="divide-y divide-crate-sand/60">
            @forelse($kurator['riwayat'] as $r)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-crate-cream/50 transition-colors">
                <span class="text-2xl shrink-0">📦</span>
                <div class="flex-1 min-w-0">
                    <p class="font-body font-semibold text-crate-brown text-sm">{{ $r['pelanggan'] }}</p>
                    <p class="text-crate-stone text-xs font-body">{{ $r['paket'] }}  ·  {{ $r['item'] }} item  ·  {{ $r['periode'] }}</p>
                </div>

                {{-- Rating bintang --}}
                <div class="hidden sm:flex items-center gap-1 shrink-0">
                    @if($r['rating'])
                        @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $r['rating'] ? 'text-amber-400' : 'text-crate-sand' }} text-sm">★</span>
                        @endfor
                    @else
                        <span class="text-crate-stone text-xs font-body italic">Belum dinilai</span>
                    @endif
                </div>

                <span class="text-xs font-body font-semibold px-2.5 py-1 rounded-full border shrink-0
                             {{ $badgeStatus[$r['status']] ?? 'bg-crate-sand text-crate-stone border-crate-sand' }}">
                    {{ $r['label'] }}
                </span>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <p class="text-crate-stone text-sm font-body italic">Belum ada riwayat kurasi.</p>
            </div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-crate-sand">
            <a href="{{ url('/admin/kurator/' . $kurator['id'] . '/riwayat') }}"
               class="text-crate-orange text-xs font-body font-semibold hover:underline">
                Lihat semua riwayat →
            </a>
        </div>
    </div>

    {{-- ACTION FOOTER --}}
    <div class="flex items-center justify-between pt-2 pb-6">
        <a href="{{ url('/admin/kurator') }}"
           class="text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
            ← Kembali ke Daftar
        </a>
        <div class="flex gap-3">
            <form action="{{ url('/admin/kurator/' . $kurator['id']) }}" method="POST"
                  onsubmit="return confirm('Hapus kurator ini secara permanen?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="border border-red-200 text-red-500 hover:bg-red-50 font-body font-semibold
                               px-5 py-2.5 rounded-xl text-sm transition-colors">
                    🗑 Hapus Kurator
                </button>
            </form>
            <a href="{{ url('/admin/kurator/' . $kurator['id'] . '/edit') }}"
               class="btn-primary text-white font-body font-semibold px-7 py-2.5 rounded-xl text-sm shadow-md">
                ✏️ Edit Kurator
            </a>
        </div>
    </div>

</div>
@endsection