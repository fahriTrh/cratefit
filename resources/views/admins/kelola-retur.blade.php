@extends('layouts.admin.app')
@section('title', 'Kelola Retur')

@section('content')

@php
    $returs = $returs ?? [
        [
            'id'      => 1,
            'kode'    => 'RTR-20250115-001',
            'pelanggan' => ['nama' => 'Aulia Ramadhani', 'email' => 'aulia@gmail.com', 'avatar' => 'A'],
            'box'     => 'CF-20250101',
            'items'   => ['Kemeja Flannel', 'Kaos Oversized'],
            'alasan'  => 'Tidak Cocok Ukuran',
            'catatan' => 'Ukuran M terlalu besar, biasanya pakai S.',
            'metode'  => 'drop_off',
            'status'  => 'diajukan',
            'tanggal' => '15 Jan 2025',
        ],
        [
            'id'      => 2,
            'kode'    => 'RTR-20241205-001',
            'pelanggan' => ['nama' => 'Bintang Pratama', 'email' => 'bintang@gmail.com', 'avatar' => 'B'],
            'box'     => 'CF-20241201',
            'items'   => ['Celana Jeans'],
            'alasan'  => 'Kondisi Rusak/Cacat',
            'catatan' => 'Ada sobekan kecil di bagian saku.',
            'metode'  => 'pickup',
            'status'  => 'diproses',
            'tanggal' => '05 Des 2024',
        ],
        [
            'id'      => 3,
            'kode'    => 'RTR-20241105-001',
            'pelanggan' => ['nama' => 'Citra Dewi', 'email' => 'citra@gmail.com', 'avatar' => 'C'],
            'box'     => 'CF-20241101',
            'items'   => ['Outer Corduroy', 'Hoodie Basic'],
            'alasan'  => 'Tidak Suka Gaya',
            'catatan' => null,
            'metode'  => 'drop_off',
            'status'  => 'selesai',
            'tanggal' => '05 Nov 2024',
        ],
        [
            'id'      => 4,
            'kode'    => 'RTR-20241010-001',
            'pelanggan' => ['nama' => 'Dafi Maulana', 'email' => 'dafi@gmail.com', 'avatar' => 'D'],
            'box'     => 'CF-20241001',
            'items'   => ['Kemeja Oxford'],
            'alasan'  => 'Kualitas Kurang',
            'catatan' => 'Jahitan di bagian kerah lepas.',
            'metode'  => 'pickup',
            'status'  => 'ditolak',
            'tanggal' => '10 Okt 2024',
        ],
        [
            'id'      => 5,
            'kode'    => 'RTR-20250110-001',
            'pelanggan' => ['nama' => 'Elisa Nuraini', 'email' => 'elisa@gmail.com', 'avatar' => 'E'],
            'box'     => 'CF-20250105',
            'items'   => ['Kaos Stripe'],
            'alasan'  => 'Warna Tidak Sesuai',
            'catatan' => null,
            'metode'  => 'drop_off',
            'status'  => 'diajukan',
            'tanggal' => '10 Jan 2025',
        ],
    ];

    $statusMap = [
        'diajukan' => ['label'=>'Diajukan', 'class'=>'badge-menunggu',  'dot'=>'bg-yellow-400'],
        'diproses' => ['label'=>'Diproses', 'class'=>'badge-diproses',  'dot'=>'bg-blue-400'],
        'selesai'  => ['label'=>'Selesai',  'class'=>'badge-selesai',   'dot'=>'bg-green-400'],
        'ditolak'  => ['label'=>'Ditolak',  'class'=>'bg-red-100 text-red-600 border border-red-200', 'dot'=>'bg-red-400'],
    ];

    $metodeMap = ['drop_off' => '📦 Drop Off', 'pickup' => '🏍️ Pickup'];

    $totalDiajukan = collect($returs)->where('status', 'diajukan')->count();
    $totalDiproses = collect($returs)->where('status', 'diproses')->count();
    $totalSelesai  = collect($returs)->where('status', 'selesai')->count();
    $totalDitolak  = collect($returs)->where('status', 'ditolak')->count();
@endphp

