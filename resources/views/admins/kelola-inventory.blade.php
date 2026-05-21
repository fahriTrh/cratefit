@extends('layouts.admin.app')
@section('title', 'Inventory Thrift')

@section('content')

@php
$items = $items ?? [];

$totalItem = collect($items)->sum('stok');
$totalTersedia = collect($items)->where('status', 'tersedia')->count();
$totalHabis = collect($items)->where('status', 'habis')->count();
$totalDikurasi = collect($items)->where('status', 'dikurasi')->count();
$nilaiInventory = collect($items)->sum(fn($i) => $i['harga'] * $i['stok']);

$kondisiColor = [
'Sangat Bagus' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
'Bagus' => 'bg-blue-50 text-blue-700 border-blue-200',
'Cukup Bagus' => 'bg-amber-50 text-amber-700 border-amber-200',
];

$statusColor = [
'tersedia' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
'dikurasi' => 'bg-violet-50 text-violet-700 border-violet-200',
'habis' => 'bg-red-50 text-red-600 border-red-200',
];

$statusLabel = [
'tersedia' => '● Tersedia',
'dikurasi' => '◆ Dikurasi',
'habis' => '○ Habis',
];
@endphp

<div class="fade-in">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-crate-orange font-script text-lg mb-0.5">Panel Admin</p>
            <h1 class="font-display text-3xl text-crate-brown font-bold">Inventory Thrift</h1>
            <p class="text-crate-stone font-body mt-1 text-sm">
                Kelola stok item thrift yang siap dikurasi dan dikirimkan ke pelanggan.
            </p>
        </div>
        <button onclick="openModal('modal-tambah')"
            class="btn-primary text-white font-body font-semibold px-6 py-3 rounded-2xl text-sm
                       shadow-lg shrink-0 flex items-center gap-2">
            <span>+</span> Tambah Item
        </button>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-6">
        @php
        $stats = [
        ['label' => 'Total Unit Stok', 'value' => $totalItem, 'icon' => '👕', 'color' => 'text-crate-brown'],
        ['label' => 'Item Tersedia', 'value' => $totalTersedia, 'icon' => '✅', 'color' => 'text-emerald-600'],
        ['label' => 'Sedang Dikurasi', 'value' => $totalDikurasi, 'icon' => '✂️', 'color' => 'text-violet-600'],
        ['label' => 'Stok Habis', 'value' => $totalHabis, 'icon' => '⚠️', 'color' => 'text-red-500'],
        ['label' => 'Nilai Inventory', 'value' => 'Rp ' . number_format($nilaiInventory, 0, ',', '.'), 'icon' => '💰', 'color' => 'text-amber-600'],
        ];
        @endphp
        @foreach($stats as $stat)
        <div class="card-wood rounded-2xl p-4">
            <span class="text-xl block mb-1">{{ $stat['icon'] }}</span>
            <p class="font-display text-lg font-bold {{ $stat['color'] }} leading-tight">{{ $stat['value'] }}</p>
            <p class="text-crate-stone text-xs font-body mt-0.5">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="card-wood rounded-2xl p-4 mb-4">
        <div class="flex flex-col sm:flex-row gap-3">

            {{-- Search --}}
            <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-stone text-sm">🔍</span>
                <input type="text"
                    id="search-input"
                    placeholder="Cari nama item, kode, brand..."
                    class="pl-9 pr-4 py-2.5 rounded-xl border border-crate-sand bg-white
                              text-sm font-body text-crate-brown placeholder-crate-stone w-full transition-all">
            </div>

            {{-- Filter Kategori --}}
            <select id="filter-kategori"
                class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all">
                <option value="">Semua Kategori</option>
                <option value="Atasan">Atasan</option>
                <option value="Bawahan">Bawahan</option>
                <option value="Outerwear">Outerwear</option>
                <option value="Aksesoris">Aksesoris</option>
            </select>

            {{-- Filter Ukuran --}}
            <select id="filter-ukuran"
                class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all">
                <option value="">Semua Ukuran</option>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
            </select>

            {{-- Filter Status --}}
            <select id="filter-status"
                class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all">
                <option value="">Semua Status</option>
                <option value="tersedia">Tersedia</option>
                <option value="dikurasi">Dikurasi</option>
                <option value="habis">Habis</option>
            </select>

            {{-- Urutkan --}}
            <select id="filter-urut"
                class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all">
                <option value="terbaru">Terbaru Masuk</option>
                <option value="harga-naik">Harga ↑</option>
                <option value="harga-turun">Harga ↓</option>
                <option value="stok-naik">Stok ↑</option>
                <option value="nama">Nama A–Z</option>
            </select>

        </div>

        {{-- Tag Filter Cepat --}}
        <div class="flex flex-wrap gap-2 mt-3">
            @php
            $allTags = collect($items)->pluck('tags')->flatten()->unique()->values();
            @endphp
            <button onclick="filterTag('')"
                class="tag-quick px-3 py-1 rounded-full border border-crate-sand text-xs font-body
                           text-crate-stone hover:border-crate-orange hover:text-crate-orange transition-colors
                           bg-white selected" data-tag="">
                Semua
            </button>
            @foreach($allTags as $tag)
            <button onclick="filterTag('{{ $tag }}')"
                class="tag-quick px-3 py-1 rounded-full border border-crate-sand text-xs font-body
                           text-crate-stone hover:border-crate-orange hover:text-crate-orange transition-colors
                           bg-white" data-tag="{{ $tag }}">
                #{{ $tag }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- TABEL INVENTORY --}}
    <div class="card-wood rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base font-bold text-crate-brown">Daftar Item Thrift</h2>
            <div class="flex items-center gap-3">
                <span class="text-crate-stone text-xs font-body" id="count-label">
                    {{ count($items) }} item terdaftar
                </span>
                {{-- Toggle view --}}
                <div class="flex border border-crate-sand rounded-lg overflow-hidden">
                    <button id="btn-view-table"
                        onclick="setView('table')"
                        class="px-3 py-1.5 text-xs font-body bg-crate-orange text-white transition-colors"
                        title="Tampilan tabel">
                        ☰
                    </button>
                    <button id="btn-view-grid"
                        onclick="setView('grid')"
                        class="px-3 py-1.5 text-xs font-body text-crate-stone hover:bg-crate-sand transition-colors"
                        title="Tampilan grid">
                        ⊞
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== TAMPILAN TABEL ===== --}}
        <div id="view-table">
            <div class="overflow-x-auto">
                <table class="w-full text-sm font-body">
                    <thead>
                        <tr class="bg-crate-cream border-b border-crate-sand">
                            <th class="text-left px-6 py-3 text-crate-stone text-xs font-semibold uppercase tracking-wider">Item</th>
                            <th class="text-left px-4 py-3 text-crate-stone text-xs font-semibold uppercase tracking-wider hidden md:table-cell">Kategori</th>
                            <th class="text-center px-4 py-3 text-crate-stone text-xs font-semibold uppercase tracking-wider">Ukuran</th>
                            <th class="text-left px-4 py-3 text-crate-stone text-xs font-semibold uppercase tracking-wider hidden sm:table-cell">Kondisi</th>
                            <th class="text-right px-4 py-3 text-crate-stone text-xs font-semibold uppercase tracking-wider">Harga</th>
                            <th class="text-center px-4 py-3 text-crate-stone text-xs font-semibold uppercase tracking-wider">Stok</th>
                            <th class="text-center px-4 py-3 text-crate-stone text-xs font-semibold uppercase tracking-wider">Status</th>
                            <th class="text-center px-4 py-3 text-crate-stone text-xs font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-items" class="divide-y divide-crate-sand/60">
                        @forelse($items as $item)
                        <tr class="hover:bg-crate-cream/40 transition-colors group item-row"
                            data-nama="{{ strtolower($item['nama']) }}"
                            data-kode="{{ strtolower($item['kode']) }}"
                            data-brand="{{ strtolower($item['brand']) }}"
                            data-kategori="{{ $item['kategori'] }}"
                            data-ukuran="{{ $item['ukuran'] }}"
                            data-status="{{ $item['status'] }}"
                            data-tags="{{ implode(',', $item['tags']) }}"
                            data-harga="{{ $item['harga'] }}"
                            data-stok="{{ $item['stok'] }}"
                            data-masuk="{{ $item['masuk'] }}">

                            {{-- Item Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    {{-- Foto placeholder --}}
                                    <div class="w-10 h-10 rounded-xl bg-crate-sand/70 border border-crate-sand
                                                flex items-center justify-center text-base shrink-0 overflow-hidden">
                                        @if($item['foto'])
                                        <img src="{{ asset($item['foto']) }}" alt="{{ $item['nama'] }}" class="w-full h-full object-cover">
                                        @else
                                        👕
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-crate-brown text-sm truncate max-w-[160px]">
                                            {{ $item['nama'] }}
                                        </p>
                                        <div class="flex items-center gap-1.5 flex-wrap mt-0.5">
                                            <span class="text-crate-stone text-xs">{{ $item['kode'] }}</span>
                                            @if($item['brand'] !== 'Unbranded')
                                            <span class="text-xs bg-crate-sand text-crate-brown px-1.5 py-0.5 rounded font-semibold">
                                                {{ $item['brand'] }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-4 py-4 hidden md:table-cell">
                                <p class="text-crate-brown text-xs">{{ $item['kategori'] }}</p>
                                <p class="text-crate-stone text-xs mt-0.5">{{ $item['jenis'] }}</p>
                            </td>

                            {{-- Ukuran --}}
                            <td class="px-4 py-4 text-center">
                                <span class="font-display font-bold text-crate-brown text-sm
                                             bg-crate-cream border border-crate-sand px-2.5 py-1 rounded-lg">
                                    {{ $item['ukuran'] }}
                                </span>
                            </td>

                            {{-- Kondisi --}}
                            <td class="px-4 py-4 hidden sm:table-cell">
                                <span class="text-xs font-body font-semibold px-2 py-0.5 rounded-full border
                                             {{ $kondisiColor[$item['kondisi']] ?? 'bg-crate-sand text-crate-stone border-crate-sand' }}">
                                    {{ $item['kondisi'] }}
                                </span>
                            </td>

                            {{-- Harga --}}
                            <td class="px-4 py-4 text-right">
                                <span class="font-bold text-crate-orange text-sm">
                                    Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- Stok --}}
                            <td class="px-4 py-4 text-center">
                                <span class="font-display font-bold text-lg
                                             {{ $item['stok'] === 0 ? 'text-red-500' : ($item['stok'] === 1 ? 'text-amber-500' : 'text-crate-brown') }}">
                                    {{ $item['stok'] }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4 text-center">
                                <span class="text-xs font-body font-semibold px-2 py-0.5 rounded-full border
                                             {{ $statusColor[$item['status']] ?? '' }}">
                                    {{ $statusLabel[$item['status']] ?? $item['status'] }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-center gap-1.5">

                                    {{-- Edit --}}
                                    <button onclick="openModalEdit({{ json_encode($item) }})"
                                        title="Edit"
                                        class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                                                   text-crate-stone hover:text-crate-brown hover:bg-crate-sand transition-colors text-sm">
                                        ✏️
                                    </button>

                                    {{-- Tambah Stok --}}
                                    <form action="{{ url('/admin/inventory/' . $item['id'] . '/stok') }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="aksi" value="tambah">
                                        <button type="submit"
                                            title="Tambah stok (+1)"
                                            class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                                                   text-crate-stone hover:text-crate-brown hover:bg-crate-sand transition-colors text-sm">
                                            +
                                        </button>
                                    </form>

                                    {{-- Hapus --}}
                                    <form action="{{ url('/admin/inventory/' . $item['id']) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus item {{ $item['nama'] }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            title="Hapus"
                                            class="w-8 h-8 rounded-lg border border-crate-sand flex items-center justify-center
                                                   text-crate-stone hover:text-crate-brown hover:bg-crate-sand transition-colors text-sm">
                                            🗑
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <p class="text-4xl mb-3">👕</p>
                                <p class="text-crate-brown font-display text-lg font-bold">Belum ada item</p>
                                <p class="text-crate-stone text-sm font-body mt-1">
                                    Tambahkan item thrift untuk mulai mengkurasi box.
                                </p>
                                <button onclick="openModal('modal-tambah')"
                                    class="inline-block mt-4 btn-primary text-white font-body font-semibold
                                               px-6 py-2.5 rounded-xl text-sm">
                                    + Tambah Item
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== TAMPILAN GRID ===== --}}
        <div id="view-grid" class="hidden p-5">
            <div id="grid-items" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($items as $item)
                <div class="grid-item-card border border-crate-sand rounded-2xl overflow-hidden bg-white
                            hover:shadow-md hover:border-crate-stone/40 transition-all group
                            flex flex-col"
                    data-nama="{{ strtolower($item['nama']) }}"
                    data-kode="{{ strtolower($item['kode']) }}"
                    data-brand="{{ strtolower($item['brand']) }}"
                    data-kategori="{{ $item['kategori'] }}"
                    data-ukuran="{{ $item['ukuran'] }}"
                    data-status="{{ $item['status'] }}"
                    data-tags="{{ implode(',', $item['tags']) }}"
                    data-harga="{{ $item['harga'] }}"
                    data-stok="{{ $item['stok'] }}"
                    data-masuk="{{ $item['masuk'] }}">

                    {{-- Foto --}}
                    <div class="aspect-square bg-crate-cream/80 flex items-center justify-center
                                text-5xl border-b border-crate-sand relative">
                        @if($item['foto'])
                        <img src="{{ asset($item['foto']) }}" alt="{{ $item['nama'] }}"
                            class="w-full h-full object-cover">
                        @else
                        👕
                        @endif
                        {{-- Status badge overlay --}}
                        <span class="absolute top-2 right-2 text-xs font-body font-semibold
                                     px-2 py-0.5 rounded-full border
                                     {{ $statusColor[$item['status']] ?? '' }}">
                            {{ $statusLabel[$item['status']] ?? $item['status'] }}
                        </span>
                        @if($item['stok'] === 0)
                        <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                            <span class="text-red-500 text-xs font-body font-bold
                                         bg-white border border-red-200 px-2 py-1 rounded-lg">
                                Stok Habis
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="p-3 flex-1 flex flex-col">
                        <p class="font-body font-semibold text-crate-brown text-xs leading-tight truncate">
                            {{ $item['nama'] }}
                        </p>
                        <p class="text-crate-stone text-xs mt-0.5">{{ $item['kode'] }} · {{ $item['ukuran'] }}</p>
                        <div class="mt-auto pt-2 flex items-center justify-between">
                            <span class="font-bold text-crate-orange text-sm">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </span>
                            <span class="font-display font-bold text-crate-brown text-sm">
                                ×{{ $item['stok'] }}
                            </span>
                        </div>
                        {{-- Aksi grid --}}
                        <div class="mt-2 flex gap-1.5">
                            <button onclick="openModalEdit({{ json_encode($item) }})"
                                class="flex-1 border border-crate-sand text-crate-stone hover:bg-crate-sand
                                           rounded-lg py-1.5 text-xs font-body transition-colors">
                                ✏️ Edit
                            </button>
                            <form action="{{ url('/admin/inventory/' . $item['id']) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus {{ $item['nama'] }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex-1 border border-crate-sand text-crate-stone hover:bg-crate-sand
                                           rounded-lg py-1.5 text-xs font-body transition-colors">
                                    🗑
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tidak ada hasil filter --}}
        <div id="no-result" class="hidden px-6 py-16 text-center">
            <p class="text-3xl mb-3">🔍</p>
            <p class="text-crate-brown font-display text-base font-bold">Tidak ada item yang cocok</p>
            <p class="text-crate-stone text-sm font-body mt-1">Coba ubah kata kunci atau filter pencarian.</p>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-crate-sand flex items-center justify-between">
            <p class="text-crate-stone text-xs font-body">Halaman 1 dari 1</p>
            <div class="flex gap-2">
                <button disabled class="px-3 py-1.5 rounded-lg border border-crate-sand text-xs font-body
                                        text-crate-stone disabled:opacity-40">← Sebelumnya</button>
                <button disabled class="px-3 py-1.5 rounded-lg border border-crate-sand text-xs font-body
                                        text-crate-stone disabled:opacity-40">Berikutnya →</button>
            </div>
        </div>

    </div>

