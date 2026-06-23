@extends('layouts.App')
@section('title', 'Retur')

@section('content')

@php
    $box = $box ?? [
        'kode'           => 'CF-20250101',
        'tanggal_terima' => '15 Jan 2025',
        'batas_retur'    => '18 Jan 2025',
        'masih_bisa'     => true,
        'items'          => [
            ['id'=>1, 'nama'=>'Kemeja Flannel',  'kategori'=>'Kemeja',  'ukuran'=>'M',  'warna'=>'Merah Kotak-kotak'],
            ['id'=>2, 'nama'=>'Kaos Oversized',  'kategori'=>'Kaos',    'ukuran'=>'L',  'warna'=>'Putih Polos'],
            ['id'=>3, 'nama'=>'Celana Jeans',    'kategori'=>'Bawahan', 'ukuran'=>'30', 'warna'=>'Navy'],
            ['id'=>4, 'nama'=>'Outer Corduroy',  'kategori'=>'Outer',   'ukuran'=>'M',  'warna'=>'Sage Green'],
            ['id'=>5, 'nama'=>'Hoodie Basic',    'kategori'=>'Hoodie',  'ukuran'=>'L',  'warna'=>'Abu-abu'],
        ],
    ];

    $riwayat = $riwayat ?? [
        [
            'kode'    => 'RTR-20241205',
            'box'     => 'CF-20241201',
            'items'   => ['Kemeja Oxford', 'Celana Chino'],
            'alasan'  => 'Tidak Cocok Ukuran',
            'metode'  => 'Drop Off ke Ekspedisi',
            'status'  => 'selesai',
            'tanggal' => '05 Des 2024',
        ],
        [
            'kode'    => 'RTR-20241105',
            'box'     => 'CF-20241101',
            'items'   => ['Kaos Stripe'],
            'alasan'  => 'Tidak Suka Gaya',
            'metode'  => 'Dijemput Kurir',
            'status'  => 'diproses',
            'tanggal' => '05 Nov 2024',
        ],
        [
            'kode'    => 'RTR-20241010',
            'box'     => 'CF-20241001',
            'items'   => ['Rok Mini'],
            'alasan'  => 'Kondisi Rusak/Cacat',
            'metode'  => 'Drop Off ke Ekspedisi',
            'status'  => 'ditolak',
            'tanggal' => '10 Okt 2024',
        ],
    ];

    $statusMap = [
        'diajukan' => ['label'=>'Diajukan', 'bg'=>'bg-yellow-100', 'text'=>'text-yellow-700', 'dot'=>'bg-yellow-400'],
        'diproses' => ['label'=>'Diproses', 'bg'=>'bg-blue-100',   'text'=>'text-blue-700',   'dot'=>'bg-blue-400'],
        'selesai'  => ['label'=>'Selesai',  'bg'=>'bg-green-100',  'text'=>'text-green-700',  'dot'=>'bg-green-400'],
        'ditolak'  => ['label'=>'Ditolak',  'bg'=>'bg-red-100',    'text'=>'text-red-600',    'dot'=>'bg-red-400'],
    ];
@endphp