<div class="fade-in">

    {{-- HEADER --}}
    <div class="mb-6">
        <p class="text-crate-orange font-script text-lg mb-0.5">Panel Admin</p>
        <h1 class="font-display text-3xl text-crate-brown font-bold">↩️ Kelola Retur</h1>
        <p class="text-crate-stone font-body mt-1 text-sm">
            Tinjau dan proses pengajuan retur dari pelanggan.
        </p>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-2xl flex gap-3">
        <span class="text-lg">✅</span>
        <p class="text-green-800 font-body font-semibold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- STATS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        @foreach([
            ['label'=>'Diajukan',  'value'=>$totalDiajukan, 'icon'=>'📥', 'color'=>'text-yellow-700'],
            ['label'=>'Diproses',  'value'=>$totalDiproses, 'icon'=>'🔄', 'color'=>'text-blue-700'],
            ['label'=>'Selesai',   'value'=>$totalSelesai,  'icon'=>'✅', 'color'=>'text-green-700'],
            ['label'=>'Ditolak',   'value'=>$totalDitolak,  'icon'=>'❌', 'color'=>'text-red-600'],
        ] as $stat)
        <div class="card-wood rounded-2xl p-4">
            <span class="text-xl block mb-1">{{ $stat['icon'] }}</span>
            <p class="font-display text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            <p class="text-crate-stone text-xs font-body mt-0.5">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- FILTER --}}
    <div class="card-wood rounded-2xl p-4 mb-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-stone text-sm">🔍</span>
                <input type="text"
                       placeholder="Cari kode retur / nama pelanggan..."
                       class="pl-9 pr-4 py-2.5 rounded-xl border border-crate-sand bg-white
                              text-sm font-body text-crate-brown placeholder-crate-stone w-full transition-all"
                       oninput="filterRetur(this.value)">
            </div>
            <select class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all"
                    onchange="filterStatus(this.value)">
                <option value="">Semua Status</option>
                <option value="diajukan">Diajukan</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
            </select>
            <select class="border border-crate-sand bg-white rounded-xl px-3 py-2.5
                           text-sm font-body text-crate-brown transition-all">
                <option value="">Semua Metode</option>
                <option value="drop_off">Drop Off</option>
                <option value="pickup">Pickup</option>
            </select>
        </div>
    </div>

    {{-- TABEL RETUR --}}
    <div class="card-wood rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-crate-sand flex items-center justify-between">
            <h2 class="font-display text-base font-bold text-crate-brown">Daftar Pengajuan Retur</h2>
            <span class="text-crate-stone text-xs font-body" id="retur-count">{{ count($returs) }} pengajuan</span>
        </div>

        <div class="divide-y divide-crate-sand/60" id="retur-list">
            @forelse($returs as $r)
            @php $rs = $statusMap[$r['status']] ?? $statusMap['diajukan']; @endphp

            <div class="retur-row px-6 py-5 hover:bg-crate-cream/40 transition-colors"
                 data-status="{{ $r['status'] }}"
                 data-nama="{{ strtolower($r['pelanggan']['nama']) }}"
                 data-kode="{{ strtolower($r['kode']) }}">

                <div class="flex items-start gap-4">

                    {{-- Avatar --}}
                    <div class="w-10 h-10 rounded-full bg-crate-orange flex items-center justify-center
                                text-white font-display font-bold text-sm shrink-0 mt-0.5">
                        {{ $r['pelanggan']['avatar'] }}
                    </div>

                    {{-- Info utama --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap mb-0.5">
                                    <p class="font-body font-semibold text-crate-brown text-sm">{{ $r['kode'] }}</p>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full
                                                 text-xs font-body font-semibold {{ $rs['class'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $rs['dot'] }}"></span>
                                        {{ $rs['label'] }}
                                    </span>
                                </div>
                                <p class="text-crate-stone text-xs font-body">
                                    {{ $r['pelanggan']['nama'] }}
                                    <span class="text-crate-stone/60">·</span>
                                    {{ $r['pelanggan']['email'] }}
                                </p>
                            </div>
                            <div class="text-left sm:text-right shrink-0">
                                <p class="text-crate-stone text-xs font-body">Box #{{ $r['box'] }}</p>
                                <p class="text-crate-brown text-xs font-body font-medium">{{ $r['tanggal'] }}</p>
                            </div>
                        </div>

                        {{-- Item + Alasan + Metode --}}
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($r['items'] as $item)
                            <span class="inline-flex items-center gap-1 bg-white border border-crate-sand
                                         rounded-lg px-2.5 py-1 text-xs font-body text-crate-brown">
                                👕 {{ $item }}
                            </span>
                            @endforeach
                            <span class="inline-flex items-center bg-crate-sand/60 rounded-lg px-2.5 py-1
                                         text-xs font-body text-crate-stone">
                                {{ $r['alasan'] }}
                            </span>
                            <span class="inline-flex items-center bg-crate-cream border border-crate-sand/80
                                         rounded-lg px-2.5 py-1 text-xs font-body text-crate-brown">
                                {{ $metodeMap[$r['metode']] ?? $r['metode'] }}
                            </span>
                        </div>

                        {{-- Catatan pelanggan --}}
                        @if($r['catatan'])
                        <div class="bg-crate-cream border border-crate-sand rounded-xl px-4 py-2 mb-3">
                            <p class="text-crate-stone text-xs font-body">
                                <span class="font-semibold text-crate-brown">Catatan:</span>
                                {{ $r['catatan'] }}
                            </p>
                        </div>
                        @endif

                        {{-- ACTION BUTTONS --}}
                        @if($r['status'] === 'diajukan')
                        <div class="flex flex-wrap gap-2">
                            <form action="{{ url('/admin/retur/' . $r['id'] . '/proses') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl
                                               bg-blue-50 border border-blue-200 text-blue-700
                                               text-xs font-body font-semibold hover:bg-blue-100 transition-colors">
                                    🔄 Proses
                                </button>
                            </form>
                            <form action="{{ url('/admin/retur/' . $r['id'] . '/selesai') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl
                                               bg-green-50 border border-green-200 text-green-700
                                               text-xs font-body font-semibold hover:bg-green-100 transition-colors">
                                    ✅ Selesaikan
                                </button>
                            </form>
                            <button type="button"
                                    onclick="openTolakModal({{ $r['id'] }}, '{{ $r['kode'] }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl
                                           bg-red-50 border border-red-200 text-red-600
                                           text-xs font-body font-semibold hover:bg-red-100 transition-colors">
                                ❌ Tolak
                            </button>
                        </div>

                        @elseif($r['status'] === 'diproses')
                        <div class="flex flex-wrap gap-2">
                            <form action="{{ url('/admin/retur/' . $r['id'] . '/selesai') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl
                                               bg-green-50 border border-green-200 text-green-700
                                               text-xs font-body font-semibold hover:bg-green-100 transition-colors">
                                    ✅ Tandai Selesai
                                </button>
                            </form>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
            @empty
            <div class="px-6 py-16 text-center">
                <p class="text-4xl mb-3">📭</p>
                <p class="text-crate-brown font-display text-lg font-bold">Belum ada pengajuan retur</p>
                <p class="text-crate-stone text-sm font-body mt-1">Pengajuan dari pelanggan akan muncul di sini.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-crate-sand flex items-center justify-between">
            <p class="text-crate-stone text-xs font-body">Halaman 1 dari 1</p>
            <div class="flex gap-2">
                <button disabled
                        class="px-3 py-1.5 rounded-lg border border-crate-sand text-xs font-body
                               text-crate-stone disabled:opacity-40">
                    ← Sebelumnya
                </button>
                <button disabled
                        class="px-3 py-1.5 rounded-lg border border-crate-sand text-xs font-body
                               text-crate-stone disabled:opacity-40">
                    Berikutnya →
                </button>
            </div>
        </div>
    </div>

</div>

{{-- MODAL TOLAK --}}
<div id="modal-tolak"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     style="background:rgba(0,0,0,0.5);backdrop-filter:blur(4px)">
    <div class="card-wood rounded-2xl p-6 w-full max-w-md">
        <h3 class="font-display text-xl text-crate-brown font-bold mb-1">Tolak Pengajuan Retur</h3>
        <p class="text-crate-stone text-xs font-body mb-5" id="modal-kode-label">—</p>

        <form id="form-tolak" method="POST">
            @csrf
            @method('PATCH')

            <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                Alasan Penolakan <span class="text-red-500">*</span>
            </label>
            <textarea name="catatan_admin"
                      rows="3"
                      required
                      placeholder="cth: Pakaian terlihat sudah dipakai, label sudah lepas..."
                      class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body
                             text-crate-brown bg-crate-cream placeholder-crate-stone resize-none mb-5"></textarea>

            <div class="flex gap-3">
                <button type="button"
                        onclick="closeModal()"
                        class="flex-1 border border-crate-sand text-crate-brown font-body font-semibold
                               py-3 rounded-2xl text-sm hover:bg-crate-sand transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-red-500 text-white font-body font-semibold
                               py-3 rounded-2xl text-sm hover:bg-red-600 transition-colors">
                    ❌ Tolak Retur
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // ── Filter ─────────────────────────────────────────────
    const rows = document.querySelectorAll('.retur-row');

    function filterRetur(q) {
        q = q.toLowerCase();
        let vis = 0;
        rows.forEach(row => {
            const match = row.dataset.nama.includes(q) || row.dataset.kode.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) vis++;
        });
        document.getElementById('retur-count').textContent = vis + ' pengajuan';
    }

    function filterStatus(status) {
        let vis = 0;
        rows.forEach(row => {
            const match = !status || row.dataset.status === status;
            row.style.display = match ? '' : 'none';
            if (match) vis++;
        });
        document.getElementById('retur-count').textContent = vis + ' pengajuan';
    }

    // ── Modal Tolak ────────────────────────────────────────
    function openTolakModal(id, kode) {
        document.getElementById('modal-kode-label').textContent = 'Kode: ' + kode;
        document.getElementById('form-tolak').action = '/admin/retur/' + id + '/tolak';
        document.getElementById('modal-tolak').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal-tolak').classList.add('hidden');
    }

    // Tutup modal saat klik backdrop
    document.getElementById('modal-tolak').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>

@endsection