</div>

{{-- ================================================================
     MODAL: TAMBAH ITEM
================================================================ --}}
<div id="modal-tambah"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
    style="background:rgba(42,21,8,0.55);backdrop-filter:blur(4px)">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-crate-sand">

        <div class="flex items-center justify-between px-6 py-4 border-b border-crate-sand sticky top-0 bg-white z-10">
            <h3 class="font-display font-bold text-crate-brown text-lg">+ Tambah Item Thrift</h3>
            <button onclick="closeModal('modal-tambah')"
                class="w-8 h-8 rounded-lg text-crate-stone hover:text-crate-brown hover:bg-crate-sand
                           flex items-center justify-center transition-colors text-xl leading-none">×</button>
        </div>

        <form action="{{ url('/admin/inventory') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <div class="grid sm:grid-cols-2 gap-4">

                {{-- Nama Item --}}
                <div class="sm:col-span-2">
                    <label class="field-label">Nama Item <span class="text-red-400">*</span></label>
                    <input type="text" name="nama" placeholder="Contoh: Kemeja Flannel Vintage" required
                        class="field-input w-full">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="field-label">Kategori <span class="text-red-400">*</span></label>
                    <select name="kategori" required class="field-input w-full">
                        <option value="" disabled selected>— Pilih kategori —</option>
                        <option value="Atasan">Atasan</option>
                        <option value="Bawahan">Bawahan</option>
                        <option value="Outerwear">Outerwear</option>
                        <option value="Aksesoris">Aksesoris</option>
                        <option value="Sepatu">Sepatu</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                {{-- Jenis --}}
                <div>
                    <label class="field-label">Jenis Item <span class="text-red-400">*</span></label>
                    <input type="text" name="jenis" placeholder="Contoh: Kemeja, Celana, Jaket" required
                        class="field-input w-full">
                </div>

                {{-- Ukuran --}}
                <div>
                    <label class="field-label">Ukuran <span class="text-red-400">*</span></label>
                    <select name="ukuran" required class="field-input w-full">
                        <option value="" disabled selected>— Pilih ukuran —</option>
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                        <option value="XXXL">XXXL</option>
                        <option value="Free Size">Free Size</option>
                    </select>
                </div>

                {{-- Warna --}}
                <div>
                    <label class="field-label">Warna</label>
                    <input type="text" name="warna" placeholder="Contoh: Biru Tua, Hitam & Putih"
                        class="field-input w-full">
                </div>

                {{-- Brand --}}
                <div>
                    <label class="field-label">Brand / Merek</label>
                    <input type="text" name="brand" placeholder="Contoh: Levi's, H&M, Unbranded"
                        class="field-input w-full">
                </div>

                {{-- Kondisi --}}
                <div>
                    <label class="field-label">Kondisi <span class="text-red-400">*</span></label>
                    <select name="kondisi" required class="field-input w-full">
                        <option value="" disabled selected>— Pilih kondisi —</option>
                        <option value="Sangat Bagus">Sangat Bagus</option>
                        <option value="Bagus">Bagus</option>
                        <option value="Cukup Bagus">Cukup Bagus</option>
                    </select>
                </div>

                {{-- Harga --}}
                <div>
                    <label class="field-label">Harga Satuan (Rp) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-stone text-xs font-body">Rp</span>
                        <input type="number" name="harga" min="0" step="500" placeholder="45000" required
                            class="field-input w-full pl-9">
                    </div>
                </div>

                {{-- Stok --}}
                <div>
                    <label class="field-label">Jumlah Stok <span class="text-red-400">*</span></label>
                    <input type="number" name="stok" min="0" placeholder="1" required
                        class="field-input w-full">
                </div>

                {{-- Status --}}
                <div>
                    <label class="field-label">Status Awal</label>
                    <select name="status" class="field-input w-full">
                        <option value="tersedia">Tersedia</option>
                        <option value="dikurasi">Dikurasi</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>

                {{-- Tags --}}
                <div class="sm:col-span-2">
                    <label class="field-label">
                        Tags / Style
                        <span class="text-crate-stone font-normal normal-case tracking-normal">(pisahkan dengan koma)</span>
                    </label>
                    <input type="text" name="tags" placeholder="casual, vintage, streetwear, feminine"
                        class="field-input w-full">
                </div>

                {{-- Catatan --}}
                <div class="sm:col-span-2">
                    <label class="field-label">
                        Catatan
                        <span class="text-crate-stone font-normal normal-case tracking-normal">(opsional)</span>
                    </label>
                    <textarea name="catatan" rows="2"
                        placeholder="Catatan tambahan tentang kondisi, detail unik, dll..."
                        class="field-input w-full resize-none"></textarea>
                </div>

                {{-- Foto --}}
                <div class="sm:col-span-2">
                    <label class="field-label">
                        Foto Item
                        <span class="text-crate-stone font-normal normal-case tracking-normal">(opsional, JPG/PNG maks. 2MB)</span>
                    </label>
                    <label for="foto-tambah"
                        class="flex items-center gap-3 border-2 border-dashed border-crate-sand
                                  rounded-xl px-4 py-3 cursor-pointer hover:border-crate-orange/50
                                  hover:bg-crate-cream/40 transition-all">
                        <span class="text-2xl">📷</span>
                        <div>
                            <p class="text-crate-brown text-xs font-body font-semibold">Klik untuk unggah foto</p>
                            <p class="text-crate-stone text-xs font-body" id="foto-tambah-name">Belum ada file dipilih</p>
                        </div>
                        <input type="file" name="foto" id="foto-tambah"
                            accept="image/jpeg,image/png" class="sr-only"
                            onchange="document.getElementById('foto-tambah-name').textContent = this.files[0]?.name || 'Belum ada file dipilih'">
                    </label>
                </div>

            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-crate-sand">
                <button type="button" onclick="closeModal('modal-tambah')"
                    class="px-5 py-2.5 border border-crate-sand text-crate-stone font-body font-semibold
                               text-sm rounded-xl hover:bg-crate-sand hover:text-crate-brown transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="btn-primary text-white font-body font-semibold px-6 py-2.5 rounded-xl text-sm shadow">
                    + Simpan Item
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================================================================
     MODAL: EDIT ITEM
