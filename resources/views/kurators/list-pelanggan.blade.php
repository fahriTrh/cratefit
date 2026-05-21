@extends('layouts.kurator.app')
@section('title', 'Profil Pelanggan')

@section('content')
<div class="fade-in">

    {{-- PAGE HEADER --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-cur-teal font-script text-lg mb-0.5">Panel Kurator</p>
            <h1 class="font-display text-3xl text-crate-brown font-bold">Profil Pelanggan</h1>
            <p class="text-crate-stone font-body mt-1 text-sm">Lihat dan kelola data preferensi setiap pelanggan yang membutuhkan kurasi.</p>
        </div>

        {{-- Search & Filter --}}
        <div class="flex items-center gap-2 shrink-0">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-stone text-sm">🔍</span>
                <input type="text" placeholder="Cari nama / email..."
                    class="pl-9 pr-4 py-2.5 rounded-xl border border-crate-sand bg-white text-sm font-body
                              text-crate-brown placeholder-crate-stone w-52 transition-all">
            </div>
            <select class="border border-crate-sand bg-white rounded-xl px-3 py-2.5 text-sm font-body text-crate-brown transition-all">
                <option value="">Semua Status</option>
                <option value="menunggu">Menunggu Kurasi</option>
                <option value="diproses">Sedang Diproses</option>
                <option value="selesai">Box Selesai</option>
                <option value="dikirim">Sudah Dikirim</option>
            </select>
        </div>
    </div>

    {{-- STATS STRIP --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        @php
        $stats = [
        ['label' => 'Total Pelanggan', 'value' => $totalPelanggan ?? '—', 'icon' => '👥', 'color' => 'text-crate-brown'],
        ['label' => 'Menunggu Kurasi', 'value' => $menunggu ?? '—', 'icon' => '⏳', 'color' => 'text-amber-600'],
        ['label' => 'Sedang Diproses', 'value' => $diproses ?? '—', 'icon' => '🔄', 'color' => 'text-blue-600'],
        ['label' => 'Selesai Bulan Ini','value' => $selesai ?? '—', 'icon' => '✅', 'color' => 'text-cur-teal'],
        ];
        @endphp
        @foreach($stats as $stat)
        <div class="card-wood rounded-2xl p-4">
            <div class="flex items-center justify-between mb-1">
                <span class="text-lg">{{ $stat['icon'] }}</span>
            </div>
            <p class="font-display text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            <p class="text-crate-stone text-xs font-body mt-0.5">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- PELANGGAN TABLE / LIST --}}
    <div class="card-wood rounded-2xl overflow-hidden">

        {{-- Table header --}}
        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base font-bold text-crate-brown">Daftar Pelanggan</h2>
            <span class="text-crate-stone text-xs font-body">
                Menampilkan {{ count($pelangganList ?? []) }} pelanggan
            </span>
        </div>

        {{-- List --}}
        <div class="divide-y divide-crate-sand/60">

            {{-- Baris dummy — ganti dengan @foreach($pelangganList as $p) --}}
            @php
            $dummyList = [
            [
            'id' => 1,
            'nama' => 'Aulia Ramadhani',
            'email' => 'aulia@email.com',
            'paket' => 'Starter Box',
            'periode' => 'Juni 2025',
            'status' => 'menunggu',
            'label' => 'Menunggu Kurasi',
            'gaya' => ['Casual', 'Minimalis'],
            'ukuran' => 'M / M',
            'avatar' => 'A',
            ],
            [
            'id' => 2,
            'nama' => 'Bintang Pratama',
            'email' => 'bintang@email.com',
            'paket' => 'Style Box',
            'periode' => 'Juni 2025',
            'status' => 'diproses',
            'label' => 'Sedang Diproses',
            'gaya' => ['Streetwear', 'Eclectic'],
            'ukuran' => 'L / L',
            'avatar' => 'B',
            ],
            [
            'id' => 3,
            'nama' => 'Citra Dewi',
            'email' => 'citra@email.com',
            'paket' => 'Premium Box',
            'periode' => 'Juni 2025',
            'status' => 'selesai',
            'label' => 'Box Selesai',
            'gaya' => ['Feminine', 'Vintage'],
            'ukuran' => 'S / S',
            'avatar' => 'C',
            ],
            [
            'id' => 4,
            'nama' => 'Dafi Maulana',
            'email' => 'dafi@email.com',
            'paket' => 'Starter Box',
            'periode' => 'Juni 2025',
            'status' => 'dikirim',
            'label' => 'Sudah Dikirim',
            'gaya' => ['Boho', 'Smart Casual'],
            'ukuran' => 'XL / L',
            'avatar' => 'D',
            ],
            [
            'id' => 5,
            'nama' => 'Elisa Nuraini',
            'email' => 'elisa@email.com',
            'paket' => 'Style Box',
            'periode' => 'Juni 2025',
            'status' => 'menunggu',
            'label' => 'Menunggu Kurasi',
            'gaya' => ['Casual', 'Boho'],
            'ukuran' => 'S / S',
            'avatar' => 'E',
            ],
            ];
            // Ganti $dummyList dengan $pelangganList dari controller
            @endphp

            @forelse($dummyList as $p)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-crate-cream/50 transition-colors group">

                {{-- Avatar --}}
                <div class="w-10 h-10 rounded-full bg-cur-teal flex items-center justify-center
                            text-white font-display font-bold text-sm shrink-0">
                    {{ $p['avatar'] }}
                </div>

                {{-- Info utama --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="font-body font-semibold text-crate-brown text-sm">{{ $p['nama'] }}</p>
                        {{-- Badge status --}}
                        <span class="badge-{{ $p['status'] }} text-xs font-body font-semibold px-2 py-0.5 rounded-full">
                            {{ $p['label'] }}
                        </span>
                    </div>
                    <p class="text-crate-stone text-xs font-body mt-0.5">{{ $p['email'] }}</p>
                    {{-- Gaya & ukuran tags --}}
                    <div class="flex items-center gap-1.5 mt-1.5 flex-wrap">
                        @foreach($p['gaya'] as $g)
                        <span class="bg-crate-sand text-crate-brown text-xs font-body px-2 py-0.5 rounded-full">{{ $g }}</span>
                        @endforeach
                        <span class="bg-cur-teal-bg text-cur-teal text-xs font-body px-2 py-0.5 rounded-full">
                            👔 {{ $p['ukuran'] }}
                        </span>
                    </div>
                </div>

                {{-- Paket & Periode --}}
                <div class="hidden sm:block text-right shrink-0">
                    <p class="text-crate-brown font-semibold text-xs font-body">{{ $p['paket'] }}</p>
                    <p class="text-crate-stone text-xs font-body">{{ $p['periode'] }}</p>
                </div>

                {{-- CTA --}}
                <a href="{{ url('/kurator/pelanggan/' . $p['id']) }}"
                    class="shrink-0 btn-curator text-white text-xs font-body font-semibold
                          px-4 py-2 rounded-xl opacity-0 group-hover:opacity-100 transition-all">
                    Lihat Detail →
                </a>
            </div>
            @empty
            <div class="px-6 py-16 text-center">
                <p class="text-4xl mb-3">📭</p>
                <p class="text-crate-brown font-display text-lg font-bold">Belum ada pelanggan</p>
                <p class="text-crate-stone text-sm font-body mt-1">Data pelanggan akan muncul di sini.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-crate-sand flex items-center justify-between">
            <p class="text-crate-stone text-xs font-body">Halaman 1 dari 1</p>
            <div class="flex gap-2">
                <button class="px-3 py-1.5 rounded-lg border border-crate-sand text-xs font-body text-crate-stone
                               hover:bg-crate-sand transition-colors disabled:opacity-40" disabled>
                    ← Sebelumnya
                </button>
                <button class="px-3 py-1.5 rounded-lg border border-crate-sand text-xs font-body text-crate-stone
                               hover:bg-crate-sand transition-colors disabled:opacity-40" disabled>
                    Berikutnya →
                </button>
            </div>
        </div>
    </div>

</div>
@endsection