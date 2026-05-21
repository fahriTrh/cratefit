    @extends('layouts.app')
@section('title', 'Status Box')

@section('content')
<div class="fade-in">

    {{-- PAGE HEADER --}}
    <div class="mb-8">
        <h1 class="font-display text-3xl text-crate-brown font-bold">Status Box Kamu</h1>
        <p class="text-crate-stone font-body mt-1 text-sm">Pantau perjalanan box Cratefit kamu dari kurasi hingga tiba di tanganmu.</p>
    </div>

    {{-- INFO PAKET AKTIF --}}
    <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.05s">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-crate-orange/10 flex items-center justify-center text-2xl shrink-0">
                    ✨
                </div>
                <div>
                    <p class="text-crate-stone text-xs font-body font-medium uppercase tracking-wider">Paket Aktif</p>
                    <p class="font-display font-bold text-crate-brown text-xl">Style Box</p>
                    <p class="text-crate-stone text-xs font-body mt-0.5">
                        Periode: <span class="text-crate-brown font-medium">Bulanan</span>
                        &nbsp;·&nbsp;
                        Aktif sejak: <span class="text-crate-brown font-medium">01 Jan 2025</span>
                    </p>
                </div>
            </div>
            <div class="text-right shrink-0">
                <p class="text-crate-stone text-xs font-body">Pengiriman berikutnya</p>
                <p class="font-display font-bold text-crate-orange text-lg">01 Feb 2025</p>
            </div>
        </div>
    </div>

    {{-- DAFTAR BOX (dummy: status dalam_pengiriman) --}}
    <div class="card-wood rounded-2xl p-6 mb-5" style="animation-delay:0.1s">

        {{-- Header Box --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <p class="font-display font-bold text-crate-brown text-lg">Box #CF-20250101</p>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-body font-semibold bg-orange-100 text-orange-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                        Dalam Pengiriman
                    </span>
                </div>
                <p class="text-crate-stone text-xs font-body">Dibuat: 10 Jan 2025</p>
            </div>
            <div class="text-left sm:text-right">
                <p class="text-crate-stone text-xs font-body">Nomor Resi</p>
                <p class="font-body font-bold text-crate-brown text-sm tracking-widest">JNE1234567890</p>
                <p class="text-crate-stone text-xs font-body mt-0.5">JNE Regular</p>
            </div>
        </div>

        {{-- TIMELINE STATUS (dummy: active di step ke-3 "dalam_pengiriman") --}}
        @php
        $timeline = [
        ['label'=>'Order Diterima', 'icon'=>'📋', 'desc'=>'Pesananmu sudah masuk ke sistem kami', 'time'=>'10 Jan 2025, 09:00', 'state'=>'done'],
        ['label'=>'Sedang Dikurasi', 'icon'=>'👗', 'desc'=>'Kurator kami sedang memilihkan outfit terbaik', 'time'=>'11 Jan 2025, 13.22', 'state'=>'done'],
        ['label'=>'Box Siap Dikirim', 'icon'=>'📦', 'desc'=>'Box sudah dikemas dan siap dikirim', 'time'=>'12 Jan 2025, 10.05', 'state'=>'done'],
        ['label'=>'Dalam Pengiriman', 'icon'=>'🚚', 'desc'=>'Box sedang dalam perjalanan ke alamatmu', 'time'=>'13 Jan 2025, 08.30', 'state'=>'active'],
        ['label'=>'Box Tiba', 'icon'=>'🎉', 'desc'=>'Box sudah tiba di tujuan', 'time'=>null, 'state'=>'todo'],
        ];
        @endphp

        <div class="relative">
            <div class="absolute left-4 top-5 bottom-5 w-px bg-crate-sand hidden sm:block"></div>
            <div class="space-y-4">
                @foreach($timeline as $step)
                <div class="flex items-start gap-4 relative">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 z-10 text-sm
                                {{ $step['state'] === 'done'   ? 'step-done'   : '' }}
                                {{ $step['state'] === 'active' ? 'step-active' : '' }}
                                {{ $step['state'] === 'todo'   ? 'step-todo'   : '' }}">
                        {{ $step['state'] === 'done' ? '✓' : $step['icon'] }}
                    </div>
                    <div class="flex-1 pb-1">
                        <p class="font-body font-semibold text-sm
                                    {{ $step['state'] === 'active' ? 'text-crate-orange' : ($step['state'] === 'done' ? 'text-crate-brown' : 'text-crate-stone') }}">
                            {{ $step['label'] }}
                            @if($step['state'] === 'active')
                            <span class="ml-2 text-xs font-normal bg-crate-orange/10 text-crate-orange px-2 py-0.5 rounded-full">Sekarang</span>
                            @endif
                        </p>
                        @if($step['state'] !== 'todo')
                        <p class="text-crate-stone text-xs font-body mt-0.5">{{ $step['desc'] }}</p>
                        @if($step['time'])
                        <p class="text-crate-stone text-xs font-body mt-0.5 opacity-70">{{ $step['time'] }} WIB</p>
                        @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ISI BOX (dummy) --}}
        <div class="mt-5 border-t border-crate-sand pt-5">
            <p class="text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-3">Isi Box</p>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach([
                ['nama'=>'Kemeja Flannel', 'kategori'=>'Kemeja', 'ukuran'=>'M'],
                ['nama'=>'Kaos Oversized', 'kategori'=>'Kaos', 'ukuran'=>'L'],
                ['nama'=>'Celana Jeans', 'kategori'=>'Bawahan', 'ukuran'=>'30'],
                ['nama'=>'Outer Corduroy', 'kategori'=>'Outer', 'ukuran'=>'M'],
                ['nama'=>'Hoodie Basic', 'kategori'=>'Hoodie', 'ukuran'=>'L'],
                ] as $item)
                <div class="bg-crate-cream border border-crate-sand rounded-xl p-3 text-center">
                    <div class="w-full aspect-square bg-crate-sand rounded-lg mb-2 flex items-center justify-center text-2xl">👕</div>
                    <p class="font-body font-semibold text-crate-brown text-xs truncate">{{ $item['nama'] }}</p>
                    <p class="font-body text-crate-stone text-xs mt-0.5">{{ $item['kategori'] }} · {{ $item['ukuran'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- AKSI --}}
        <div class="mt-5 border-t border-crate-sand pt-4 flex flex-wrap gap-2">
            <a href="#"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-crate-sand bg-crate-cream
                          text-xs font-body font-medium text-crate-brown hover:border-crate-amber transition-all">
                🔍 Lacak Resi
            </a>
            <a href="#"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-crate-sand bg-crate-cream
                          text-xs font-body font-medium text-crate-stone hover:text-crate-brown hover:border-crate-amber transition-all">
                📄 Detail Box
            </a>
        </div>

    </div>

    {{-- RIWAYAT BOX LAMA (collapsed, dummy) --}}
    <div class="card-wood rounded-2xl p-6 mt-2" style="animation-delay:0.2s">
        <button onclick="toggleRiwayat()"
            class="w-full flex items-center justify-between text-left">
            <div>
                <h2 class="font-display text-lg text-crate-brown font-bold">📜 Riwayat Box</h2>
                <p class="text-crate-stone text-xs font-body mt-0.5">2 box selesai</p>
            </div>
            <span id="riwayat-icon" class="text-crate-stone text-xl transition-transform duration-200">▾</span>
        </button>

        <div id="riwayat-list" class="hidden mt-4 space-y-3">
            @foreach([
            ['kode'=>'CF-20241201', 'tanggal'=>'01 Des 2024', 'jumlah'=>5],
            ['kode'=>'CF-20241101', 'tanggal'=>'01 Nov 2024', 'jumlah'=>5],
            ] as $r)
            <div class="flex items-center justify-between bg-crate-cream border border-crate-sand rounded-xl px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full step-done flex items-center justify-center text-xs">✓</div>
                    <div>
                        <p class="font-body font-semibold text-crate-brown text-sm">Box #{{ $r['kode'] }}</p>
                        <p class="text-crate-stone text-xs font-body">{{ $r['tanggal'] }} &nbsp;·&nbsp; {{ $r['jumlah'] }} item</p>
                    </div>
                </div>
                <a href="#" class="text-xs font-body text-crate-stone hover:text-crate-orange transition-colors">Detail →</a>
            </div>
            @endforeach
        </div>
    </div>

</div>

<script>
    function toggleRiwayat() {
        const list = document.getElementById('riwayat-list');
        const icon = document.getElementById('riwayat-icon');
        const isHidden = list.classList.contains('hidden');
        list.classList.toggle('hidden', !isHidden);
        icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
    }
</script>
@endsection