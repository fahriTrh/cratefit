@extends('layouts.admin.app')
@section('title', 'Kelola Paket Subscription')

@section('content')

@php
    $pakets = $pakets ?? [];

    $totalAktif      = collect($pakets)->where('aktif', true)->count();
    $totalLangganan  = collect($pakets)->sum('langganan_aktif');
    $totalPendapatan = collect($pakets)->sum('pendapatan_bulan');
    $paketTerlaris   = collect($pakets)->sortByDesc('langganan_aktif')->first();
@endphp

<div class="fade-in">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-crate-primary font-script text-lg mb-0.5">Panel Admin</p>
            <h1 class="font-display text-3xl text-crate-text font-bold">Kelola Paket Subscription</h1>
            <p class="text-crate-text/50 font-body mt-1 text-sm">
                Atur paket, harga, fitur, dan status yang ditawarkan kepada pelanggan Cratefit.
            </p>
        </div>
        <button onclick="openModal('modal-tambah')"
                class="btn-primary text-white font-body font-semibold px-6 py-3 rounded-2xl text-sm
                       shadow-lg text-center shrink-0 flex items-center gap-2">
            <span>+</span> Tambah Paket
        </button>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        @php
        $stats = [
            ['label' => 'Total Paket',      'value' => count($pakets),    'icon' => 'package',  'color' => 'text-crate-text'],
            ['label' => 'Paket Aktif',      'value' => $totalAktif,       'icon' => 'badge-check','color' => 'text-emerald-600'],
            ['label' => 'Total Subscriber', 'value' => $totalLangganan,   'icon' => 'users',    'color' => 'text-crate-primary'],
            ['label' => 'Pendapatan/Bulan', 'value' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.'), 'icon' => 'wallet', 'color' => 'text-amber-600'],
        ];
        @endphp
        @foreach($stats as $stat)
        <div class="card-wood rounded-2xl p-4">
            <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 {{ $stat['color'] }} mb-2"></i>
            <p class="font-display text-xl font-bold {{ $stat['color'] }} leading-tight">{{ $stat['value'] }}</p>
            <p class="text-crate-text/50 text-xs font-body mt-0.5">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- BANNER PAKET TERLARIS --}}
    @if($paketTerlaris)
    <div class="mb-6 bg-gradient-to-r from-crate-primary to-crate-text rounded-2xl p-5
                flex items-center gap-4 shadow-lg">
        <div class="text-3xl shrink-0">{{ $paketTerlaris['icon'] }}</div>
        <div class="flex-1 min-w-0">
            <p class="text-white/60 text-xs font-body">Paket Terlaris Saat Ini</p>
            <p class="text-white font-display font-bold text-lg leading-tight">
                {{ $paketTerlaris['nama'] }}
            </p>
            <p class="text-white/80 text-xs font-body mt-0.5">
                {{ $paketTerlaris['langganan_aktif'] }} subscriber aktif
                · Rp {{ number_format($paketTerlaris['pendapatan_bulan'], 0, ',', '.') }}/bulan
            </p>
        </div>
        <div class="shrink-0 text-right hidden sm:block">
            <p class="text-white/60 text-xs font-body">Konversi</p>
            <p class="text-white font-display font-bold text-2xl">
                {{ round(($paketTerlaris['langganan_aktif'] / max($paketTerlaris['total_langganan'], 1)) * 100) }}%
            </p>
        </div>
    </div>
    @endif

    {{-- GRID PAKET --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
        @foreach($pakets as $p)
        <div class="card-wood rounded-2xl flex flex-col overflow-visible
                    {{ !$p['aktif'] ? 'opacity-60' : '' }}">

            {{-- Badge terlaris / highlight --}}
            @if($p['badge'])
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-10
                        bg-crate-orange text-white text-xs font-body font-semibold
                        px-4 py-1 rounded-full shadow-md whitespace-nowrap">
                {{ $p['badge'] }}
            </div>
            @endif

            {{-- Header Paket --}}
            <div class="p-6 pb-4 border-b border-crate-accent/70">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shrink-0
                                    {{ $p['highlight'] ? 'bg-crate-orange/10' : 'bg-crate-accent' }}
                                    border border-crate-accent">
                            {{ $p['icon'] }}
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-crate-text text-base leading-tight">
                                {{ $p['nama'] }}
                            </h3>
                            <p class="text-crate-text/50 text-xs font-body">{{ $p['items'] }} item per box</p>
                        </div>
                    </div>
                    {{-- Toggle aktif/nonaktif --}}
                    <form action="{{ url('/admin/paket/' . $p['id'] . '/toggle') }}"
                          method="POST"
                          onsubmit="return confirm('Ubah status paket {{ $p['nama'] }}?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="relative inline-flex h-6 w-11 items-center rounded-full
                                       transition-colors focus:outline-none shrink-0
                                       {{ $p['aktif'] ? 'bg-emerald-400' : 'bg-crate-accent' }}"
                                title="{{ $p['aktif'] ? 'Nonaktifkan' : 'Aktifkan' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform
                                         {{ $p['aktif'] ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                    </form>
                </div>

                {{-- Harga --}}
                <div class="mt-1">
                    <span class="font-display font-bold text-crate-primary text-2xl">
                        Rp {{ number_format($p['harga'], 0, ',', '.') }}
                    </span>
                    <span class="text-crate-text/50 text-xs font-body">/periode</span>
                </div>

                <p class="text-crate-text/50 text-xs font-body mt-2 leading-relaxed">
                    {{ $p['deskripsi'] }}
                </p>
            </div>

            {{-- Fitur --}}
            <div class="p-6 pt-4 flex-1">
                <p class="text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-2">
                    Yang Didapat
                </p>
                <ul class="space-y-1.5 mb-4">
                    @foreach($p['fitur'] as $f)
                    <li class="flex items-start gap-2 text-xs font-body text-crate-text/80">
                        <span class="text-emerald-500 mt-0.5 shrink-0 font-bold">✓</span>
                        {{ $f }}
                    </li>
                    @endforeach
                    @foreach($p['tidak'] as $t)
                    <li class="flex items-start gap-2 text-xs font-body text-crate-text/50/60 line-through">
                        <span class="mt-0.5 shrink-0">✗</span>
                        {{ $t }}
                    </li>
                    @endforeach
                </ul>

                {{-- Statistik subscriber --}}
                <div class="bg-crate-accent rounded-xl border border-crate-accent p-3 space-y-2">
                    <div class="flex justify-between items-center text-xs font-body">
                        <span class="text-crate-text/50">Subscriber Aktif</span>
                        <span class="text-crate-text font-bold">{{ $p['langganan_aktif'] }}</span>
                    </div>
                    <div class="w-full bg-crate-accent rounded-full h-1.5">
                        @php
                            $pctBar = $p['total_langganan'] > 0
                                ? round(($p['langganan_aktif'] / $p['total_langganan']) * 100)
                                : 0;
                        @endphp
                        <div class="h-1.5 rounded-full bg-crate-orange transition-all"
                             style="width:{{ $pctBar }}%"></div>
                    </div>
                    <div class="flex justify-between items-center text-xs font-body">
                        <span class="text-crate-text/50">Total semua waktu</span>
                        <span class="text-crate-text/50">{{ $p['total_langganan'] }}</span>
                    </div>
                    <div class="border-t border-crate-accent pt-2 flex justify-between items-center text-xs font-body">
                        <span class="text-crate-text/50">Pendapatan bulan ini</span>
                        <span class="text-crate-primary font-bold">
                            Rp {{ number_format($p['pendapatan_bulan'], 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="px-6 pb-5 flex gap-2">
                <button onclick="openModalEdit({{ json_encode($p) }})"
                        class="flex-1 border border-crate-accent text-crate-text/50 hover:text-crate-text
                            hover:bg-crate-accent font-body font-semibold text-xs py-2.5 rounded-xl
                            transition-colors flex items-center justify-center gap-1.5">
                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit
                </button>
                <a href="{{ url('/admin/paket/' . $p['id'] . '/langganan') }}"
                class="flex-1 border border-crate-accent text-crate-text/50 hover:text-crate-text
                        hover:bg-crate-accent font-body font-semibold text-xs py-2.5 rounded-xl
                        transition-colors flex items-center justify-center gap-1.5">
                    <i data-lucide="users" class="w-3.5 h-3.5"></i> Subscriber
                </a>
                <form action="{{ url('/admin/paket/' . $p['id']) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus paket {{ $p['nama'] }}? Subscriber aktif tidak akan terpengaruh.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-9 h-9 border border-crate-accent rounded-xl flex items-center justify-center
                                text-crate-text/40 hover:text-red-500 hover:bg-red-50 hover:border-red-200
                                transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

        </div>
        @endforeach
    </div>

    {{-- TABEL PERBANDINGAN PAKET --}}
    <div class="card-wood rounded-2xl overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-crate-accent flex items-center justify-between">
            <h2 class="font-display text-base font-bold text-crate-text flex items-center gap-2">
                <i data-lucide="bar-chart-2" class="w-4 h-4 text-crate-primary"></i> Perbandingan Performa Paket
            </h2>            
            <span class="text-crate-text/50 text-xs font-body">Data bulan berjalan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm font-body">
                <thead>
                    <tr class="bg-crate-accent border-b border-crate-accent">
                        <th class="text-left px-6 py-3 text-crate-text/50 text-xs font-semibold uppercase tracking-wider">
                            Paket
                        </th>
                        <th class="text-right px-4 py-3 text-crate-text/50 text-xs font-semibold uppercase tracking-wider">
                            Harga
                        </th>
                        <th class="text-right px-4 py-3 text-crate-text/50 text-xs font-semibold uppercase tracking-wider">
                            Subscriber Aktif
                        </th>
                        <th class="text-right px-4 py-3 text-crate-text/50 text-xs font-semibold uppercase tracking-wider">
                            Total s/d Kini
                        </th>
                        <th class="text-right px-4 py-3 text-crate-text/50 text-xs font-semibold uppercase tracking-wider">
                            Pendapatan/Bulan
                        </th>
                        <th class="text-center px-4 py-3 text-crate-text/50 text-xs font-semibold uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-crate-accent/60">
                    @foreach($pakets as $p)
                    <tr class="hover:bg-crate-accent/40 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">{{ $p['icon'] }}</span>
                                <div>
                                    <p class="font-semibold text-crate-text text-sm">{{ $p['nama'] }}</p>
                                    <p class="text-crate-text/50 text-xs">{{ $p['items'] }} item/box</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <span class="text-crate-primary font-bold">
                                Rp {{ number_format($p['harga'], 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <span class="font-bold text-crate-text">{{ $p['langganan_aktif'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-right text-crate-text/50">
                            {{ $p['total_langganan'] }}
                        </td>
                        <td class="px-4 py-4 text-right">
                            <span class="font-semibold text-emerald-600">
                                Rp {{ number_format($p['pendapatan_bulan'], 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full border
                                {{ $p['aktif']
                                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                    : 'bg-crate-accent text-crate-text/50 border-crate-stone/20' }}">
                                {{ $p['aktif'] ? '● Aktif' : '○ Nonaktif' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-crate-accent border-t-2 border-crate-accent">
                        <td colspan="2" class="px-6 py-3 text-crate-text font-display font-bold text-sm">
                            Total Keseluruhan
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-crate-text">
                            {{ $totalLangganan }}
                        </td>
                        <td class="px-4 py-3 text-right text-crate-text/50 font-semibold">
                            {{ collect($pakets)->sum('total_langganan') }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold text-emerald-600">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

{{-- ================================================================
     MODAL: TAMBAH PAKET
================================================================ --}}
<div id="modal-tambah"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
     style="background:rgba(43,43,43,0.45);backdrop-filter:blur(4px)">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto
                border border-crate-accent animate-[fadeUp_0.3s_ease_both]">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-crate-accent sticky top-0 bg-white z-10">
            <h3 class="font-display font-bold text-crate-text text-lg">+ Tambah Paket Baru</h3>
            <button onclick="closeModal('modal-tambah')"
                    class="w-8 h-8 rounded-lg text-crate-text/50 hover:text-crate-text hover:bg-crate-accent
                           flex items-center justify-center transition-colors text-lg">×</button>
        </div>

        {{-- Form --}}
        <form action="{{ url('/admin/paket') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div class="grid sm:grid-cols-2 gap-4">

                {{-- Nama Paket --}}
                <div class="sm:col-span-2">
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Nama Paket <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="nama" placeholder="Contoh: Premium Box" required
                           class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                  text-sm font-body text-crate-text placeholder-crate-stone transition-all">
                </div>

                {{-- Ikon --}}
                <div>
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Ikon (Emoji) <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="icon" placeholder="🌱" maxlength="4" required
                           class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                  text-sm font-body text-crate-text placeholder-crate-stone transition-all text-2xl">
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Harga / Periode (Rp) <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-text/50 text-xs font-body">Rp</span>
                        <input type="number" name="harga" min="0" step="1000" placeholder="129000" required
                               class="w-full border border-crate-accent bg-white rounded-xl pl-9 pr-4 py-2.5
                                      text-sm font-body text-crate-text placeholder-crate-stone transition-all">
                    </div>
                </div>

                {{-- Jumlah Item --}}
                <div>
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Jumlah Item per Box <span class="text-red-400">*</span>
                    </label>
                    <input type="number" name="items" min="1" max="20" placeholder="5" required
                           class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                  text-sm font-body text-crate-text placeholder-crate-stone transition-all">
                </div>

                {{-- Label Badge --}}
                <div>
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Label Badge
                        <span class="text-crate-text/50 font-normal normal-case tracking-normal">(opsional)</span>
                    </label>
                    <input type="text" name="badge" placeholder="Contoh: Paling Populer"
                           class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                  text-sm font-body text-crate-text placeholder-crate-stone transition-all">
                </div>

                {{-- Deskripsi --}}
                <div class="sm:col-span-2">
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Deskripsi Singkat
                    </label>
                    <textarea name="deskripsi" rows="2"
                              placeholder="Deskripsi singkat paket yang tampil di halaman langganan..."
                              class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                     text-sm font-body text-crate-text placeholder-crate-stone transition-all resize-none"></textarea>
                </div>

                {{-- Fitur (Didapat) --}}
                <div class="sm:col-span-2">
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Fitur yang Didapat
                        <span class="text-crate-text/50 font-normal normal-case tracking-normal">
                            (satu per baris)
                        </span>
                    </label>
                    <textarea name="fitur" rows="4"
                              placeholder="Gratis ongkir ke seluruh Indonesia&#10;3 item pilihan kurator&#10;Priority curation"
                              class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                     text-sm font-body text-crate-text placeholder-crate-stone transition-all resize-none"></textarea>
                </div>

                {{-- Fitur Tidak --}}
                <div class="sm:col-span-2">
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Fitur Tidak Tersedia
                        <span class="text-crate-text/50 font-normal normal-case tracking-normal">
                            (satu per baris, opsional)
                        </span>
                    </label>
                    <textarea name="tidak" rows="2"
                              placeholder="Priority curation&#10;Bonus item surprise"
                              class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                     text-sm font-body text-crate-text placeholder-crate-stone transition-all resize-none"></textarea>
                </div>

                {{-- Opsi --}}
                <div class="sm:col-span-2 flex flex-wrap gap-5">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="highlight" value="1"
                               class="w-4 h-4 rounded border-crate-accent accent-crate-primary">
                        <span class="text-crate-text text-sm font-body">Tandai sebagai paket rekomendasi</span>
                    </label>
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="aktif" value="1" checked
                               class="w-4 h-4 rounded border-crate-accent accent-crate-primary">
                        <span class="text-crate-text text-sm font-body">Langsung aktif / tampil ke pelanggan</span>
                    </label>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-crate-accent">
                <button type="button" onclick="closeModal('modal-tambah')"
                        class="px-5 py-2.5 border border-crate-accent text-crate-text/50 font-body font-semibold
                               text-sm rounded-xl hover:bg-crate-accent hover:text-crate-text transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="btn-primary text-white font-body font-semibold px-6 py-2.5 rounded-xl text-sm shadow">
                    + Simpan Paket
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ================================================================
     MODAL: EDIT PAKET
================================================================ --}}
<div id="modal-edit"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
     style="background:rgba(43,43,43,0.45);backdrop-filter:blur(4px)">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto
                border border-crate-accent">

        <div class="flex items-center justify-between px-6 py-4 border-b border-crate-accent sticky top-0 bg-white z-10">
            <h3 class="font-display font-bold text-crate-text text-lg flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4 text-crate-primary"></i> Edit Paket
            </h3>
            <button onclick="closeModal('modal-edit')"
                    class="w-8 h-8 rounded-lg text-crate-text/50 hover:text-crate-text hover:bg-crate-accent
                           flex items-center justify-center transition-colors text-lg">×</button>
        </div>

        <form id="form-edit" action="" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Nama Paket <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="nama" id="edit-nama" required
                           class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                  text-sm font-body text-crate-text transition-all">
                </div>

                <div>
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Ikon (Emoji) <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="icon" id="edit-icon" maxlength="4" required
                           class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                  text-sm font-body text-crate-text transition-all text-2xl">
                </div>

                <div>
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Harga / Periode (Rp) <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-text/50 text-xs font-body">Rp</span>
                        <input type="number" name="harga" id="edit-harga" min="0" step="1000" required
                               class="w-full border border-crate-accent bg-white rounded-xl pl-9 pr-4 py-2.5
                                      text-sm font-body text-crate-text transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Jumlah Item per Box <span class="text-red-400">*</span>
                    </label>
                    <input type="number" name="items" id="edit-items" min="1" max="20" required
                           class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                  text-sm font-body text-crate-text transition-all">
                </div>

                <div>
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Label Badge
                        <span class="text-crate-text/50 font-normal normal-case tracking-normal">(opsional)</span>
                    </label>
                    <input type="text" name="badge" id="edit-badge"
                           class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                  text-sm font-body text-crate-text placeholder-crate-stone transition-all">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Deskripsi Singkat
                    </label>
                    <textarea name="deskripsi" id="edit-deskripsi" rows="2"
                              class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                     text-sm font-body text-crate-text transition-all resize-none"></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Fitur yang Didapat
                        <span class="text-crate-text/50 font-normal normal-case tracking-normal">(satu per baris)</span>
                    </label>
                    <textarea name="fitur" id="edit-fitur" rows="4"
                              class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                     text-sm font-body text-crate-text transition-all resize-none"></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-crate-text text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                        Fitur Tidak Tersedia
                        <span class="text-crate-text/50 font-normal normal-case tracking-normal">(satu per baris, opsional)</span>
                    </label>
                    <textarea name="tidak" id="edit-tidak" rows="2"
                              class="w-full border border-crate-accent bg-white rounded-xl px-4 py-2.5
                                     text-sm font-body text-crate-text transition-all resize-none"></textarea>
                </div>

                <div class="sm:col-span-2 flex flex-wrap gap-5">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="highlight" id="edit-highlight" value="1"
                               class="w-4 h-4 rounded border-crate-accent accent-crate-primary">
                        <span class="text-crate-text text-sm font-body">Tandai sebagai paket rekomendasi</span>
                    </label>
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="aktif" id="edit-aktif" value="1"
                               class="w-4 h-4 rounded border-crate-accent accent-crate-primary">
                        <span class="text-crate-text text-sm font-body">Aktif / tampil ke pelanggan</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-crate-accent">
                <button type="button" onclick="closeModal('modal-edit')"
                        class="px-5 py-2.5 border border-crate-accent text-crate-text/50 font-body font-semibold
                               text-sm rounded-xl hover:bg-crate-accent hover:text-crate-text transition-colors">
                    Batal
                </button>
                <button type="submit" class="btn-primary text-white font-body font-semibold px-6 py-2.5 rounded-xl text-sm shadow flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // ===== Modal Helpers =====
    function openModal(id) {
        const el = document.getElementById(id);
        el.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Tutup modal klik di luar
    ['modal-tambah', 'modal-edit'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) closeModal(id);
        });
    });

    // Tutup modal dengan Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal('modal-tambah');
            closeModal('modal-edit');
        }
    });

    // ===== Isi modal Edit dengan data paket =====
    function openModalEdit(paket) {
        document.getElementById('edit-nama').value      = paket.nama      ?? '';
        document.getElementById('edit-icon').value      = paket.icon      ?? '';
        document.getElementById('edit-harga').value     = paket.harga     ?? '';
        document.getElementById('edit-items').value     = paket.items     ?? '';
        document.getElementById('edit-badge').value     = paket.badge     ?? '';
        document.getElementById('edit-deskripsi').value = paket.deskripsi ?? '';
        document.getElementById('edit-fitur').value     = Array.isArray(paket.fitur)  ? paket.fitur.join('\n')  : '';
        document.getElementById('edit-tidak').value     = Array.isArray(paket.tidak)  ? paket.tidak.join('\n')  : '';
        document.getElementById('edit-highlight').checked = !!paket.highlight;
        document.getElementById('edit-aktif').checked     = !!paket.aktif;

        // Set form action sesuai ID paket
        document.getElementById('form-edit').action = '/admin/paket/' + paket.id;

        openModal('modal-edit');
    }
</script>
@endpush

@endsection