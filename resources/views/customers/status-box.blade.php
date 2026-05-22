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
        <span class="text-blue-400 text-lg">ℹ️</span>
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
            <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold px-3 py-1.5 rounded-full font-body">
                ● Aktif
            </span>
        </div>
    </div>

    {{-- Detail Langganan --}}
    <div class="card-wood rounded-2xl p-6 mb-6">
        <h2 class="font-display text-base font-bold text-crate-brown mb-4">📋 Detail Langganan</h2>
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
        <h2 class="font-display text-base font-bold text-crate-brown mb-4">📍 Alamat Pengiriman</h2>
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
                  px-6 py-3 rounded-2xl text-sm hover:border-crate-amber transition-colors">
            📦 Ajukan Retur
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