================================================================ --}}
<div id="modal-edit"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
    style="background:rgba(42,21,8,0.55);backdrop-filter:blur(4px)">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-crate-sand">

        <div class="flex items-center justify-between px-6 py-4 border-b border-crate-sand sticky top-0 bg-white z-10">
            <h3 class="font-display font-bold text-crate-brown text-lg">✏️ Edit Item Thrift</h3>
            <button onclick="closeModal('modal-edit')"
                class="w-8 h-8 rounded-lg text-crate-stone hover:text-crate-brown hover:bg-crate-sand
                           flex items-center justify-center transition-colors text-xl leading-none">×</button>
        </div>

        <form id="form-edit" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label class="field-label">Nama Item <span class="text-red-400">*</span></label>
                    <input type="text" name="nama" id="edit-nama" required class="field-input w-full">
                </div>

                <div>
                    <label class="field-label">Kategori <span class="text-red-400">*</span></label>
                    <select name="kategori" id="edit-kategori" required class="field-input w-full">
                        <option value="Atasan">Atasan</option>
                        <option value="Bawahan">Bawahan</option>
                        <option value="Outerwear">Outerwear</option>
                        <option value="Aksesoris">Aksesoris</option>
                        <option value="Sepatu">Sepatu</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="field-label">Jenis Item <span class="text-red-400">*</span></label>
                    <input type="text" name="jenis" id="edit-jenis" required class="field-input w-full">
                </div>

                <div>
                    <label class="field-label">Ukuran <span class="text-red-400">*</span></label>
                    <select name="ukuran" id="edit-ukuran" required class="field-input w-full">
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                        <option value="XXXL">XXXL</option>
                        <option value="Free Size">Free Size</option>
                    </select>
                </div>

                <div>
                    <label class="field-label">Warna</label>
                    <input type="text" name="warna" id="edit-warna" class="field-input w-full">
                </div>

                <div>
                    <label class="field-label">Brand / Merek</label>
                    <input type="text" name="brand" id="edit-brand" class="field-input w-full">
                </div>

                <div>
                    <label class="field-label">Kondisi <span class="text-red-400">*</span></label>
                    <select name="kondisi" id="edit-kondisi" required class="field-input w-full">
                        <option value="Sangat Bagus">Sangat Bagus</option>
                        <option value="Bagus">Bagus</option>
                        <option value="Cukup Bagus">Cukup Bagus</option>
                    </select>
                </div>

                <div>
                    <label class="field-label">Harga Satuan (Rp) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-stone text-xs font-body">Rp</span>
                        <input type="number" name="harga" id="edit-harga" min="0" step="500" required
                            class="field-input w-full pl-9">
                    </div>
                </div>

                <div>
                    <label class="field-label">Jumlah Stok <span class="text-red-400">*</span></label>
                    <input type="number" name="stok" id="edit-stok" min="0" required class="field-input w-full">
                </div>

                <div>
                    <label class="field-label">Status</label>
                    <select name="status" id="edit-status" class="field-input w-full">
                        <option value="tersedia">Tersedia</option>
                        <option value="dikurasi">Dikurasi</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="field-label">
                        Tags / Style
                        <span class="text-crate-stone font-normal normal-case tracking-normal">(pisahkan dengan koma)</span>
                    </label>
                    <input type="text" name="tags" id="edit-tags" class="field-input w-full">
                </div>

                <div class="sm:col-span-2">
                    <label class="field-label">Foto Baru
                        <span class="text-crate-stone font-normal normal-case tracking-normal">(kosongkan jika tidak ingin mengubah)</span>
                    </label>
                    <label for="foto-edit"
                        class="flex items-center gap-3 border-2 border-dashed border-crate-sand
                                  rounded-xl px-4 py-3 cursor-pointer hover:border-crate-orange/50
                                  hover:bg-crate-cream/40 transition-all">
                        <span class="text-2xl">📷</span>
                        <div>
                            <p class="text-crate-brown text-xs font-body font-semibold">Klik untuk ganti foto</p>
                            <p class="text-crate-stone text-xs font-body" id="foto-edit-name">Belum ada file dipilih</p>
                        </div>
                        <input type="file" name="foto" id="foto-edit"
                            accept="image/jpeg,image/png" class="sr-only"
                            onchange="document.getElementById('foto-edit-name').textContent = this.files[0]?.name || 'Belum ada file dipilih'">
                    </label>
                </div>

            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-crate-sand">
                <button type="button" onclick="closeModal('modal-edit')"
                    class="px-5 py-2.5 border border-crate-sand text-crate-stone font-body font-semibold
                               text-sm rounded-xl hover:bg-crate-sand hover:text-crate-brown transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="btn-primary text-white font-body font-semibold px-6 py-2.5 rounded-xl text-sm shadow">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .field-label {
        display: block;
        color: #3B1F0E;
        font-size: 0.7rem;
        font-family: 'DM Sans', sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.375rem;
    }

    .field-input {
        border: 1px solid #EDE0CC;
        background: white;
        border-radius: 0.75rem;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        font-family: 'DM Sans', sans-serif;
        color: #3B1F0E;
        transition: all 0.15s;
    }

    .field-input:focus {
        outline: none;
        border-color: #C85A1A;
        box-shadow: 0 0 0 3px rgba(200, 90, 26, 0.12);
    }

    .tag-quick.selected {
        background: #C85A1A;
        color: white;
        border-color: #C85A1A;
    }
