@extends('layouts.kurator.app')
@section('title', 'Detail Pelanggan — ' . ($pelanggan['nama'] ?? 'Pelanggan'))

@section('content')

{{-- Data dummy — ganti dengan $pelanggan dari controller --}}
@php
$pelanggan = $pelanggan ?? [
'id' => 1,
'nama' => 'Aulia Ramadhani',
'email' => 'aulia@email.com',
'no_hp' => '081234567890',
'bergabung' => 'Maret 2025',
'paket' => 'Starter Box',
'periode' => 'Juni 2025',
'status' => 'menunggu',
'label_status' => 'Menunggu Kurasi',
'avatar' => 'A',

// Preferensi fashion
'ukuran_atasan' => 'M',
'ukuran_bawahan' => 'M',
'tinggi' => '162',
'berat' => '52',
'gaya' => ['Casual', 'Minimalis'],
'warna' => ['Hitam', 'Putih', 'Abu-abu', 'Navy', 'Krem'],
'jenis_pakaian' => ['Kaos', 'Kemeja', 'Jaket', 'Celana Jeans', 'Cardigan'],
'pantangan' => ['Dress', 'Rok'],
'catatan' => 'Saya lebih suka warna earth tone dan netral. Hindari motif ramai. Prefer pakaian yang bisa dipakai ke kampus sekaligus jalan-jalan.',

// Alamat
'alamat' => 'Jl. Pahlawan No. 12, Kel. Sudirman, Kec. Medan Baru, Kota Medan, Sumatera Utara 20152',

// Riwayat box
'riwayat' => [
['periode' => 'Mei 2025', 'status' => 'dikirim', 'label' => 'Sudah Dikirim', 'item' => 3],
['periode' => 'April 2025', 'status' => 'selesai', 'label' => 'Box Selesai', 'item' => 3],
],
];

$warnaMeta = [
'Hitam' => '#1A1A1A',
'Putih' => '#F5F5F0',
'Abu-abu' => '#9E9E9E',
'Navy' => '#1B2A4A',
'Biru' => '#3B82F6',
'Hijau' => '#22C55E',
'Sage' => '#87A878',
'Merah' => '#EF4444',
'Oranye' => '#F97316',
'Kuning' => '#EAB308',
'Krem' => '#F5F0E0',
'Coklat' => '#7C3F1E',
'Ungu' => '#A855F7',
'Pink' => '#EC4899',
'Dusty Rose' => '#D4929A',
'Terracota' => '#C2694F',
];
@endphp