<div class="fade-in">

    {{-- PAGE HEADER --}}
    <div class="mb-8">
        <h1 class="font-display text-3xl text-crate-text font-bold flex items-center gap-2">
            <i data-lucide="undo-2" class="w-7 h-7 text-crate-primary"></i> Retur Pakaian
        </h1>
        <p class="text-gray-500 font-body mt-1 text-sm">Pilih item yang ingin dikembalikan dari box terakhirmu.</p>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl flex gap-3">
        <i data-lucide="check-circle" class="w-5 h-5 shrink-0 text-green-600"></i>
        <div>
            <p class="text-green-800 font-body font-semibold text-sm">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl flex gap-3">
        <i data-lucide="x-circle" class="w-5 h-5 shrink-0 text-red-600"></i>
        <div>
            <p class="text-red-700 font-body font-semibold text-sm">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    {{-- INFO KEBIJAKAN RETUR --}}
    <div class="mb-6 p-4 bg-crate-primary/10 border border-crate-primary/30 rounded-2xl flex gap-3">
        <i data-lucide="info" class="w-5 h-5 shrink-0 text-crate-primary"></i>
        <div>
            <p class="text-crate-text font-body font-semibold text-sm mb-1">Kebijakan Retur Cratefit</p>
            <ul class="text-gray-500 font-body text-xs space-y-1">
                <li>• Retur hanya bisa diajukan dalam <span class="text-crate-text font-medium">3 hari</span> setelah box diterima.</li>
                <li>• Pakaian harus dalam kondisi <span class="text-crate-text font-medium">belum dipakai</span> dan label masih terpasang.</li>
                <li>• Maksimal <span class="text-crate-text font-medium">2 item</span> per periode pengiriman.</li>
                <li>• Biaya pengiriman retur ditanggung pelanggan.</li>
            </ul>
        </div>
    </div>

    {{-- ─── FORM RETUR ─────────────────────────────────────────── --}}
    @if($box['masih_bisa'])

    <form action="{{ url('/retur') }}" method="POST" id="form-retur">
        @csrf
        <input type="hidden" name="box_id" value="{{ $box['id'] }}">

        {{-- INFO BOX --}}
        <div class="card-wood rounded-2xl p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <p class="text-gray-500 text-xs font-body font-medium uppercase tracking-wider mb-1">Box yang Diterima</p>
                    <p class="font-display font-bold text-crate-text text-lg">Box #{{ $box['kode'] }}</p>
                    <p class="text-gray-500 text-xs font-body mt-0.5">
                        Diterima: {{ $box['tanggal_terima'] }}
                        &nbsp;·&nbsp;
                        Batas retur: <span class="text-red-500 font-medium">{{ $box['batas_retur'] }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-xl px-4 py-2 self-start sm:self-auto">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span class="text-green-700 font-body font-semibold text-xs">Masih dalam batas retur</span>
                </div>
            </div>
        </div>

        {{-- PILIH ITEM --}}
        <div class="card-wood rounded-2xl p-6 mb-6">
            <h2 class="font-display text-lg text-crate-text font-bold mb-1 flex items-center gap-2">
                <i data-lucide="shirt" class="w-5 h-5 text-crate-primary"></i> Pilih Item yang Diretur
            </h2>
            <p class="text-gray-500 text-xs font-body mb-5">Centang item yang ingin dikembalikan (maks. 2 item)</p>

            @error('item_retur')
            <p class="text-red-500 text-xs font-body mb-3 flex items-center gap-1.5"><i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i> {{ $message }}</p>
            @enderror

            <div class="space-y-3" id="item-list">
                @foreach($box['items'] as $item)
                <label class="cursor-pointer block item-label">
                    <input type="checkbox"
                           name="item_retur[]"
                           value="{{ $item['id'] }}"
                           data-nama="{{ $item['nama'] }}"
                           class="sr-only peer item-checkbox"
                           {{ in_array($item['id'], old('item_retur', [])) ? 'checked' : '' }}>
                    <div class="flex items-center gap-4 border-2 border-crate-accent bg-white rounded-2xl p-4
                                peer-checked:border-crate-primary peer-checked:bg-crate-primary/5
                                hover:border-crate-primary transition-all select-none">

                        {{-- Checkbox visual --}}
                        <div class="check-box w-5 h-5 rounded-md border-2 border-crate-accent bg-white shrink-0
                                    flex items-center justify-center transition-all">
                            <svg class="check-icon w-3 h-3 text-white hidden" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>

                        {{-- Foto placeholder --}}
                        <div class="w-14 h-14 bg-crate-accent rounded-xl flex items-center justify-center shrink-0">
                            <i data-lucide="shirt" class="w-6 h-6 text-crate-text/40"></i>
                        </div>

                        {{-- Info item --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-body font-semibold text-crate-text text-sm">{{ $item['nama'] }}</p>
                            <p class="text-gray-500 text-xs font-body mt-0.5">
                                {{ $item['kategori'] }} &nbsp;·&nbsp;
                                Ukuran {{ $item['ukuran'] }} &nbsp;·&nbsp;
                                {{ $item['warna'] }}
                            </p>
                        </div>

                    </div>
                </label>
                @endforeach
            </div>

            <div class="flex items-center justify-between mt-4">
                <p class="text-gray-500 text-xs font-body">
                    <span id="counter" class="text-crate-text font-bold text-base">0</span>/2 item dipilih
                </p>
                <div class="h-1.5 w-32 bg-crate-accent rounded-full overflow-hidden">
                    <div id="progress-bar" class="h-full bg-crate-primary rounded-full transition-all duration-300" style="width:0%"></div>
                </div>
            </div>
        </div>

        {{-- ALASAN RETUR --}}
        <div class="card-wood rounded-2xl p-6 mb-6">
            <h2 class="font-display text-lg text-crate-text font-bold mb-1 flex items-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5 text-crate-primary"></i> Alasan Retur
            </h2>
            <p class="text-gray-500 text-xs font-body mb-5">Pilih alasan utama pengembalian item</p>

            @error('alasan_retur')
            <p class="text-red-500 text-xs font-body mb-3">⚠️ {{ $message }}</p>
            @enderror

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-5">
                @foreach([
                    ['value'=>'tidak_cocok_ukuran', 'label'=>'Tidak Cocok Ukuran',  'icon'=>'ruler'],
                    ['value'=>'tidak_suka_style',   'label'=>'Tidak Suka Gaya',      'icon'=>'palette'],
                    ['value'=>'kualitas_kurang',     'label'=>'Kualitas Kurang',      'icon'=>'search'],
                    ['value'=>'warna_tidak_sesuai',  'label'=>'Warna Tidak Sesuai',   'icon'=>'palette'],
                    ['value'=>'kondisi_rusak',       'label'=>'Kondisi Rusak/Cacat',  'icon'=>'alert-triangle'],
                    ['value'=>'lainnya',             'label'=>'Lainnya',              'icon'=>'message-circle'],
                ] as $alasan)
                <label class="cursor-pointer">
                    <input type="radio"
                           name="alasan_retur"
                           value="{{ $alasan['value'] }}"
                           class="sr-only peer alasan-radio"
                           {{ old('alasan_retur') === $alasan['value'] ? 'checked' : '' }}>
                    <div class="tag-btn border-2 border-crate-accent bg-white rounded-2xl p-3 text-center
                                peer-checked:border-crate-primary peer-checked:bg-crate-primary/5
                                hover:border-crate-primary transition-all">
                        <div class="mb-1 flex justify-center">
                            <i data-lucide="{{ $alasan['icon'] }}" class="w-5 h-5 text-crate-primary"></i>
                        </div>
                        <p class="font-body font-semibold text-crate-text text-xs leading-tight">{{ $alasan['label'] }}</p>
                    </div>
                </label>
                @endforeach
            </div>

            <div>
                <label class="block text-xs font-body font-semibold text-crate-text/70 uppercase tracking-wider mb-1.5">
                    Catatan Tambahan <span class="normal-case font-normal text-gray-400">(opsional)</span>
                </label>
                <textarea name="catatan_retur"
                          rows="3"
                          placeholder="cth: Ukuran M terlalu besar untuk saya, biasanya saya pakai S..."
                          class="w-full border border-crate-accent rounded-xl px-4 py-3 text-sm font-body text-crate-text
                                 bg-white placeholder-gray-400 resize-none transition-all">{{ old('catatan_retur') }}</textarea>
            </div>
        </div>

        {{-- METODE PENGEMBALIAN --}}
        <div class="card-wood rounded-2xl p-6 mb-6">
            <h2 class="font-display text-lg text-crate-text font-bold mb-1 flex items-center gap-2">
                <i data-lucide="truck" class="w-5 h-5 text-crate-primary"></i> Metode Pengembalian
            </h2>
            <p class="text-gray-500 text-xs font-body mb-5">Pilih cara kamu mengirim item kembali</p>

            @error('metode_pengembalian')
            <p class="text-red-500 text-xs font-body mb-3">⚠️ {{ $message }}</p>
            @enderror

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach([
                    [
                        'value' => 'drop_off',
                        'label' => 'Drop Off ke Ekspedisi',
                        'icon'  => 'package',
                        'desc'  => 'Antar sendiri ke gerai JNE/SiCepat terdekat. Label retur akan dikirim via email.',
                        'badge' => null,
                    ],
                    [
                        'value' => 'pickup',
                        'label' => 'Dijemput Kurir',
                        'icon'  => 'truck',
                        'desc'  => 'Kurir kami akan menjemput item di alamatmu. Tersedia di area tertentu.',
                        'badge' => 'Area terbatas',
                    ],
                ] as $metode)
                <label class="cursor-pointer">
                    <input type="radio"
                           name="metode_pengembalian"
                           value="{{ $metode['value'] }}"
                           class="sr-only peer metode-radio"
                           {{ (old('metode_pengembalian', 'drop_off') === $metode['value']) ? 'checked' : '' }}>
                    <div class="tag-btn h-full border-2 border-crate-accent bg-white rounded-2xl p-5
                                peer-checked:border-crate-primary peer-checked:bg-crate-primary/5
                                hover:border-crate-primary transition-all">
                        <div class="flex items-start justify-between mb-3">
                            <div><i data-lucide="{{ $metode['icon'] }}" class="w-6 h-6 text-crate-primary"></i></div>
                            @if($metode['badge'])
                            <span class="text-xs font-body text-gray-500 bg-crate-accent px-2 py-0.5 rounded-full">
                                {{ $metode['badge'] }}
                            </span>
                            @endif
                        </div>
                        <p class="font-body font-semibold text-crate-text text-sm mb-1">{{ $metode['label'] }}</p>
                        <p class="font-body text-gray-500 text-xs leading-relaxed">{{ $metode['desc'] }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        {{-- RINGKASAN --}}
        <div class="card-wood rounded-2xl p-6 mb-6">
            <h2 class="font-display text-lg text-crate-text font-bold mb-4 flex items-center gap-2">
                <i data-lucide="receipt" class="w-5 h-5 text-crate-primary"></i> Ringkasan Pengajuan
            </h2>

            <div class="bg-crate-bg rounded-xl border border-crate-accent p-5 space-y-3">
                <div class="flex justify-between items-center text-sm font-body">
                    <span class="text-gray-500">Box</span>
                    <span class="text-crate-text font-semibold">#{{ $box['kode'] }}</span>
                </div>
                <div class="flex justify-between items-start text-sm font-body gap-4">
                    <span class="text-gray-500 shrink-0">Item diretur</span>
                    <span class="text-crate-text font-semibold text-right" id="summary-items">
                        <em class="text-gray-400 font-normal">Belum dipilih</em>
                    </span>
                </div>
                <div class="flex justify-between items-center text-sm font-body">
                    <span class="text-gray-500">Metode</span>
                    <span class="text-crate-text font-semibold" id="summary-metode">Drop Off ke Ekspedisi</span>
                </div>
                <div class="border-t border-crate-accent pt-3 flex justify-between items-center text-sm font-body">
                    <span class="text-gray-500">Biaya pengiriman retur</span>
                    <span class="text-crate-text font-semibold">Ditanggung pelanggan</span>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-between pt-2 pb-8">
            <a href="{{ url('/status-box') }}"
            class="flex items-center gap-2 text-gray-500 font-body text-sm hover:text-crate-text transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
            <button type="submit" id="btn-submit"
                    class="btn-primary text-white font-body font-semibold px-8 py-3.5 rounded-2xl text-sm
                        shadow-lg flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed
                        disabled:transform-none disabled:shadow-none">
                <i data-lucide="undo-2" class="w-4 h-4"></i> Ajukan Retur
            </button>
        </div>

    </form>

    @else
    {{-- ─── TIDAK BISA RETUR (batas habis) ─── --}}
    <div class="card-wood rounded-2xl p-8 mb-6 text-center">
        <div class="mb-4 flex justify-center">
            <i data-lucide="clock-alert" class="w-12 h-12 text-crate-primary"></i>
        </div>
        <h2 class="font-display text-xl text-crate-text font-bold mb-2">Batas Retur Sudah Lewat</h2>
        <p class="text-gray-500 font-body text-sm max-w-sm mx-auto">
            Kamu hanya bisa mengajukan retur dalam 3 hari setelah box diterima.
            Batas retur untuk Box #{{ $box['kode'] }} sudah berakhir pada {{ $box['batas_retur'] }}.
        </p>
        <a href="{{ url('/status-box') }}"
        class="inline-flex items-center gap-2 mt-6 btn-primary text-white font-body font-semibold
                px-6 py-3 rounded-2xl text-sm shadow-lg">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Status Box
        </a>
    </div>
    @endif

    {{-- ─── RIWAYAT RETUR ────────────────────────────────────────── --}}
    <div class="card-wood rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-display text-lg text-crate-text font-bold flex items-center gap-2">
                <i data-lucide="scroll-text" class="w-5 h-5 text-crate-primary"></i> Riwayat Retur
            </h2>
            <span class="text-gray-500 text-xs font-body">{{ count($riwayat) }} pengajuan</span>
        </div>

        @if(count($riwayat) > 0)
        <div class="space-y-3">
            @foreach($riwayat as $r)
            @php
                $rs = $statusMap[$r['status']] ?? $statusMap['diajukan'];
            @endphp
            <div class="bg-crate-bg border border-crate-accent rounded-2xl p-4 hover:border-crate-primary/40 transition-colors">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 mb-3">
                    <div>
                        <div class="flex items-center gap-2 flex-wrap mb-0.5">
                            <p class="font-body font-semibold text-crate-text text-sm">{{ $r['kode'] }}</p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs
                                         font-body font-semibold {{ $rs['bg'] }} {{ $rs['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $rs['dot'] }}"></span>
                                {{ $rs['label'] }}
                            </span>
                        </div>
                        <p class="text-gray-500 text-xs font-body">
                            Box #{{ $r['box'] }} &nbsp;·&nbsp; {{ $r['tanggal'] }}
                        </p>
                    </div>
                    <div class="shrink-0 text-right">
                        <p class="text-gray-500 text-xs font-body">{{ $r['metode'] }}</p>
                    </div>
                </div>

                {{-- Item + Alasan --}}
                <div class="flex flex-wrap gap-2">
                    @foreach($r['items'] as $namaItem)
                    <span class="inline-flex items-center gap-1.5 bg-white border border-crate-accent
                                rounded-lg px-3 py-1 text-xs font-body text-crate-text">
                        <i data-lucide="shirt" class="w-3.5 h-3.5"></i> {{ $namaItem }}
                    </span>
                    @endforeach
                    <span class="inline-flex items-center bg-crate-accent rounded-lg px-3 py-1
                                 text-xs font-body text-gray-500">
                        {{ $r['alasan'] }}
                    </span>
                </div>

                {{-- Catatan admin jika ditolak --}}
                @if($r['status'] === 'ditolak' && isset($r['catatan_admin']))
                <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded-xl">
                    <p class="text-red-600 text-xs font-body">
                        <span class="font-semibold">Alasan penolakan:</span> {{ $r['catatan_admin'] }}
                    </p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-10">
            <div class="mb-2 flex justify-center">
                <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
            </div>
            <p class="text-gray-500 font-body text-sm">Belum ada riwayat retur.</p>
        </div>
        @endif
    </div>

</div>

{{-- ─── JAVASCRIPT ─────────────────────────────────────────────── --}}
<script>
    const checkboxes  = document.querySelectorAll('.item-checkbox');
    const counter     = document.getElementById('counter');
    const progressBar = document.getElementById('progress-bar');
    const summaryItems= document.getElementById('summary-items');
    const btnSubmit   = document.getElementById('btn-submit');
    const MAX         = 2;

    function updateCheckboxStyle(cb) {
        const box  = cb.closest('label').querySelector('.check-box');
        const icon = cb.closest('label').querySelector('.check-icon');
        if (cb.checked) {
            box.classList.add('bg-crate-primary', 'border-crate-primary');
            box.classList.remove('border-crate-accent');
            icon.classList.remove('hidden');
        } else {
            box.classList.remove('bg-crate-primary', 'border-crate-primary');
            box.classList.add('border-crate-accent');
            icon.classList.add('hidden');
        }
    }

    function updateSummary() {
        const checked = [...checkboxes].filter(c => c.checked);
        const jumlah  = checked.length;

        // Counter & progress
        counter.textContent      = jumlah;
        progressBar.style.width  = (jumlah / MAX * 100) + '%';

        // Summary items
        if (jumlah === 0) {
            summaryItems.innerHTML = '<em class="text-gray-400 font-normal">Belum dipilih</em>';
        } else {
            summaryItems.textContent = checked.map(c => c.dataset.nama).join(', ');
        }
    }

    checkboxes.forEach(cb => {
        // Set initial state (jika ada old input)
        updateCheckboxStyle(cb);

        cb.addEventListener('change', function () {
            const checked = [...checkboxes].filter(c => c.checked);
            if (checked.length > MAX) {
                this.checked = false;
                return;
            }
            updateCheckboxStyle(this);
            updateSummary();
        });
    });

    // Update ringkasan metode
    document.querySelectorAll('.metode-radio').forEach(el => {
        el.addEventListener('change', function () {
            const map = {
                drop_off: 'Drop Off ke Ekspedisi',
                pickup:   'Dijemput Kurir',
            };
            document.getElementById('summary-metode').textContent = map[this.value] || '-';
        });
    });

    // Init summary
    updateSummary();

    // Konfirmasi sebelum submit
    const form = document.getElementById('form-retur');
    if (form) {
        form.addEventListener('submit', function (e) {
            const checked = [...checkboxes].filter(c => c.checked).length;
            const alasan  = document.querySelector('.alasan-radio:checked');

            if (checked === 0) {
                e.preventDefault();
                alert('⚠️ Pilih minimal 1 item yang ingin diretur.');
                return;
            }
            if (!alasan) {
                e.preventDefault();
                alert('⚠️ Pilih alasan retur terlebih dahulu.');
                return;
            }

            const ok = confirm(`Ajukan retur untuk ${checked} item dari Box #{{ $box['kode'] }}?`);
            if (!ok) e.preventDefault();
        });
    }
</script>

@endsection