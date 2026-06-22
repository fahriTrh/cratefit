@extends('layouts.app')
@section('title', 'Status Langgananku')

@section('content')
<div class="fade-in">

    <div class="mb-8">
        <p class="text-crate-orange font-script text-lg mb-1">Langganan Aktif</p>
        <h1 class="font-display text-3xl text-crate-brown font-bold">Status Langgananku</h1>
        <p class="text-crate-stone font-body mt-1 text-sm">Informasi paket dan pengiriman box kamu.</p>
    </div>

    @if(session('info'))
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-center gap-3">
        <i data-lucide="info" class="w-5 h-5 text-blue-400"></i>
        <p class="text-blue-700 text-sm font-body">{{ session('info') }}</p>
    </div>
    @endif

    {{-- Status Badge --}}
    <div class="card-wood rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="text-4xl">{{ $langganan->paket->icon }}</div>
                <div>
                    <p class="font-display font-bold text-crate-brown text-xl">{{ $langganan->paket->nama }}</p>
                    <p class="text-crate-stone text-sm font-body">{{ $langganan->paket->jumlah_item }} item per box</p>
                </div>
            </div>
            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold px-3 py-1.5 rounded-full font-body inline-flex items-center gap-1.5">
                <i data-lucide="circle" class="w-2.5 h-2.5 fill-emerald-500 text-emerald-500"></i> Aktif
            </span>
        </div>
    </div>

    {{-- Status Box Aktif --}}
    @if($box)
    <div class="card-wood rounded-2xl p-6 mb-6">
        <h2 class="font-display text-base font-bold text-crate-brown mb-4 flex items-center gap-2">
            <i data-lucide="package" class="w-5 h-5 text-crate-orange"></i> Status Box
        </h2>

        {{-- Progress Status --}}
        @php
        $statusStep = [
        'menunggu_kurasi' => 1,
        'sedang_dikurasi' => 2,
        'siap_dikirim' => 3,
        'dalam_pengiriman' => 4,
        'tiba' => 5,
        'selesai' => 5,
        ];
        $statusLabel = [
        'menunggu_kurasi' => 'Menunggu Kurasi',
        'sedang_dikurasi' => 'Sedang Dikurasi',
        'siap_dikirim' => 'Siap Dikirim',
        'dalam_pengiriman' => 'Dalam Pengiriman',
        'tiba' => 'Sudah Tiba',
        'selesai' => 'Selesai',
        ];
        $currentStep = $statusStep[$box->status] ?? 1;
        $steps = [
        1 => ['label' => 'Menunggu', 'icon' => 'clock'],
        2 => ['label' => 'Dikurasi', 'icon' => 'scissors'],
        3 => ['label' => 'Siap Kirim','icon' => 'package'],
        4 => ['label' => 'Dikirim', 'icon' => 'truck'],
        5 => ['label' => 'Diterima', 'icon' => 'check'],
        ];
        @endphp

        {{-- Stepper --}}
        <div class="flex items-center justify-between mb-6">
            @foreach($steps as $step => $info)
            <div class="flex flex-col items-center flex-1">
                <div class="w-9 h-9 rounded-full flex items-center justify-center mb-1
                        {{ $currentStep >= $step
                            ? 'bg-crate-orange text-white'
                            : 'bg-crate-sand text-crate-stone' }}">
                    <i data-lucide="{{ $info['icon'] }}" class="w-4 h-4"></i>
                </div>
                <p class="text-xs font-body text-center
                       {{ $currentStep >= $step ? 'text-crate-brown font-semibold' : 'text-crate-stone' }}">
                    {{ $info['label'] }}
                </p>
            </div>
            @if($step < 5)
                <div class="h-0.5 flex-1 mx-1 {{ $currentStep > $step ? 'bg-crate-orange' : 'bg-crate-sand' }}">
        </div>
        @endif
        @endforeach
    </div>

    {{-- Kode Box & Status --}}
    <div class="bg-crate-cream rounded-xl p-4 mb-4 flex items-center justify-between flex-wrap gap-2">
        <div>
            <p class="text-xs text-crate-stone font-body">Kode Box</p>
            <p class="font-display font-bold text-crate-brown text-lg">{{ $box->kode_box }}</p>
        </div>
        <span class="text-xs font-semibold font-body px-3 py-1.5 rounded-full border
                     {{ $box->status === 'selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' :
                        ($box->status === 'dalam_pengiriman' || $box->status === 'tiba' ? 'bg-blue-50 text-blue-700 border-blue-200' :
                        'bg-amber-50 text-amber-700 border-amber-200') }}">
            {{ $statusLabel[$box->status] ?? $box->status }}
        </span>
    </div>

    {{-- Resi (kalau ada) --}}
    @if($box->nomor_resi)
    <div class="flex items-center justify-between text-sm font-body mb-4">
        <span class="text-crate-stone">Nomor Resi</span>
        <span class="font-semibold text-crate-brown">{{ $box->nomor_resi }}</span>
    </div>
    @endif

    {{-- Isi Box --}}
    @if($box->items->count() > 0)
    <div class="mb-4">
        <p class="text-xs font-body font-semibold text-crate-brown/60 uppercase tracking-wider mb-2">Isi Box</p>
        <div class="space-y-2">
            @foreach($box->items as $boxItem)
            <div class="flex items-center gap-3 bg-white rounded-xl px-4 py-3 border border-crate-sand">
                <i data-lucide="shirt" class="w-6 h-6 text-crate-orange"></i>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-body font-semibold text-crate-brown truncate">
                        {{ $boxItem->item->nama }}
                    </p>
                    <p class="text-xs text-crate-stone font-body">
                        {{ $boxItem->item->jenis }} · {{ $boxItem->item->ukuran }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Tombol Konfirmasi Diterima --}}
    @if(in_array($box->status, ['dalam_pengiriman', 'tiba']))
    <form action="{{ route('status-box.konfirmasi') }}" method="POST"
        onsubmit="return confirm('Konfirmasi box sudah kamu terima?')">
        @csrf
        <button type="submit"
            class="w-full bg-crate-orange text-white font-body font-semibold
                    px-6 py-3 rounded-2xl text-sm hover:bg-crate-brown transition-colors flex items-center justify-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4"></i> Konfirmasi Box Sudah Diterima
        </button>
    </form>
    @endif
