    @extends('layouts.admin.app')
    @section('title', 'Kelola Kurir')

    @section('content')

    @php
        $kurirs = $kurirs ?? collect([]);

        $totalAktif    = collect($kurirs ?? [])->where('status', 'aktif')->count();
$totalNonaktif = collect($kurirs ?? [])->where('status', 'nonaktif')->count();
$totalAntar    = collect($kurirs ?? [])->sum('total_antar');
$rataRating    = collect($kurirs ?? [])->avg('rating');
    @endphp

    <div class="fade-in">

        {{-- HEADER --}}
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-crate-primary font-script text-lg mb-0.5">Panel Admin</p>
                <h1 class="font-display text-3xl text-crate-text font-bold">Kelola Kurir</h1>
                <p class="text-crate-text/50 font-body mt-1 text-sm">
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
                ['label' => 'Total Kurir',      'value' => count($kurirs),                 'icon' => 'truck',      'color' => 'text-crate-text'],
                ['label' => 'Kurir Aktif',      'value' => $totalAktif,                   'icon' => 'badge-check','color' => 'text-emerald-600'],
                ['label' => 'Total Pengiriman', 'value' => $totalAntar,                   'icon' => 'package',    'color' => 'text-crate-primary'],
                ['label' => 'Rata-rata Rating', 'value' => number_format($rataRating, 1), 'icon' => 'star',       'color' => 'text-amber-500'],
            ];
            @endphp
            @foreach($stats as $stat)
            <div class="card-wood rounded-2xl p-4">
                <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 {{ $stat['color'] }} mb-2"></i>
                <p class="font-display text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
                <p class="text-crate-text/50 text-xs font-body mt-0.5">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- FILTER & SEARCH --}}
        <div class="card-wood rounded-2xl p-4 mb-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-crate-text/40"></i>
                    <input type="text"
                        placeholder="Cari nama / email kurir..."
                        class="pl-9 pr-4 py-2.5 rounded-xl border border-crate-accent bg-white
                                text-sm font-body text-crate-text placeholder-crate-stone w-full transition-all">
                </div>
                <select class="border border-crate-accent bg-white rounded-xl px-3 py-2.5
                            text-sm font-body text-crate-text transition-all">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                <select class="border border-crate-accent bg-white rounded-xl px-3 py-2.5
                            text-sm font-body text-crate-text transition-all">
                    <option value="">Semua Kendaraan</option>
                    <option value="motor">Motor</option>
                    <option value="sepeda">Sepeda</option>
                </select>
                <select class="border border-crate-accent bg-white rounded-xl px-3 py-2.5
                            text-sm font-body text-crate-text transition-all">
                    <option value="">Urutkan: Terbaru</option>
                    <option value="antar">Total Antar ↓</option>
                    <option value="rating">Rating ↓</option>
                    <option value="nama">Nama A–Z</option>
                </select>
            </div>
        </div>

        {{-- TABEL KURIR --}}
        <div class="card-wood rounded-2xl overflow-hidden">

            <div class="px-6 py-4 border-b border-crate-accent flex items-center justify-between">
                <h2 class="font-display text-base font-bold text-crate-text">Daftar Kurir</h2>
                <span class="text-crate-text/50 text-xs font-body">
                    {{ count($kurirs) }} kurir terdaftar
                </span>
            </div>

            <div class="divide-y divide-crate-accent/60">
                @forelse($kurirs as $k)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-crate-accent/50 transition-colors group">

                    {{-- Avatar --}}
                    <div class="w-11 h-11 rounded-full flex items-center justify-center shrink-0
                                text-white font-display font-bold text-sm
                                {{ $k['status'] === 'aktif' ? 'bg-crate-orange' : 'bg-crate-text/30' }}">
                        {{ $k['avatar'] }}
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-0.5">
                            <p class="font-body font-semibold text-crate-text text-sm">{{ $k['nama'] }}</p>
                            <span class="text-xs font-body font-semibold px-2 py-0.5 rounded-full
                                {{ $k['status'] === 'aktif'
                                    ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                    : 'bg-crate-accent text-crate-text/50 border border-crate-stone/20' }}">
                                {{ $k['status'] === 'aktif' ? '● Aktif' : '○ Nonaktif' }}
                            </span>
                        </div>
                        <p class="text-crate-text/50 text-xs font-body">{{ $k['email'] }}</p>
                        <div class="flex items-center gap-3 mt-1 flex-wrap">
                            <span class="text-crate-text/50 text-xs font-body flex items-center gap-1">
                                <i data-lucide="bike" class="w-3 h-3 shrink-0"></i>
                                {{ $k['kendaraan'] }}
                                @if($k['plat'] !== '-') · {{ $k['plat'] }} @endif
                            </span>
                            <span class="text-crate-text/50 text-xs font-body flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-3 h-3 shrink-0"></i>
                                {{ $k['wilayah'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Statistik --}}
                    <div class="hidden md:flex items-center gap-6 shrink-0">
                        <div class="text-center">
                            <p class="font-display font-bold text-crate-primary text-lg">
                                {{ $k['total_antar'] }}
                            </p>
                            <p class="text-crate-text/50 text-xs font-body">Total Antar</p>
                        </div>
                        <div class="text-center">
                            <p class="font-display font-bold text-crate-text text-lg">
                                {{ $k['bulan_ini'] }}
                            </p>
                            <p class="text-crate-text/50 text-xs font-body">Bulan Ini</p>
                        </div>
                        <div class="text-center">
                            <p class="font-display font-bold text-amber-500 text-lg">
                                {{ $k['rating'] }}
                            </p>
                            <p class="text-crate-text/50 text-xs font-body flex items-center gap-1 justify-center">
                                <i data-lucide="star" class="w-3 h-3 text-amber-400"></i> Rating
                            </p>
                        </div>
                    </div>

                    {{-- Bergabung --}}
                    <div class="hidden sm:block text-right shrink-0">
                        <p class="text-crate-text/50 text-xs font-body">Bergabung</p>
                        <p class="text-crate-text font-semibold text-xs font-body">{{ $k['bergabung'] }}</p>
                    </div>

                    {{-- Aksi --}}
                    <div class="flex items-center gap-2 shrink-0">

                        {{-- Detail --}}
                        <a href="{{ url('/admin/kurir/' . $k['id']) }}"
                        title="Detail"
                        class="w-8 h-8 rounded-lg border border-crate-accent flex items-center justify-center
                                text-crate-text/40 hover:text-crate-text hover:bg-crate-accent transition-colors">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ url('/admin/kurir/' . $k['id'] . '/edit') }}"
                        title="Edit"
                        class="w-8 h-8 rounded-lg border border-crate-accent flex items-center justify-center
                                text-crate-text/40 hover:text-crate-text hover:bg-crate-accent transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>

                        {{-- Toggle Status --}}
                        <form action="{{ url('/admin/kurir/' . $k['id'] . '/toggle-status') }}"
                            method="POST"
                            onsubmit="return confirm('Ubah status kurir ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    title="{{ $k['status'] === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                    class="w-8 h-8 rounded-lg border border-crate-accent flex items-center justify-center
                                        text-crate-text/40 transition-colors
                                        {{ $k['status'] === 'aktif' ? 'hover:text-red-500 hover:bg-red-50 hover:border-red-200' : 'hover:text-emerald-600 hover:bg-emerald-50 hover:border-emerald-200' }}">
                                <i data-lucide="{{ $k['status'] === 'aktif' ? 'toggle-right' : 'toggle-left' }}" class="w-4 h-4"></i>
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
                                    class="w-8 h-8 rounded-lg border border-crate-accent flex items-center justify-center
                                        text-crate-text/40 hover:text-red-500 hover:bg-red-50
                                        hover:border-red-200 transition-colors">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>

                    </div>

                </div>
                @empty
                <div class="px-6 py-16 text-center">
                    <i data-lucide="truck" class="w-12 h-12 text-crate-text/20 mx-auto mb-3"></i>
                    <p class="text-crate-text font-display text-lg font-bold">Belum ada kurir</p>
                    <p class="text-crate-text/50 text-sm font-body mt-1">
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
            <div class="px-6 py-4 border-t border-crate-accent flex items-center justify-between">
                <p class="text-crate-text/50 text-xs font-body">Halaman 1 dari 1</p>
                <div class="flex gap-2">
                    <button disabled
                            class="px-3 py-1.5 rounded-lg border border-crate-accent text-xs font-body
                                text-crate-text/50 disabled:opacity-40">
                        ← Sebelumnya
                    </button>
                    <button disabled
                            class="px-3 py-1.5 rounded-lg border border-crate-accent text-xs font-body
                                text-crate-text/50 disabled:opacity-40">
                        Berikutnya →
                    </button>
                </div>
            </div>

        </div>

    </div>
    @endsection