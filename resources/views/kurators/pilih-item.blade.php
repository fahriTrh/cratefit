@extends('layouts.kurator.app')
@section('title', 'Pilih Item — ' . ($pelanggan['nama'] ?? 'Pelanggan'))

@section('content')

{{-- Data dummy — ganti dengan $pelanggan & $items dari controller --}}
@php
    $pelanggan = $pelanggan ?? [
        'id'             => 1,
        'nama'           => 'Aulia Ramadhani',
        'paket'          => 'Starter Box',
        'periode'        => 'Juni 2025',
        'ukuran_atasan'  => 'M',
        'ukuran_bawahan' => 'M',
        'gaya'           => ['Casual', 'Minimalis'],
        'warna'          => ['Hitam', 'Putih', 'Krem'],
        'pantangan'      => ['Dress', 'Rok'],
        'avatar'         => 'A',
        'status'         => 'menunggu',
        'label_status'   => 'Menunggu Kurasi',
    ];

    $items = $items ?? [
        [
            'id'        => 1,
            'nama'      => 'Kemeja Flanel Kotak Vintage',
            'kategori'  => 'Kemeja',
            'ukuran'    => 'M',
            'warna'     => 'Hitam/Merah',
            'kondisi'   => 'Sangat Baik',
            'harga'     => 45000,
            'stok'      => 1,
            'foto'      => null,
            'tag'       => ['Casual', 'Vintage'],
            
        ],
        [
            'id'        => 2,
            'nama'      => 'Kaos Oversize Polos Putih',
            'kategori'  => 'Kaos',
            'ukuran'    => 'M',
            'warna'     => 'Putih',
            'kondisi'   => 'Baik',
            'harga'     => 30000,
            'stok'      => 1,
            'foto'      => null,
            'tag'       => ['Casual', 'Minimalis'],
            
        ],
        [
            'id'        => 3,
            'nama'      => 'Cardigan Rajut Krem',
            'kategori'  => 'Cardigan',
            'ukuran'    => 'M',
            'warna'     => 'Krem',
            'kondisi'   => 'Sangat Baik',
            'harga'     => 60000,
            'stok'      => 1,
            'foto'      => null,
            'tag'       => ['Minimalis', 'Casual'],
            
        ],
        [
            'id'        => 4,
            'nama'      => 'Celana Jeans Slim Biru',
            'kategori'  => 'Celana Jeans',
            'ukuran'    => 'M',
            'warna'     => 'Biru',
            'kondisi'   => 'Baik',
            'harga'     => 55000,
            'stok'      => 1,
            'foto'      => null,
            'tag'       => ['Casual'],
            
        ],
        [
            'id'        => 5,
            'nama'      => 'Jaket Bomber Hitam',
            'kategori'  => 'Jaket',
            'ukuran'    => 'L',
            'warna'     => 'Hitam',
            'kondisi'   => 'Baik',
            'harga'     => 75000,
            'stok'      => 1,
            'foto'      => null,
            'tag'       => ['Streetwear'],
            
        ],
        [
            'id'        => 6,
            'nama'      => 'Dress Floral Pendek',
            'kategori'  => 'Dress',
            'ukuran'    => 'S',
            'warna'     => 'Multicolor',
            'kondisi'   => 'Sangat Baik',
            'harga'     => 50000,
            'stok'      => 1,
            'foto'      => null,
            'tag'       => ['Feminine'],
            
        ],
        [
            'id'        => 7,
            'nama'      => 'Kemeja Linen Putih',
            'kategori'  => 'Kemeja',
            'ukuran'    => 'M',
            'warna'     => 'Putih',
            'kondisi'   => 'Sangat Baik',
            'harga'     => 48000,
            'stok'      => 1,
            'foto'      => null,
            'tag'       => ['Casual', 'Minimalis'],
            
        ],
        [
            'id'        => 8,
            'nama'      => 'Celana Kargo Olive',
            'kategori'  => 'Celana',
            'ukuran'    => 'M',
            'warna'     => 'Olive',
            'kondisi'   => 'Baik',
            'harga'     => 52000,
            'stok'      => 1,
            'foto'      => null,
            'tag'       => ['Streetwear', 'Casual'],
            
        ],
    ];

    $kondisiBadge = [
        'Sangat Baik' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'Baik'        => 'bg-blue-50 text-blue-700 border-blue-200',
        'Cukup'       => 'bg-amber-50 text-amber-700 border-amber-200',
    ];

    // Jumlah max item sesuai paket — sesuaikan dengan logika controller
    $maxItem = match($pelanggan['paket'] ?? '') {
        'Starter Box'  => 3,
        'Style Box'    => 5,
        'Premium Box'  => 7,
        default        => 3,
    };