<div class="fade-in space-y-6">

    {{-- BREADCRUMB & BACK --}}
    <div class="flex items-center gap-2 text-sm font-body text-crate-text/50">
        <a href="{{ url('/kurator/pelanggan') }}" class="hover:text-crate-text transition-colors flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Profil Pelanggan
        </a>
        <span>/</span>
        <span class="text-crate-text font-medium">{{ $pelanggan['nama'] }}</span>
    </div>

    {{-- HERO HEADER CARD --}}
    <div class="card-wood rounded-2xl p-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-5">

            {{-- Avatar besar --}}
            <div class="w-16 h-16 rounded-full bg-cur-teal flex items-center justify-center
                        text-white font-display font-bold text-2xl shrink-0">
                {{ $pelanggan['avatar'] }}
            </div>

            {{-- Info dasar --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center flex-wrap gap-2 mb-1">
                    <h1 class="font-display text-2xl text-crate-text font-bold">{{ $pelanggan['nama'] }}</h1>
                    <span class="badge-{{ $pelanggan['status'] }} text-xs font-body font-semibold px-2.5 py-1 rounded-full">
                        {{ $pelanggan['label_status'] }}
                    </span>
                </div>
                <p class="text-crate-text/50 text-sm font-body">{{ $pelanggan['email'] }} · {{ $pelanggan['no_hp'] }}</p>
                <p class="text-crate-text/50 text-xs font-body mt-1">
                    Bergabung: <span class="text-crate-text font-medium">{{ $pelanggan['bergabung'] }}</span>
                    &nbsp;·&nbsp;
                    Paket: <span class="text-crate-primary font-semibold">{{ $pelanggan['paket'] }}</span>
                    &nbsp;·&nbsp;
                    Periode: <span class="text-crate-text font-medium">{{ $pelanggan['periode'] }}</span>
                </p>
            </div>

            {{-- CTA kurator --}}
            <div class="flex flex-col sm:items-end gap-2 shrink-0">
                <a href="{{ url('/kurator/pilih-item/' . $pelanggan['id']) }}"
                    class="btn-curator text-white font-body font-semibold px-5 py-2.5 rounded-xl text-sm text-center flex items-center justify-center gap-2">
                    <i data-lucide="shirt" class="w-4 h-4"></i> Mulai Kurasi Box
                </a>
                <a href="{{ url('/kurator/susun-box?pelanggan=' . $pelanggan['id']) }}"
                    class="border border-cur-teal text-cur-teal font-body font-semibold px-5 py-2.5 rounded-xl text-sm
                        hover:bg-cur-teal-bg transition-colors text-center flex items-center justify-center gap-2">
                    <i data-lucide="package" class="w-4 h-4"></i> Susun Isi Box
                </a>
            </div>
        </div>
    </div>

    {{-- 2-COLUMN GRID --}}
    <div class="grid lg:grid-cols-2 gap-6">

        {{-- ===== UKURAN & BODY ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-text font-bold mb-4 flex items-center gap-2">
                <i data-lucide="ruler" class="w-4 h-4 text-crate-primary"></i> Ukuran Pakaian
            </h2>

            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="bg-crate-accent rounded-xl p-4 text-center border border-crate-accent">
                    <p class="text-crate-text/50 text-xs font-body mb-1">Atasan</p>
                    <p class="font-display text-3xl font-bold text-crate-primary">{{ $pelanggan['ukuran_atasan'] }}</p>
                </div>
                <div class="bg-crate-accent rounded-xl p-4 text-center border border-crate-accent">
                    <p class="text-crate-text/50 text-xs font-body mb-1">Bawahan</p>
                    <p class="font-display text-3xl font-bold text-crate-primary">{{ $pelanggan['ukuran_bawahan'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="flex items-center gap-3 bg-crate-accent rounded-xl p-3 border border-crate-accent">
                    <i data-lucide="ruler" class="w-5 h-5 text-crate-primary"></i>
                    <div>
                        <p class="text-crate-text/50 text-xs font-body">Tinggi Badan</p>
                        <p class="text-crate-text font-semibold text-sm font-body">{{ $pelanggan['tinggi'] }} cm</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-crate-accent rounded-xl p-3 border border-crate-accent">
                    <i data-lucide="scale" class="w-5 h-5 text-crate-primary"></i>
                    <div>
                        <p class="text-crate-text/50 text-xs font-body">Berat Badan</p>
                        <p class="text-crate-text font-semibold text-sm font-body">{{ $pelanggan['berat'] }} kg</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== GAYA BERPAKAIAN ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-text font-bold mb-4 flex items-center gap-2">
                <i data-lucide="palette" class="w-4 h-4 text-crate-primary"></i> Gaya Berpakaian
            </h2>
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($pelanggan['gaya'] ?? [] as $g)
                <span class="bg-cur-teal-bg border border-cur-teal/25 text-cur-teal
                             text-sm font-body font-semibold px-3 py-1.5 rounded-full">
                    {{ $g }}
                </span>
                @endforeach
            </div>

            <h3 class="font-body font-semibold text-crate-text/70 text-xs uppercase tracking-wider mb-3">
                Warna Favorit
            </h3>
            <div class="flex flex-wrap gap-3">
                @foreach($pelanggan['warna'] as $w)
                <div class="flex flex-col items-center gap-1">
                    <div class="w-8 h-8 rounded-full ring-2 ring-white shadow-sm border border-black/10"
                        style="background:{{ $warnaMeta[$w] ?? '#ccc' }}"></div>
                    <span class="text-crate-text/50 text-xs font-body text-center" style="max-width:44px;line-height:1.2">{{ $w }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ===== JENIS PAKAIAN ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-text font-bold mb-4 flex items-center gap-2">
                <i data-lucide="shirt" class="w-4 h-4 text-crate-primary"></i> Jenis Pakaian Diinginkan
            </h2>
            <div class="flex flex-wrap gap-2">
                @foreach($pelanggan['jenis_pakaian'] as $jp)
                <span class="bg-crate-accent text-crate-text text-sm font-body px-3 py-1.5 rounded-full border border-crate-stone/20">
                    {{ $jp }}
                </span>
                @endforeach
            </div>

            @if(!empty($pelanggan['pantangan']))
            <div class="mt-4 pt-4 border-t border-crate-accent">
                <p class="text-xs font-body font-semibold text-red-500/80 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    <i data-lucide="ban" class="w-3.5 h-3.5"></i> Pantangan
                </p>
                <div class="flex flex-wrap gap-2">
                    @foreach($pelanggan['pantangan'] as $pt)
                    <span class="bg-red-50 border border-red-200 text-red-600 text-sm font-body px-3 py-1.5 rounded-full inline-flex items-center gap-1.5">
                        <i data-lucide="ban" class="w-3.5 h-3.5"></i> {{ $pt }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- ===== CATATAN KURATOR ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-text font-bold mb-4 flex items-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4 text-crate-primary"></i> Catatan dari Pelanggan
            </h2>
            @if($pelanggan['catatan'])
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <p class="text-crate-text text-sm font-body leading-relaxed">
                    "{{ $pelanggan['catatan'] }}"
                </p>
            </div>
            @else
            <p class="text-crate-text/50 text-sm font-body italic">Tidak ada catatan khusus.</p>
            @endif

            {{-- Kolom catatan internal kurator --}}
            <div class="mt-4 pt-4 border-t border-crate-accent">
                <label class="block text-xs font-body font-semibold text-crate-text/70 uppercase tracking-wider mb-2">
                    Catatan Internal Kurator
                </label>
                <textarea rows="3" placeholder="Tambahkan catatan internal di sini (hanya terlihat oleh tim kurator)..."
                    class="w-full border border-crate-accent rounded-xl px-4 py-3 text-sm font-body text-crate-text
                                 bg-crate-accent placeholder-crate-stone resize-none transition-all">{{ $catatanKurator ?? '' }}</textarea>
                <button class="mt-2 btn-curator text-white text-xs font-body font-semibold px-4 py-2 rounded-lg">
                    Simpan Catatan
                </button>
            </div>
        </div>
    </div>

    {{-- ===== ALAMAT PENGIRIMAN ===== --}}
    <div class="card-wood rounded-2xl p-6">
    <h2 class="font-display text-base text-crate-text font-bold mb-3 flex items-center gap-2">
    <i data-lucide="map-pin" class="w-4 h-4 text-crate-primary"></i> Alamat Pengiriman
</h2>
<div class="flex items-start gap-3 bg-crate-accent rounded-xl p-4 border border-crate-accent">
    <i data-lucide="home" class="w-5 h-5 mt-0.5 text-crate-primary"></i>
            @if($pelanggan['alamat'])
            <p class="...">
                {{ $pelanggan['alamat']['nama_penerima'] }} · {{ $pelanggan['alamat']['no_telepon'] }}<br>
                {{ $pelanggan['alamat']['alamat_lengkap'] }},
                {{ $pelanggan['alamat']['kecamatan'] }},
                {{ $pelanggan['alamat']['kota'] }},
                {{ $pelanggan['alamat']['provinsi'] }}
                {{ $pelanggan['alamat']['kode_pos'] }}
            </p>
            @else
            <p class="...">Belum ada alamat tersimpan.</p>
            @endif
        </div>
    </div>

    {{-- ===== RIWAYAT BOX ===== --}}
    @if(!empty($pelanggan['riwayat']))
    <div class="card-wood rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-crate-accent">
            <h2 class="font-display text-base text-crate-text font-bold flex items-center gap-2">
                <i data-lucide="package" class="w-4 h-4 text-crate-primary"></i> Riwayat Box
            </h2>
        </div>
        <div class="divide-y divide-crate-accent/60">
            @foreach($pelanggan['riwayat'] as $r)
            <div class="flex items-center gap-4 px-6 py-4">
                <i data-lucide="package" class="w-6 h-6 text-crate-primary"></i>
                <div class="flex-1">
                    <p class="text-crate-text font-semibold text-sm font-body">{{ $r['periode'] }}</p>
                    <p class="text-crate-text/50 text-xs font-body">{{ $r['item'] }} item dikurasi</p>
                </div>
                <span class="badge-{{ $r['status'] }} text-xs font-body font-semibold px-2.5 py-1 rounded-full">
                    {{ $r['label'] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ACTION FOOTER --}}
    <div class="flex items-center justify-between pt-2 pb-6">
        <a href="{{ url('/kurator/pelanggan') }}"
            class="flex items-center gap-2 text-crate-text/50 font-body text-sm hover:text-crate-text transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar
        </a>
        <a href="{{ url('/kurator/pilih-item/' . $pelanggan['id']) }}"
            class="btn-curator text-white font-body font-semibold px-7 py-3 rounded-2xl text-sm shadow-lg flex items-center gap-2">
            <i data-lucide="shirt" class="w-4 h-4"></i> Mulai Kurasi Box <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

</div>
@endsection