@extends('layouts.app')
@section('title', 'Langganan Berhasil!')

@section('content')
<div class="fade-in max-w-md mx-auto text-center py-12">

    <div class="text-6xl mb-4">🎉</div>

    <h1 class="font-display text-3xl text-crate-brown font-bold mb-2">
        Langganan Berhasil!
    </h1>
    <p class="text-crate-stone font-body text-sm mb-8">
        Yeay! Cratefit kamu sudah aktif dan siap dikirim.
    </p>

    <div class="card-wood rounded-2xl p-6 text-left mb-6">
        <h2 class="font-display text-base font-bold text-crate-brown mb-4">🧾 Ringkasan</h2>
        <div class="space-y-3 text-sm font-body">
            <div class="flex justify-between">
                <span class="text-crate-stone">Paket</span>
                <span class="text-crate-brown font-semibold">{{ session('paket_nama') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-crate-stone">Total</span>
                <span class="text-crate-orange font-bold font-display">
                    Rp {{ number_format(session('paket_harga'), 0, ',', '.') }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-crate-stone">Metode bayar</span>
                <span class="text-crate-brown font-semibold">
                    {{ ['transfer_bank'=>'Transfer Bank','ewallet'=>'E-Wallet','qris'=>'QRIS','cod'=>'COD'][session('metode_bayar')] }}
                </span>
            </div>
            <div class="border-t border-crate-sand pt-3 flex justify-between">
                <span class="text-crate-stone">Pengiriman pertama</span>
                <span class="text-crate-brown font-semibold">{{ session('pengiriman') }}</span>
            </div>
        </div>
    </div>

    <a href="{{ url('/') }}"
       class="btn-primary text-white font-body font-semibold px-8 py-3.5 rounded-2xl text-sm inline-block">
        Kembali ke Beranda →
    </a>

</div>
@endsection