</style>

@push('scripts')
<script>
    // ===== Modal =====
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = '';
    }
    ['modal-tambah', 'modal-edit'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) closeModal(id);
        });
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeModal('modal-tambah');
            closeModal('modal-edit');
        }
    });

    // ===== Isi modal edit =====
    function openModalEdit(item) {
        document.getElementById('edit-nama').value = item.nama ?? '';
        document.getElementById('edit-jenis').value = item.jenis ?? '';
        document.getElementById('edit-warna').value = item.warna ?? '';
        document.getElementById('edit-brand').value = item.brand ?? '';
        document.getElementById('edit-harga').value = item.harga ?? '';
        document.getElementById('edit-stok').value = item.stok ?? '';
        document.getElementById('edit-tags').value = Array.isArray(item.tags) ? item.tags.join(', ') : '';

        setSelectValue('edit-kategori', item.kategori);
        setSelectValue('edit-ukuran', item.ukuran);
        setSelectValue('edit-kondisi', item.kondisi);
        setSelectValue('edit-status', item.status);

        document.getElementById('form-edit').action = '/admin/inventory/' + item.id;
        document.getElementById('foto-edit-name').textContent = 'Belum ada file dipilih';

        openModal('modal-edit');
    }

    function setSelectValue(id, val) {
        const el = document.getElementById(id);
        if (!el || !val) return;
        for (let opt of el.options) {
            opt.selected = opt.value === val;
        }
    }

    // ===== Toggle view tabel / grid =====
    function setView(mode) {
        const tableEl = document.getElementById('view-table');
        const gridEl = document.getElementById('view-grid');
        const btnT = document.getElementById('btn-view-table');
        const btnG = document.getElementById('btn-view-grid');

        if (mode === 'table') {
            tableEl.classList.remove('hidden');
            gridEl.classList.add('hidden');
            btnT.classList.add('bg-crate-orange', 'text-white');
            btnT.classList.remove('text-crate-stone');
            btnG.classList.remove('bg-crate-orange', 'text-white');
            btnG.classList.add('text-crate-stone');
        } else {
            gridEl.classList.remove('hidden');
            tableEl.classList.add('hidden');
            btnG.classList.add('bg-crate-orange', 'text-white');
            btnG.classList.remove('text-crate-stone');
            btnT.classList.remove('bg-crate-orange', 'text-white');
            btnT.classList.add('text-crate-stone');
        }
        applyFilters();
    }

    // ===== Filter & Search =====
    let activeTag = '';

    function filterTag(tag) {
        activeTag = tag;
        document.querySelectorAll('.tag-quick').forEach(btn => {
            btn.classList.toggle('selected', btn.dataset.tag === tag);
        });
        applyFilters();
    }

    function applyFilters() {
        console.log('applyFilters dipanggil dari:', new Error().stack);

        const q = document.getElementById('search-input').value.toLowerCase();
        const kategori = document.getElementById('filter-kategori').value;
        const ukuran = document.getElementById('filter-ukuran').value;
        const status = document.getElementById('filter-status').value;
        const urut = document.getElementById('filter-urut').value;

        const isGrid = !document.getElementById('view-grid').classList.contains('hidden');
        const rows = isGrid ?
            Array.from(document.querySelectorAll('.grid-item-card')) :
            Array.from(document.querySelectorAll('.item-row'));

        let visible = rows.filter(row => {
            const matchQ = !q || row.dataset.nama.includes(q) || row.dataset.kode.includes(q) || row.dataset.brand.includes(q);
            const matchKategori = !kategori || row.dataset.kategori === kategori;
            const matchUkuran = !ukuran || row.dataset.ukuran === ukuran;
            const matchStatus = !status || row.dataset.status === status;
            const matchTag = !activeTag || row.dataset.tags.split(',').includes(activeTag);
            return matchQ && matchKategori && matchUkuran && matchStatus && matchTag;
        });

        // Urutkan
        visible.sort((a, b) => {
            if (urut === 'harga-naik') return +a.dataset.harga - +b.dataset.harga;
            if (urut === 'harga-turun') return +b.dataset.harga - +a.dataset.harga;
            if (urut === 'stok-naik') return +a.dataset.stok - +b.dataset.stok;
            if (urut === 'nama') return a.dataset.nama.localeCompare(b.dataset.nama);
            return 0; // terbaru — pertahankan urutan DOM
        });

        // Sembunyikan semua
        rows.forEach(r => r.style.display = 'none');

        // Tampilkan yang cocok sesuai urutan
        const parent = isGrid ?
            document.getElementById('grid-items') :
            document.getElementById('tbody-items');

            visible.forEach(r => {
    r.style.display = '';   // reset ke default browser (table-row)
    parent.appendChild(r);
});

        // No-result
        document.getElementById('no-result').classList.toggle('hidden', visible.length > 0);

        // Update count
        document.getElementById('count-label').textContent = visible.length + ' item' + (visible.length !== rows.length ? ' ditemukan' : ' terdaftar');
    }

    // Event listeners filter
    ['search-input', 'filter-kategori', 'filter-ukuran', 'filter-status', 'filter-urut'].forEach(id => {
        document.getElementById(id).addEventListener('input', applyFilters);
        document.getElementById(id).addEventListener('change', applyFilters);
    });
</script>
@endpush

@endsection