</div>
@else
<div class="card-wood rounded-2xl p-6 mb-6 text-center">
    <div class="mb-3 flex justify-center">
        <i data-lucide="clock" class="w-10 h-10 text-crate-orange"></i>
    </div>
    <p class="font-display font-bold text-crate-brown">Box Sedang Disiapkan</p>
    <p class="text-crate-stone text-sm font-body mt-1">Kurator sedang memilihkan item terbaik untukmu.</p>
</div>
@endif

{{-- Detail Langganan --}}
<div class="card-wood rounded-2xl p-6 mb-6">
    <h2 class="font-display text-base font-bold text-crate-brown mb-4 flex items-center gap-2">
        <i data-lucide="clipboard-list" class="w-5 h-5 text-crate-orange"></i> Detail Langganan
    </h2>
    <div class="space-y-3 text-sm font-body">
        <div class="flex justify-between items-center">
            <span class="text-crate-stone">Harga per periode</span>
            <span class="font-display font-bold text-crate-orange text-base">
                Rp {{ number_format($langganan->paket->harga, 0, ',', '.') }}
            </span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-crate-stone">Periode pengiriman</span>
            <span class="text-crate-brown font-semibold">
                {{ ['bulanan' => 'Setiap bulan', '2bulan' => 'Setiap 2 bulan', '3bulan' => 'Setiap 3 bulan'][$langganan->periode] }}
            </span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-crate-stone">Metode bayar</span>
            <span class="text-crate-brown font-semibold">
                {{ ['transfer_bank' => 'Transfer Bank', 'ewallet' => 'E-Wallet', 'qris' => 'QRIS', 'cod' => 'COD'][$langganan->metode_bayar] }}
            </span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-crate-stone">Mulai langganan</span>
            <span class="text-crate-brown font-semibold">
                {{ $langganan->tanggal_mulai->translatedFormat('d F Y') }}
            </span>
        </div>
        <div class="border-t border-crate-sand pt-3 flex justify-between items-center">
            <span class="text-crate-stone">Pengiriman berikutnya</span>
            <span class="text-crate-brown font-bold">
                {{ $langganan->tanggal_pengiriman_berikutnya?->translatedFormat('d F Y') ?? '-' }}
            </span>
        </div>
    </div>
</div>

{{-- Alamat Pengiriman --}}
<div class="card-wood rounded-2xl p-6 mb-6">
    <h2 class="font-display text-base font-bold text-crate-brown mb-4 flex items-center gap-2">
        <i data-lucide="map-pin" class="w-5 h-5 text-crate-orange"></i> Alamat Pengiriman
    </h2>
    <p class="text-crate-brown font-semibold text-sm font-body">{{ $langganan->alamat->nama_penerima }}</p>
    <p class="text-crate-stone text-sm font-body mt-1 leading-relaxed">
        {{ $langganan->alamat->alamat_lengkap }},
        {{ $langganan->alamat->kelurahan }},
        {{ $langganan->alamat->kecamatan }},
        {{ $langganan->alamat->kota }},
        {{ $langganan->alamat->provinsi }}
        {{ $langganan->alamat->kode_pos }}
    </p>
    @if($langganan->alamat->catatan_kurir)
    <p class="text-crate-stone text-xs font-body mt-2 italic">
        Catatan: {{ $langganan->alamat->catatan_kurir }}
    </p>
    @endif
</div>

{{-- Aksi --}}
<div class="flex flex-col sm:flex-row gap-3 pb-8">
    <a href="{{ url('/retur') }}"
        class="flex-1 text-center border-2 border-crate-sand text-crate-brown font-body font-semibold
                px-6 py-3 rounded-2xl text-sm hover:border-crate-amber transition-colors flex items-center justify-center gap-2">
        <i data-lucide="package" class="w-4 h-4"></i> Ajukan Retur
    </a>
    <form action="{{ url('/langganan/batalkan') }}" method="POST"
        onsubmit="return confirm('Yakin ingin membatalkan langganan?')">
        @csrf
        <button type="submit"
            class="w-full text-center border-2 border-red-200 text-red-500 font-body font-semibold
                           px-6 py-3 rounded-2xl text-sm hover:bg-red-50 transition-colors">
            Batalkan Langganan
        </button>
    </form>
</div>

</div>
@endsection