@extends('layouts.kurator.app')
@section('title', 'Susun Isi Box — ' . ($pelanggan['nama'] ?? 'Pelanggan'))

@section('content')

@php
    $pelanggan = $pelanggan ?? [
        'id'             => 1,
        'nama'           => 'Aulia Ramadhani',
        'email'          => 'aulia@email.com',
        'paket'          => 'Starter Box',
        'periode'        => 'Juni 2025',
        'ukuran_atasan'  => 'M',
        'ukuran_bawahan' => 'M',
        'gaya'           => ['Casual', 'Minimalis'],
        'warna'          => ['Hitam', 'Putih', 'Krem'],
        'pantangan'      => ['Dress', 'Rok'],
        'catatan'        => 'Saya lebih suka warna earth tone dan netral. Hindari motif ramai.',
        'alamat'         => 'Jl. Pahlawan No. 12, Kel. Sudirman, Kec. Medan Baru, Kota Medan, Sumatera Utara 20152',
        'avatar'         => 'A',
        'status'         => 'menunggu',
        'label_status'   => 'Menunggu Kurasi',
    ];

    // Item-item yang sudah dipilih dari halaman sebelumnya
    // Di controller nyata, ambil dari session atau relasi DB
    $itemDipilih = $itemDipilih ?? [
        [
            'id'       => 1,
            'nama'     => 'Kemeja Flanel Kotak Vintage',
            'kategori' => 'Kemeja',
            'ukuran'   => 'M',
            'warna'    => 'Hitam/Merah',
            'kondisi'  => 'Sangat Baik',
            'harga'    => 45000,
            'foto'     => null,
            'tag'      => ['Casual', 'Vintage'],
            'cocok'    => true,
        ],
        [
            'id'       => 2,
            'nama'     => 'Kaos Oversize Polos Putih',
            'kategori' => 'Kaos',
            'ukuran'   => 'M',
            'warna'    => 'Putih',
            'kondisi'  => 'Baik',
            'harga'    => 30000,
            'foto'     => null,
            'tag'      => ['Casual', 'Minimalis'],
            'cocok'    => true,
        ],
        [
            'id'       => 3,
            'nama'     => 'Cardigan Rajut Krem',
            'kategori' => 'Cardigan',
            'ukuran'   => 'M',
            'warna'    => 'Krem',
            'kondisi'  => 'Sangat Baik',
            'harga'    => 60000,
            'foto'     => null,
            'tag'      => ['Minimalis', 'Casual'],
            'cocok'    => true,
        ],
    ];

    $totalHarga = array_sum(array_column($itemDipilih, 'harga'));

    $kondisiBadge = [
        'Sangat Baik' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'Baik'        => 'bg-blue-50 text-blue-700 border-blue-200',
        'Cukup'       => 'bg-amber-50 text-amber-700 border-amber-200',
    ];

    $maxItem = match($pelanggan['paket'] ?? '') {
        'Starter Box'  => 3,
        'Style Box'    => 5,
        'Premium Box'  => 7,
        default        => 3,
    };
@endphp

