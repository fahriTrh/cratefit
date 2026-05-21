@extends('layouts.app')
@section('title', 'Retur')

@section('content')
<div class="fade-in">

    {{-- PAGE HEADER --}}
    <div class="mb-8">
        <h1 class="font-display text-3xl text-crate-brown font-bold">Retur Pakaian</h1>
        <p class="text-crate-stone font-body mt-1 text-sm">Pilih item yang ingin dikembalikan dari box terakhirmu.</p>
    </div>

    {{-- INFO KEBIJAKAN RETUR --}}
    <div class="mb-6 p-4 bg-crate-amber/10 border border-crate-amber/30 rounded-2xl flex gap-3" style="animation-delay:0.05s">
        <span class="text-xl shrink-0">ℹ️</span>
        <div>
            <p class="text-crate-brown font-body font-semibold text-sm mb-1">Kebijakan Retur Cratefit</p>
            <ul class="text-crate-stone font-body text-xs space-y-1">
                <li>• Retur hanya bisa diajukan dalam <span class="text-crate-brown font-medium">3 hari</span> setelah box diterima.</li>
                <li>• Pakaian harus dalam kondisi <span class="text-crate-brown font-medium">belum dipakai</span> dan label masih terpasang.</li>
                <li>• Maksimal <span class="text-crate-brown font-medium">2 item</span> per periode (paket Style Box).</li>
                <li>• Biaya pengiriman retur ditanggung pelanggan.</li>
            </ul>
        </div>
    </div>

    <form action="#" method="POST">
        @csrf

        {{-- INFO BOX YANG DIRETUR --}}
        <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.1s">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <p class="text-crate-stone text-xs font-body font-medium uppercase tracking-wider mb-1">Box yang Diterima</p>
                    <p class="font-display font-bold text-crate-brown text-lg">Box #CF-20250101</p>
                    <p class="text-crate-stone text-xs font-body mt-0.5">Diterima: 15 Jan 2025 &nbsp;·&nbsp; Batas retur: <span class="text-red-500 font-medium">18 Jan 2025</span></p>
                </div>
                <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-xl px-4 py-2">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    <span class="text-green-700 font-body font-semibold text-xs">Masih dalam batas retur</span>
                </div>
            </div>
        </div>

        {{-- PILIH ITEM YANG DIRETUR --}}
        <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.15s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1">👕 Pilih Item yang Diretur</h2>
            <p class="text-crate-stone text-xs font-body mb-5">Centang item yang ingin kamu kembalikan (maks. 2 item)</p>

            <div class="space-y-3">
                @foreach([
                    ['id'=>1, 'nama'=>'Kemeja Flannel', 'kategori'=>'Kemeja', 'ukuran'=>'M', 'warna'=>'Merah Kotak-kotak'],
                    ['id'=>2, 'nama'=>'Kaos Oversized',  'kategori'=>'Kaos',   'ukuran'=>'L', 'warna'=>'Putih Polos'],
                    ['id'=>3, 'nama'=>'Celana Jeans',    'kategori'=>'Bawahan','ukuran'=>'30','warna'=>'Navy'],
                    ['id'=>4, 'nama'=>'Outer Corduroy',  'kategori'=>'Outer',  'ukuran'=>'M', 'warna'=>'Sage Green'],
                    ['id'=>5, 'nama'=>'Hoodie Basic',    'kategori'=>'Hoodie', 'ukuran'=>'L', 'warna'=>'Abu-abu'],
                ] as $item)
                    <label class="cursor-pointer block">
                        <input type="checkbox" name="item_retur[]" value="{{ $item['id'] }}" class="sr-only peer">
                        <div class="tag-btn flex items-center gap-4 border-2 border-crate-sand bg-crate-cream rounded-2xl p-4
                                    peer-checked:border-crate-orange peer-checked:bg-crate-orange/5
                                    hover:border-crate-amber transition-all">
                            {{-- Checkbox visual --}}
                            <div class="w-5 h-5 rounded-md border-2 border-crate-sand bg-white shrink-0 flex items-center justify-center
                                        peer-checked:bg-crate-orange peer-checked:border-crate-orange transition-all
                                        group-has-[input:checked]:bg-crate-orange">
                                <svg class="w-3 h-3 text-crate-orange hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            {{-- Foto placeholder --}}
                            <div class="w-14 h-14 bg-crate-sand rounded-xl flex items-center justify-center text-xl shrink-0">👕</div>
                            {{-- Info item --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-body font-semibold text-crate-brown text-sm">{{ $item['nama'] }}</p>
                                <p class="text-crate-stone text-xs font-body mt-0.5">
                                    {{ $item['kategori'] }} &nbsp;·&nbsp; Ukuran {{ $item['ukuran'] }} &nbsp;·&nbsp; {{ $item['warna'] }}
                                </p>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            {{-- Counter --}}
            <p class="text-crate-stone text-xs font-body mt-3">
                <span id="counter">0</span>/2 item dipilih
            </p>
        </div>

        {{-- ALASAN RETUR --}}
        <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.2s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1">📝 Alasan Retur</h2>
            <p class="text-crate-stone text-xs font-body mb-5">Pilih alasan utama pengembalian item</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
                @foreach([
                    ['value'=>'tidak_cocok_ukuran', 'label'=>'Tidak Cocok Ukuran', 'icon'=>'📏'],
                    ['value'=>'tidak_suka_style',   'label'=>'Tidak Suka Gaya',    'icon'=>'🎨'],
                    ['value'=>'kualitas_kurang',     'label'=>'Kualitas Kurang',    'icon'=>'🔍'],
                    ['value'=>'warna_tidak_sesuai',  'label'=>'Warna Tidak Sesuai', 'icon'=>'🎨'],
                    ['value'=>'kondisi_rusak',       'label'=>'Kondisi Rusak/Cacat','icon'=>'⚠️'],
                    ['value'=>'lainnya',             'label'=>'Lainnya',            'icon'=>'💬'],
                ] as $alasan)
                    <label class="cursor-pointer">
                        <input type="radio" name="alasan_retur" value="{{ $alasan['value'] }}" class="sr-only peer">
                        <div class="tag-btn border-2 border-crate-sand bg-crate-cream rounded-2xl p-3 text-center
                                    peer-checked:border-crate-orange peer-checked:bg-crate-orange/5
                                    hover:border-crate-amber transition-all">
                            <div class="text-xl mb-1">{{ $alasan['icon'] }}</div>
                            <p class="font-body font-semibold text-crate-brown text-xs leading-tight">{{ $alasan['label'] }}</p>
                        </div>
                    </label>
                @endforeach
            </div>

            {{-- Catatan tambahan --}}
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                    Catatan Tambahan (opsional)
                </label>
                <textarea name="catatan_retur" rows="3"
                          placeholder="cth: Ukuran M terlalu besar untuk saya, biasanya saya pakai S..."
                          class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                                 bg-crate-cream placeholder-crate-stone resize-none transition-all"></textarea>
            </div>
        </div>

        {{-- METODE PENGEMBALIAN --}}
        <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.25s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1">🚚 Metode Pengembalian</h2>
            <p class="text-crate-stone text-xs font-body mb-5">Pilih cara kamu mengirim item kembali</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach([
                    [
                        'value' => 'drop_off',
                        'label' => 'Drop Off ke Ekspedisi',
                        'icon'  => '📦',
                        'desc'  => 'Antar sendiri ke gerai JNE/SiCepat terdekat. Label retur akan dikirim via email.',
                    ],
                    [
                        'value' => 'pickup',
                        'label' => 'Dijemput Kurir',
                        'icon'  => '🏍️',
                        'desc'  => 'Kurir kami akan menjemput item di alamatmu. Tersedia di area tertentu.',
                    ],
                ] as $metode)
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pengembalian" value="{{ $metode['value'] }}" class="sr-only peer"
                               {{ $metode['value'] === 'drop_off' ? 'checked' : '' }}>
                        <div class="tag-btn h-full border-2 border-crate-sand bg-crate-cream rounded-2xl p-5
                                    peer-checked:border-crate-orange peer-checked:bg-crate-orange/5
                                    hover:border-crate-amber transition-all">
                            <div class="text-2xl mb-2">{{ $metode['icon'] }}</div>
                            <p class="font-body font-semibold text-crate-brown text-sm mb-1">{{ $metode['label'] }}</p>
                            <p class="font-body text-crate-stone text-xs leading-relaxed">{{ $metode['desc'] }}</p>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- RINGKASAN RETUR --}}
        <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.3s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-4">🧾 Ringkasan Pengajuan</h2>

            <div class="bg-crate-cream rounded-xl border border-crate-sand p-5 space-y-3">
                <div class="flex justify-between items-center text-sm font-body">
                    <span class="text-crate-stone">Box</span>
                    <span class="text-crate-brown font-semibold">#CF-20250101</span>
                </div>
                <div class="flex justify-between items-center text-sm font-body">
                    <span class="text-crate-stone">Item diretur</span>
                    <span class="text-crate-brown font-semibold" id="summary-item">0 item</span>
                </div>
                <div class="flex justify-between items-center text-sm font-body">
                    <span class="text-crate-stone">Metode</span>
                    <span class="text-crate-brown font-semibold" id="summary-metode">Drop Off ke Ekspedisi</span>
                </div>
                <div class="border-t border-crate-sand"></div>
                <div class="flex justify-between items-center text-sm font-body">
                    <span class="text-crate-stone">Biaya pengiriman retur</span>
                    <span class="text-crate-brown font-semibold">Ditanggung pelanggan</span>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-between pt-2 pb-8">
            <a href="{{ url('/status-box') }}"
               class="flex items-center gap-2 text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
                ← Kembali
            </a>
            <button type="submit"
                    class="btn-primary text-white font-body font-semibold px-8 py-3.5 rounded-2xl text-sm shadow-lg flex items-center gap-2">
                ↩️ Ajukan Retur
            </button>
        </div>

    </form>

    {{-- ===== RIWAYAT RETUR ===== --}}
    <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.35s">
        <h2 class="font-display text-lg text-crate-brown font-bold mb-4">📜 Riwayat Retur</h2>

        <div class="space-y-3">
            @foreach([
                [
                    'kode'    => 'RTR-20241205',
                    'box'     => 'CF-20241201',
                    'items'   => ['Kemeja Oxford', 'Celana Chino'],
                    'alasan'  => 'Tidak Cocok Ukuran',
                    'status'  => 'selesai',
                    'tanggal' => '05 Des 2024',
                ],
                [
                    'kode'    => 'RTR-20241105',
                    'box'     => 'CF-20241101',
                    'items'   => ['Kaos Stripe'],
                    'alasan'  => 'Tidak Suka Gaya',
                    'status'  => 'diproses',
                    'tanggal' => '05 Nov 2024',
                ],
            ] as $riwayat)
                @php
                    $rStatusMap = [
                        'diajukan' => ['label'=>'Diajukan',   'bg'=>'bg-yellow-100', 'text'=>'text-yellow-700'],
                        'diproses' => ['label'=>'Diproses',   'bg'=>'bg-blue-100',   'text'=>'text-blue-700'],
                        'selesai'  => ['label'=>'Selesai',    'bg'=>'bg-green-100',  'text'=>'text-green-700'],
                        'ditolak'  => ['label'=>'Ditolak',    'bg'=>'bg-red-100',    'text'=>'text-red-600'],
                    ];
                    $rs = $rStatusMap[$riwayat['status']] ?? $rStatusMap['diajukan'];
                @endphp
                <div class="bg-crate-cream border border-crate-sand rounded-2xl p-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                        <div>
                            <p class="font-body font-semibold text-crate-brown text-sm">{{ $riwayat['kode'] }}</p>
                            <p class="text-crate-stone text-xs font-body mt-0.5">
                                Box #{{ $riwayat['box'] }} &nbsp;·&nbsp; {{ $riwayat['tanggal'] }}
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-body font-semibold self-start sm:self-auto
                                     {{ $rs['bg'] }} {{ $rs['text'] }}">
                            {{ $rs['label'] }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($riwayat['items'] as $namaItem)
                            <span class="inline-flex items-center gap-1.5 bg-white border border-crate-sand rounded-lg px-3 py-1 text-xs font-body text-crate-brown">
                                👕 {{ $namaItem }}
                            </span>
                        @endforeach
                        <span class="inline-flex items-center bg-crate-sand/60 rounded-lg px-3 py-1 text-xs font-body text-crate-stone">
                            {{ $riwayat['alasan'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

<script>
    const checkboxes = document.querySelectorAll('input[name="item_retur[]"]');
    const counter    = document.getElementById('counter');
    const summaryItem = document.getElementById('summary-item');
    const maxItem    = 2;

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            const checked = [...checkboxes].filter(c => c.checked);

            // Batasi maksimal 2
            if (checked.length > maxItem) {
                this.checked = false;
                return;
            }

            const jumlah = [...checkboxes].filter(c => c.checked).length;
            counter.textContent  = jumlah;
            summaryItem.textContent = jumlah + ' item';
        });
    });

    // Update ringkasan metode
    document.querySelectorAll('input[name="metode_pengembalian"]').forEach(el => {
        el.addEventListener('change', function () {
            const map = {
                drop_off: 'Drop Off ke Ekspedisi',
                pickup:   'Dijemput Kurir',
            };
            document.getElementById('summary-metode').textContent = map[this.value] || '-';
        });
    });
</script>
@endsection