@endphp

<div class="fade-in space-y-6">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm font-body text-crate-stone">
        <a href="{{ url('/kurator/pelanggan') }}" class="hover:text-crate-brown transition-colors">← Profil Pelanggan</a>
        <span>/</span>
        <a href="{{ url('/kurator/pelanggan/' . $pelanggan['id']) }}" class="hover:text-crate-brown transition-colors">
            {{ $pelanggan['nama'] }}
        </a>
        <span>/</span>
        <span class="text-crate-brown font-medium">Pilih Item</span>
    </div>

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-cur-teal font-script text-lg mb-0.5">Kurasi Box</p>
            <h1 class="font-display text-3xl text-crate-brown font-bold">Pilih Item</h1>
            <p class="text-crate-stone font-body mt-1 text-sm">
                Pilih item yang cocok untuk <span class="font-semibold text-crate-brown">{{ $pelanggan['nama'] }}</span>
                · Periode <span class="font-semibold text-crate-brown">{{ $pelanggan['periode'] }}</span>
            </p>
        </div>
        <a href="{{ url('/kurator/susun-box?pelanggan=' . $pelanggan['id']) }}"
           id="btn-lanjut"
           class="btn-curator text-white font-body font-semibold px-6 py-3 rounded-2xl text-sm shadow-lg
                  opacity-50 pointer-events-none transition-all text-center shrink-0">
            Lanjut Susun Box →
        </a>
    </div>

    {{-- 2-COL LAYOUT: SIDEBAR PREFERENSI + MAIN ITEM LIST --}}
    <div class="flex gap-6 items-start">

        {{-- ===== SIDEBAR PREFERENSI PELANGGAN ===== --}}
        <aside class="hidden lg:block w-64 shrink-0 sticky top-24 space-y-4">

            {{-- Info pelanggan --}}
            <div class="card-wood rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-cur-teal flex items-center justify-center
                                text-white font-display font-bold text-sm shrink-0">
                        {{ $pelanggan['avatar'] }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-body font-semibold text-crate-brown text-sm truncate">{{ $pelanggan['nama'] }}</p>
                        <p class="text-crate-stone text-xs font-body">{{ $pelanggan['paket'] }}</p>
                    </div>
                </div>

                {{-- Ukuran --}}
                <div class="flex gap-2 mb-4">
                    <div class="flex-1 bg-crate-cream rounded-xl p-3 text-center border border-crate-sand">
                        <p class="text-crate-stone text-xs font-body mb-0.5">Atasan</p>
                        <p class="font-display text-xl font-bold text-crate-orange">{{ $pelanggan['ukuran_atasan'] }}</p>
                    </div>
                    <div class="flex-1 bg-crate-cream rounded-xl p-3 text-center border border-crate-sand">
                        <p class="text-crate-stone text-xs font-body mb-0.5">Bawahan</p>
                        <p class="font-display text-xl font-bold text-crate-orange">{{ $pelanggan['ukuran_bawahan'] }}</p>
                    </div>
                </div>

                {{-- Gaya --}}
                <p class="text-xs font-body font-semibold text-crate-brown/60 uppercase tracking-wider mb-2">Gaya</p>
                <div class="flex flex-wrap gap-1.5 mb-4">
                    @foreach($pelanggan['gaya'] as $g)
                    <span class="bg-cur-teal-bg border border-cur-teal/25 text-cur-teal
                                 text-xs font-body font-semibold px-2.5 py-1 rounded-full">{{ $g }}</span>
                    @endforeach
                </div>

                {{-- Warna --}}
                <p class="text-xs font-body font-semibold text-crate-brown/60 uppercase tracking-wider mb-2">Warna Favorit</p>
                <p class="text-crate-brown text-xs font-body mb-4">{{ implode(', ', $pelanggan['warna']) }}</p>

                {{-- Pantangan --}}
                @if(!empty($pelanggan['pantangan']))
                <p class="text-xs font-body font-semibold text-red-500/70 uppercase tracking-wider mb-2">🚫 Pantangan</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($pelanggan['pantangan'] as $pt)
                    <span class="bg-red-50 border border-red-200 text-red-600 text-xs font-body px-2.5 py-1 rounded-full">
                        {{ $pt }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Keranjang item terpilih --}}
            <div class="card-wood rounded-2xl p-5" id="sidebar-keranjang">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-display text-sm text-crate-brown font-bold">🛒 Item Dipilih</h3>
                    <span id="badge-count"
                          class="bg-crate-orange text-white text-xs font-body font-bold
                                 w-6 h-6 rounded-full flex items-center justify-center">0</span>
                </div>
                <div id="list-terpilih" class="space-y-2 text-xs font-body text-crate-stone min-h-[60px]">
                    <p class="italic" id="empty-msg">Belum ada item dipilih.</p>
                </div>
                <div class="mt-3 pt-3 border-t border-crate-sand">
                    <div class="flex items-center justify-between text-xs font-body">
                        <span class="text-crate-stone">Batas paket:</span>
                        <span class="font-semibold text-crate-brown">
                            <span id="count-current">0</span> / {{ $maxItem }} item
                        </span>
                    </div>
                    <div class="mt-2 h-2 bg-crate-sand rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-crate-orange rounded-full transition-all duration-300"
                             style="width:0%"></div>
                    </div>
                </div>
            </div>

        </aside>

        {{-- ===== MAIN: DAFTAR ITEM ===== --}}
        <div class="flex-1 min-w-0">

            {{-- Filter & Search --}}
            <div class="card-wood rounded-2xl p-4 mb-4">
                <div class="flex flex-col sm:flex-row gap-3">

                    {{-- Search --}}
                    <div class="relative flex-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-stone text-sm">🔍</span>
                        <input type="text" id="input-search" placeholder="Cari nama item..."
                               class="pl-9 pr-4 py-2.5 rounded-xl border border-crate-sand bg-white text-sm font-body
                                      text-crate-brown placeholder-crate-stone w-full transition-all">
                    </div>

                    {{-- Filter Kategori --}}
                    <select id="filter-kategori"
                            class="border border-crate-sand bg-white rounded-xl px-3 py-2.5 text-sm font-body text-crate-brown transition-all">
                        <option value="">Semua Kategori</option>
                        @foreach(array_unique(array_column($items, 'kategori')) as $kat)
                        <option value="{{ $kat }}">{{ $kat }}</option>
                        @endforeach
                    </select>

                    {{-- Filter Ukuran --}}
                    <select id="filter-ukuran"
                            class="border border-crate-sand bg-white rounded-xl px-3 py-2.5 text-sm font-body text-crate-brown transition-all">
                        <option value="">Semua Ukuran</option>
                        @foreach(array_unique(array_column($items, 'ukuran')) as $uk)
                        <option value="{{ $uk }}">{{ $uk }}</option>
                        @endforeach
                    </select>

                    {{-- Toggle: hanya tampilkan yang cocok --}}
                    <label class="flex items-center gap-2 cursor-pointer shrink-0 px-3 py-2.5 rounded-xl border border-crate-sand bg-white">
                        <input type="checkbox" id="toggle-cocok" class="accent-crate-orange w-4 h-4 cursor-pointer">
                        <span class="text-sm font-body text-crate-brown whitespace-nowrap">✨ Cocok Saja</span>
                    </label>

                </div>
            </div>

            {{-- Keterangan jumlah --}}
            <div class="flex items-center justify-between mb-3 px-1">
                <p class="text-crate-stone text-xs font-body">
                    Menampilkan <span id="count-tampil" class="font-semibold text-crate-brown">{{ count($items) }}</span> item
                </p>
                <p class="text-crate-stone text-xs font-body">
                    ✨ = direkomendasikan sesuai preferensi
                </p>
            </div>

            {{-- GRID ITEM --}}
            <div id="grid-items" class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4">

                @foreach($items as $item)
                <div
                    class="item-card card-wood rounded-2xl overflow-hidden transition-all duration-200 hover:shadow-md cursor-pointer"
                    data-id="{{ $item['id'] }}"
                    data-nama="{{ $item['nama'] }}"
                    data-kategori="{{ $item['kategori'] }}"
                    data-ukuran="{{ $item['ukuran'] }}"
                    data-harga="{{ $item['harga'] }}"
                    
                    onclick="toggleItem(this)">

                    {{-- Foto / Placeholder --}}
                    <div class="relative bg-crate-sand aspect-[4/3] flex items-center justify-center">
                        @if($item['foto'])
                            <img src="{{ asset('storage/' . $item['foto']) }}"
                                 alt="{{ $item['nama'] }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl opacity-30">👕</span>
                        @endif

                        {{-- Checkbox overlay --}}
                        <div class="check-overlay absolute top-2 right-2 w-7 h-7 rounded-full border-2 border-white
                                    bg-white/80 flex items-center justify-center shadow transition-all duration-200">
                            <span class="check-icon text-base hidden">✓</span>
                        </div>
                    </div>

                    {{-- Info item --}}
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <p class="font-body font-semibold text-crate-brown text-sm leading-tight">{{ $item['nama'] }}</p>
                            <span class="shrink-0 text-crate-orange font-display font-bold text-sm">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex flex-wrap gap-1.5 mb-3">
                            <span class="bg-crate-sand text-crate-brown text-xs font-body px-2 py-0.5 rounded-full">
                                {{ $item['kategori'] }}
                            </span>
                            <span class="bg-crate-sand text-crate-brown text-xs font-body px-2 py-0.5 rounded-full">
                                {{ $item['ukuran'] }}
                            </span>
                            <span class="bg-crate-sand text-crate-brown text-xs font-body px-2 py-0.5 rounded-full">
                                {{ $item['warna'] }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs font-body font-semibold px-2 py-0.5 rounded-full border
                                         {{ $kondisiBadge[$item['kondisi']] ?? 'bg-crate-sand text-crate-stone border-crate-sand' }}">
                                {{ $item['kondisi'] }}
                            </span>
                            <div class="flex flex-wrap gap-1">
                                @foreach($item['tag'] as $tag)
                                <span class="text-xs font-body text-crate-stone">#{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach

            </div>

            {{-- Empty state (hidden by default) --}}
            <div id="empty-state" class="hidden text-center py-16">
                <p class="text-4xl mb-3">🔍</p>
                <p class="text-crate-brown font-display text-lg font-bold">Tidak ada item ditemukan</p>
                <p class="text-crate-stone text-sm font-body mt-1">Coba ubah filter atau kata kunci pencarian.</p>
            </div>

        </div>
    </div>

    {{-- FLOATING BOTTOM BAR (mobile) --}}
    <div id="float-bar"
         class="lg:hidden fixed bottom-16 left-4 right-4 z-40 bg-crate-brown text-crate-cream
                rounded-2xl px-5 py-4 shadow-xl flex items-center justify-between
                translate-y-4 opacity-0 pointer-events-none transition-all duration-300">
        <div>
            <p class="font-body text-xs text-crate-stone">Item dipilih</p>
            <p class="font-display font-bold text-crate-warm">
                <span id="float-count">0</span> / {{ $maxItem }} item
            </p>
        </div>
        <a href="{{ url('/kurator/susun-box?pelanggan=' . $pelanggan['id']) }}"
           id="float-btn-lanjut"
           class="btn-primary text-white font-body font-semibold px-5 py-2.5 rounded-xl text-sm
                  opacity-50 pointer-events-none">
            Susun Box →
        </a>
    </div>

    {{-- ACTION FOOTER --}}
    <div class="flex items-center justify-between pt-2 pb-6">
        <a href="{{ url('/kurator/pelanggan/' . $pelanggan['id']) }}"
           class="flex items-center gap-2 text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
            ← Kembali ke Profil
        </a>
        <a href="{{ url('/kurator/susun-box?pelanggan=' . $pelanggan['id']) }}"
           id="btn-lanjut-bottom"
           class="btn-curator text-white font-body font-semibold px-7 py-3 rounded-2xl text-sm shadow-lg
                  opacity-50 pointer-events-none transition-all">
            📦 Lanjut Susun Box →
        </a>
    </div>

</div>

<style>
    /* Badge status kurator (sesuaikan dengan kurator layout) */
    .item-card.selected {
        outline: 2px solid #C85A1A;
        outline-offset: 2px;
    }

    .item-card.selected .check-overlay {
        background: #C85A1A;
        border-color: #C85A1A;
    }

    .item-card.selected .check-icon {
        display: inline !important;
        color: white;
    }

    .item-card.over-limit {
        opacity: 0.45;
        pointer-events: none;
    }

    .item-card[data-cocok="0"] {
        opacity: 0.75;
    }
</style>

<script>
    const MAX_ITEM = {{ $maxItem }};
    let selected = {}; // { id: { nama, harga } }

    function toggleItem(card) {
        const id    = card.dataset.id;
        const nama  = card.dataset.nama;
        const harga = parseInt(card.dataset.harga);

        if (selected[id]) {
            // Deselect
            delete selected[id];
            card.classList.remove('selected');
        } else {
            // Cek limit
            if (Object.keys(selected).length >= MAX_ITEM) {
                alert(`Paket ini hanya boleh memuat maksimal ${MAX_ITEM} item.`);
                return;
            }
            selected[id] = { nama, harga };
            card.classList.add('selected');
        }

        updateUI();
    }

    function updateUI() {
        const count = Object.keys(selected).length;

        // Badge & progress
        document.getElementById('badge-count').textContent     = count;
        document.getElementById('count-current').textContent   = count;
        document.getElementById('float-count').textContent     = count;
        document.getElementById('progress-bar').style.width    = `${(count / MAX_ITEM) * 100}%`;

        // List sidebar
        const listEl   = document.getElementById('list-terpilih');
        const emptyMsg = document.getElementById('empty-msg');

        if (count === 0) {
            listEl.innerHTML = '<p class="italic text-xs text-crate-stone" id="empty-msg">Belum ada item dipilih.</p>';
        } else {
            listEl.innerHTML = Object.entries(selected).map(([id, data]) =>
                `<div class="flex items-center justify-between gap-2 py-1 border-b border-crate-sand/50">
                    <span class="text-crate-brown font-semibold truncate" style="max-width:130px">${data.nama}</span>
                    <span class="text-crate-orange shrink-0">Rp ${data.harga.toLocaleString('id-ID')}</span>
                </div>`
            ).join('');
        }

        // Tombol lanjut
        const canProceed = count > 0;
        ['btn-lanjut', 'btn-lanjut-bottom', 'float-btn-lanjut'].forEach(btnId => {
            const btn = document.getElementById(btnId);
            if (!btn) return;
            if (canProceed) {
                btn.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                btn.classList.add('opacity-50', 'pointer-events-none');
            }
        });

        // Float bar (mobile)
        const floatBar = document.getElementById('float-bar');
        if (count > 0) {
            floatBar.classList.remove('translate-y-4', 'opacity-0', 'pointer-events-none');
        } else {
            floatBar.classList.add('translate-y-4', 'opacity-0', 'pointer-events-none');
        }

        // Dim cards yang belum dipilih jika sudah penuh
        document.querySelectorAll('.item-card').forEach(card => {
            const id = card.dataset.id;
            if (count >= MAX_ITEM && !selected[id]) {
                card.classList.add('over-limit');
            } else {
                card.classList.remove('over-limit');
            }
        });
    }

    // Filter & Search
    function applyFilter() {
        const search      = document.getElementById('input-search').value.toLowerCase();
        const filterKat   = document.getElementById('filter-kategori').value;
        const filterUk    = document.getElementById('filter-ukuran').value;
        const onlyCocok   = document.getElementById('toggle-cocok').checked;

        let visible = 0;
        document.querySelectorAll('.item-card').forEach(card => {
            const nama    = card.dataset.nama.toLowerCase();
            const kat     = card.dataset.kategori;
            const uk      = card.dataset.ukuran;
            const cocok   = card.dataset.cocok === '1';

            const matchSearch = nama.includes(search);
            const matchKat    = !filterKat || kat === filterKat;
            const matchUk     = !filterUk  || uk === filterUk;
            const matchCocok  = !onlyCocok  || cocok;

            const show = matchSearch && matchKat && matchUk && matchCocok;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        document.getElementById('count-tampil').textContent = visible;
        document.getElementById('empty-state').classList.toggle('hidden', visible > 0);
        document.getElementById('grid-items').classList.toggle('hidden', visible === 0);
    }

    document.getElementById('input-search').addEventListener('input', applyFilter);
    document.getElementById('filter-kategori').addEventListener('change', applyFilter);
    document.getElementById('filter-ukuran').addEventListener('change', applyFilter);
    document.getElementById('toggle-cocok').addEventListener('change', applyFilter);
</script>

@endsection