<div class="fade-in space-y-6">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm font-body text-crate-stone flex-wrap">
        <a href="{{ url('/kurator/pelanggan') }}" class="hover:text-crate-brown transition-colors">← Profil Pelanggan</a>
        <span>/</span>
        <a href="{{ url('/kurator/pelanggan/' . $pelanggan['id']) }}" class="hover:text-crate-brown transition-colors">{{ $pelanggan['nama'] }}</a>
        <span>/</span>
        <a href="{{ url('/kurator/pilih-item?pelanggan=' . $pelanggan['id']) }}" class="hover:text-crate-brown transition-colors">Pilih Item</a>
        <span>/</span>
        <span class="text-crate-brown font-medium">Susun Isi Box</span>
    </div>

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-cur-teal font-script text-lg mb-0.5">Kurasi Box</p>
            <h1 class="font-display text-3xl text-crate-brown font-bold">Susun Isi Box</h1>
            <p class="text-crate-stone font-body mt-1 text-sm">
                Atur urutan, tambahkan catatan, lalu konfirmasi box untuk
                <span class="font-semibold text-crate-brown">{{ $pelanggan['nama'] }}</span>
                · <span class="font-semibold text-crate-brown">{{ $pelanggan['periode'] }}</span>
            </p>
        </div>
        <a href="{{ url('/kurator/pilih-item?pelanggan=' . $pelanggan['id']) }}"
           class="border border-crate-sand bg-white text-crate-brown font-body font-semibold
                  px-5 py-2.5 rounded-xl text-sm hover:bg-crate-sand transition-colors text-center shrink-0">
            ← Ubah Pilihan Item
        </a>
    </div>

    {{-- MAIN LAYOUT --}}
    <div class="flex gap-6 items-start">

        {{-- ===== KIRI: SUSUN ITEM ===== --}}
        <div class="flex-1 min-w-0 space-y-4">

            {{-- Info ringkas --}}
            <div class="flex items-center gap-3 flex-wrap">
                <div class="flex items-center gap-2 bg-white border border-crate-sand rounded-xl px-4 py-2.5">
                    <span class="text-base">📦</span>
                    <span class="text-crate-brown font-semibold text-sm font-body">{{ $pelanggan['paket'] }}</span>
                </div>
                <div class="flex items-center gap-2 bg-white border border-crate-sand rounded-xl px-4 py-2.5">
                    <span class="text-base">🗓️</span>
                    <span class="text-crate-brown font-semibold text-sm font-body">{{ $pelanggan['periode'] }}</span>
                </div>
                <div class="flex items-center gap-2 bg-white border border-crate-sand rounded-xl px-4 py-2.5">
                    <span class="text-base">👕</span>
                    <span class="text-crate-brown font-semibold text-sm font-body">
                        {{ count($itemDipilih) }} / {{ $maxItem }} item
                    </span>
                </div>
            </div>

            {{-- DRAG & DROP LIST --}}
            <div class="card-wood rounded-2xl overflow-hidden">

                <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
                    <h2 class="font-display text-base text-crate-brown font-bold">📋 Daftar Item dalam Box</h2>
                    <p class="text-crate-stone text-xs font-body hidden sm:block">
                        Seret untuk mengubah urutan
                    </p>
                </div>

                <ul id="sortable-list" class="divide-y divide-crate-sand/60">
                    @foreach($itemDipilih as $i => $item)
                    <li class="sortable-item flex items-center gap-4 px-5 py-4 hover:bg-crate-cream/40 transition-colors"
                        data-id="{{ $item['id'] }}"
                        draggable="true">

                        {{-- Drag handle --}}
                        <div class="drag-handle cursor-grab active:cursor-grabbing shrink-0 text-crate-stone/40
                                    hover:text-crate-stone transition-colors select-none px-1">
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor">
                                <circle cx="5" cy="4"  r="2"/><circle cx="11" cy="4"  r="2"/>
                                <circle cx="5" cy="10" r="2"/><circle cx="11" cy="10" r="2"/>
                                <circle cx="5" cy="16" r="2"/><circle cx="11" cy="16" r="2"/>
                            </svg>
                        </div>

                        {{-- Nomor urut --}}
                        <div class="item-no w-7 h-7 rounded-full bg-crate-orange flex items-center justify-center
                                    text-white font-body font-bold text-xs shrink-0">
                            {{ $i + 1 }}
                        </div>

                        {{-- Foto / placeholder --}}
                        <div class="w-14 h-14 rounded-xl bg-crate-sand flex items-center justify-center shrink-0 overflow-hidden border border-crate-sand">
                            @if($item['foto'])
                                <img src="{{ asset('storage/' . $item['foto']) }}"
                                     alt="{{ $item['nama'] }}"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl opacity-30">👕</span>
                            @endif
                        </div>

                        {{-- Detail --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <p class="font-body font-semibold text-crate-brown text-sm">{{ $item['nama'] }}</p>
                                @if($item['cocok'])
                                <span class="bg-cur-teal-bg text-cur-teal text-xs font-body font-semibold
                                             px-2 py-0.5 rounded-full border border-cur-teal/25">✨ Cocok</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="bg-crate-sand text-crate-brown text-xs font-body px-2 py-0.5 rounded-full">
                                    {{ $item['kategori'] }}
                                </span>
                                <span class="bg-crate-sand text-crate-brown text-xs font-body px-2 py-0.5 rounded-full">
                                    Ukuran {{ $item['ukuran'] }}
                                </span>
                                <span class="bg-crate-sand text-crate-brown text-xs font-body px-2 py-0.5 rounded-full">
                                    {{ $item['warna'] }}
                                </span>
                                <span class="text-xs font-body font-semibold px-2 py-0.5 rounded-full border
                                             {{ $kondisiBadge[$item['kondisi']] ?? 'bg-crate-sand text-crate-stone border-crate-sand' }}">
                                    {{ $item['kondisi'] }}
                                </span>
                            </div>
                        </div>

                        {{-- Harga --}}
                        <div class="text-right shrink-0 hidden sm:block">
                            <p class="text-crate-orange font-display font-bold text-sm">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Hapus dari box --}}
                        <button type="button"
                                onclick="hapusItem(this, {{ $item['id'] }})"
                                title="Hapus dari box"
                                class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center
                                       text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </button>

                    </li>
                    @endforeach
                </ul>

                {{-- Tambah item lagi --}}
                <div class="px-5 py-4 border-t border-crate-sand">
                    <a href="{{ url('/kurator/pilih-item?pelanggan=' . $pelanggan['id']) }}"
                       class="flex items-center gap-2 text-sm font-body text-crate-stone hover:text-crate-brown transition-colors">
                        <span class="w-7 h-7 rounded-full border-2 border-dashed border-crate-stone/40
                                     flex items-center justify-center text-base leading-none">+</span>
                        Tambah / ubah item
                    </a>
                </div>

            </div>

            {{-- CATATAN KURATOR --}}
            <div class="card-wood rounded-2xl p-6">
                <h2 class="font-display text-base text-crate-brown font-bold mb-1">📝 Catatan Kurasi</h2>
                <p class="text-crate-stone text-xs font-body mb-4">
                    Catatan ini akan dilihat oleh pelanggan saat menerima box.
                </p>

                <textarea id="catatan-kurasi" name="catatan_kurasi" rows="4"
                          placeholder="Contoh: Hai Aulia! Kami pilihkan outfit casual-minimalis yang bisa kamu mix & match. Cardigan krem cocok dipadukan dengan kaos putih dan celana jeans biru. Semoga suka! 🎁"
                          class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body
                                 text-crate-brown bg-crate-cream placeholder-crate-stone resize-none
                                 transition-all leading-relaxed">{{ $catatanKurasi ?? '' }}</textarea>

                <div class="flex items-center justify-between mt-2">
                    <p class="text-crate-stone text-xs font-body">Tulis pesan personal untuk pelanggan.</p>
                    <span id="char-count" class="text-crate-stone text-xs font-body">0 / 500</span>
                </div>
            </div>

        </div>

        {{-- ===== KANAN: RINGKASAN & KONFIRMASI ===== --}}
        <aside class="hidden lg:block w-72 shrink-0 sticky top-24 space-y-4">

            {{-- Profil pelanggan mini --}}
            <div class="card-wood rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-cur-teal flex items-center justify-center
                                text-white font-display font-bold text-sm shrink-0">
                        {{ $pelanggan['avatar'] }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-body font-semibold text-crate-brown text-sm truncate">{{ $pelanggan['nama'] }}</p>
                        <p class="text-crate-stone text-xs font-body">{{ $pelanggan['email'] }}</p>
                    </div>
                </div>

                {{-- Catatan dari pelanggan --}}
                @if($pelanggan['catatan'])
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4">
                    <p class="text-xs font-body font-semibold text-amber-700 mb-1">📌 Catatan Pelanggan</p>
                    <p class="text-crate-brown text-xs font-body leading-relaxed line-clamp-4">
                        "{{ $pelanggan['catatan'] }}"
                    </p>
                </div>
                @endif

                {{-- Pantangan --}}
                @if(!empty($pelanggan['pantangan']))
                <div class="mb-4">
                    <p class="text-xs font-body font-semibold text-red-500/70 uppercase tracking-wider mb-2">🚫 Pantangan</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($pelanggan['pantangan'] as $pt)
                        <span class="bg-red-50 border border-red-200 text-red-600 text-xs font-body px-2.5 py-1 rounded-full">
                            {{ $pt }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Alamat --}}
                <div class="pt-4 border-t border-crate-sand">
                    <p class="text-xs font-body font-semibold text-crate-brown/60 uppercase tracking-wider mb-2">📍 Alamat</p>
                    <p class="text-crate-brown text-xs font-body leading-relaxed">{{ $pelanggan['alamat'] }}</p>
                </div>
            </div>

            {{-- Ringkasan Box --}}
            <div class="card-wood rounded-2xl p-5">
                <h3 class="font-display text-sm text-crate-brown font-bold mb-4">📦 Ringkasan Box</h3>

                <div class="space-y-2 mb-4">
                    @foreach($itemDipilih as $i => $item)
                    <div class="flex items-center gap-2" id="summary-item-{{ $item['id'] }}">
                        <span class="w-5 h-5 rounded-full bg-crate-orange text-white text-xs
                                     font-body font-bold flex items-center justify-center shrink-0">
                            {{ $i + 1 }}
                        </span>
                        <p class="text-crate-brown text-xs font-body flex-1 truncate">{{ $item['nama'] }}</p>
                        <p class="text-crate-orange text-xs font-body font-semibold shrink-0">
                            Rp {{ number_format($item['harga'], 0, ',', '.') }}
                        </p>
                    </div>
                    @endforeach
                </div>

                <div class="pt-3 border-t border-crate-sand space-y-1.5">
                    <div class="flex items-center justify-between text-xs font-body">
                        <span class="text-crate-stone">Total item</span>
                        <span id="summary-count" class="font-semibold text-crate-brown">
                            {{ count($itemDipilih) }} item
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs font-body">
                        <span class="text-crate-stone">Total nilai</span>
                        <span id="summary-total" class="font-bold text-crate-orange text-sm">
                            Rp {{ number_format($totalHarga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- FORM KONFIRMASI --}}
            <form id="form-konfirmasi"
                  action="{{ url('/kurator/susun-box/' . $pelanggan['id'] . '/konfirmasi') }}"
                  method="POST"
                  class="card-wood rounded-2xl p-5">
                @csrf

                {{-- Hidden: urutan item (diisi JS) --}}
                <input type="hidden" name="urutan_item" id="hidden-urutan">
                <input type="hidden" name="pelanggan_id" value="{{ $pelanggan['id'] }}">

                <h3 class="font-display text-sm text-crate-brown font-bold mb-4">✅ Konfirmasi Box</h3>

                {{-- Status box --}}
                <div class="mb-4">
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                        Ubah Status Box
                    </label>
                    <select name="status_box"
                            class="w-full border border-crate-sand bg-white rounded-xl px-3 py-2.5
                                   text-sm font-body text-crate-brown transition-all">
                        <option value="selesai" {{ ($statusBox ?? '') === 'selesai' ? 'selected' : '' }}>
                            ✅ Box Selesai Dikurasi
                        </option>
                        <option value="menunggu_pengiriman" {{ ($statusBox ?? '') === 'menunggu_pengiriman' ? 'selected' : '' }}>
                            📦 Menunggu Pengiriman
                        </option>
                        <option value="dikirim" {{ ($statusBox ?? '') === 'dikirim' ? 'selected' : '' }}>
                            🚚 Sudah Dikirim
                        </option>
                    </select>
                </div>

                {{-- Nomor resi (opsional) --}}
                <div class="mb-5">
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                        Nomor Resi <span class="normal-case font-normal text-crate-stone">(opsional)</span>
                    </label>
                    <input type="text" name="nomor_resi"
                           placeholder="Misal: JNE123456789"
                           value="{{ $nomorResi ?? '' }}"
                           class="w-full border border-crate-sand bg-white rounded-xl px-3 py-2.5
                                  text-sm font-body text-crate-brown placeholder-crate-stone transition-all">
                </div>

                {{-- Tombol simpan --}}
                <button type="submit" id="btn-konfirmasi"
                        class="btn-curator w-full text-white font-body font-semibold
                               px-5 py-3 rounded-xl text-sm shadow-md transition-all">
                    📦 Konfirmasi &amp; Simpan Box
                </button>

                <p class="text-center text-crate-stone text-xs font-body mt-3">
                    Box akan tercatat dan status pelanggan diperbarui.
                </p>
            </form>

        </aside>

    </div>

    {{-- MOBILE: TOMBOL KONFIRMASI --}}
    <div class="lg:hidden card-wood rounded-2xl p-5">
        <h3 class="font-display text-sm text-crate-brown font-bold mb-4">✅ Konfirmasi Box</h3>
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                    Status Box
                </label>
                <select name="status_box_mobile"
                        class="w-full border border-crate-sand bg-white rounded-xl px-3 py-2.5
                               text-sm font-body text-crate-brown transition-all">
                    <option value="selesai">✅ Box Selesai</option>
                    <option value="menunggu_pengiriman">📦 Menunggu Kirim</option>
                    <option value="dikirim">🚚 Sudah Dikirim</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                    Nomor Resi
                </label>
                <input type="text" name="nomor_resi_mobile"
                       placeholder="JNE123456789"
                       class="w-full border border-crate-sand bg-white rounded-xl px-3 py-2.5
                              text-sm font-body text-crate-brown placeholder-crate-stone transition-all">
            </div>
        </div>
        <button type="button"
                onclick="document.getElementById('form-konfirmasi').submit()"
                class="btn-curator w-full text-white font-body font-semibold px-5 py-3 rounded-xl text-sm shadow-md">
            📦 Konfirmasi &amp; Simpan Box
        </button>
    </div>

    

</div>

<style>
    .sortable-item {
        transition: background 0.15s, box-shadow 0.15s;
    }

    .sortable-item.dragging {
        opacity: 0.5;
        background: #FAF3E8;
    }

    .sortable-item.drag-over {
        background: rgba(200, 90, 26, 0.06);
        box-shadow: inset 0 2px 0 #C85A1A;
    }

    .drag-handle:active {
        cursor: grabbing;
    }
</style>

<script>
    // ===== DRAG & DROP URUTAN =====
    const list = document.getElementById('sortable-list');
    let dragSrc = null;

    list.querySelectorAll('.sortable-item').forEach(item => {
        item.addEventListener('dragstart', function (e) {
            dragSrc = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        item.addEventListener('dragend', function () {
            this.classList.remove('dragging');
            list.querySelectorAll('.sortable-item').forEach(i => i.classList.remove('drag-over'));
            updateNomor();
            updateHiddenUrutan();
        });

        item.addEventListener('dragover', function (e) {
            e.preventDefault();
            if (this !== dragSrc) {
                list.querySelectorAll('.sortable-item').forEach(i => i.classList.remove('drag-over'));
                this.classList.add('drag-over');
            }
        });

        item.addEventListener('drop', function (e) {
            e.preventDefault();
            if (this !== dragSrc) {
                const items = [...list.querySelectorAll('.sortable-item')];
                const srcIdx  = items.indexOf(dragSrc);
                const destIdx = items.indexOf(this);
                if (srcIdx < destIdx) {
                    list.insertBefore(dragSrc, this.nextSibling);
                } else {
                    list.insertBefore(dragSrc, this);
                }
            }
        });
    });

    function updateNomor() {
        list.querySelectorAll('.sortable-item').forEach((item, i) => {
            const badge = item.querySelector('.item-no');
            if (badge) badge.textContent = i + 1;
        });
    }

    function updateHiddenUrutan() {
        const ids = [...list.querySelectorAll('.sortable-item')].map(item => item.dataset.id);
        document.getElementById('hidden-urutan').value = ids.join(',');
    }

    // Init urutan awal
    updateHiddenUrutan();

    // ===== HAPUS ITEM DARI BOX =====
    function hapusItem(btn, itemId) {
        if (!confirm('Hapus item ini dari box?')) return;

        const li = btn.closest('.sortable-item');
        li.style.transition = 'opacity 0.25s, transform 0.25s';
        li.style.opacity    = '0';
        li.style.transform  = 'translateX(-16px)';
        setTimeout(() => {
            li.remove();
            updateNomor();
            updateHiddenUrutan();

            // Hapus dari ringkasan sidebar
            const summaryRow = document.getElementById('summary-item-' + itemId);
            if (summaryRow) summaryRow.remove();

            // Update count
            const remaining = list.querySelectorAll('.sortable-item').length;
            const summaryCount = document.getElementById('summary-count');
            if (summaryCount) summaryCount.textContent = remaining + ' item';
        }, 250);
    }

    // ===== CHAR COUNTER CATATAN =====
    const catatanEl = document.getElementById('catatan-kurasi');
    const charEl    = document.getElementById('char-count');
    const MAX_CHAR  = 500;

    catatanEl.addEventListener('input', function () {
        const len = this.value.length;
        charEl.textContent = `${len} / ${MAX_CHAR}`;
        if (len > MAX_CHAR) {
            this.value = this.value.substring(0, MAX_CHAR);
            charEl.textContent = `${MAX_CHAR} / ${MAX_CHAR}`;
        }
    });

    // ===== SUBMIT: sinkron catatan ke form utama =====
    document.getElementById('form-konfirmasi').addEventListener('submit', function (e) {
        // Sinkron catatan ke hidden input agar ikut terkirim
        const catatan = document.getElementById('catatan-kurasi').value;
        const internal = document.getElementById('catatan-internal').value;

        let inputCatatan = this.querySelector('[name="catatan_kurasi"]');
        if (!inputCatatan) {
            inputCatatan = document.createElement('input');
            inputCatatan.type = 'hidden';
            inputCatatan.name = 'catatan_kurasi';
            this.appendChild(inputCatatan);
        }
        inputCatatan.value = catatan;

        let inputInternal = this.querySelector('[name="catatan_internal"]');
        if (!inputInternal) {
            inputInternal = document.createElement('input');
            inputInternal.type = 'hidden';
            inputInternal.name = 'catatan_internal';
            this.appendChild(inputInternal);
        }
        inputInternal.value = internal;
    });
</script>

@endsection