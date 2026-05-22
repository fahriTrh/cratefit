@extends('layouts.app')
@section('title', 'Pilih Paket Langganan')

@section('content')
<div class="fade-in">

    {{-- PAGE HEADER --}}
    <div class="mb-8">
        <p class="text-crate-orange font-script text-lg mb-1">Langkah 4 dari 4</p>
        <h1 class="font-display text-3xl text-crate-brown font-bold">Pilih Paket Langgananmu</h1>
        <p class="text-crate-stone font-body mt-1 text-sm">Satu langkah lagi — pilih paket yang paling cocok untuk kamu!</p>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
        <span class="text-green-500 text-lg">✅</span>
        <p class="text-green-700 text-sm font-body">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
        <span class="text-red-400 text-lg">⚠️</span>
        <p class="text-red-600 text-sm font-body">{{ session('error') }}</p>
    </div>
    @endif

    <form action="{{ route('langganan.store') }}" method="POST">
        @csrf

        {{-- ===== PERIODE LANGGANAN ===== --}}
        <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.05s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1">🗓️ Periode Pengiriman</h2>
            <p class="text-crate-stone text-xs font-body mb-5">Seberapa sering kamu ingin menerima box?</p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @php
                $periodes = [
                [
                'value' => 'bulanan',
                'label' => 'Bulanan',
                'icon' => '📦',
                'desc' => '1 box setiap bulan',
                'badge' => null,
                ],
                [
                'value' => '2bulan',
                'label' => '2 Bulan Sekali',
                'icon' => '🎁',
                'desc' => '1 box setiap 2 bulan',
                'badge' => 'Paling Populer',
                ],
                [
                'value' => '3bulan',
                'label' => '3 Bulan Sekali',
                'icon' => '🌟',
                'desc' => '1 box setiap 3 bulan',
                'badge' => null,
                ],
                ];
                @endphp

                @foreach($periodes as $p)
                <label class="cursor-pointer relative">
                    <input type="radio" name="periode" value="{{ $p['value'] }}" class="sr-only peer"
                        {{ old('periode', 'bulanan') === $p['value'] ? 'checked' : '' }}>
                    @if($p['badge'])
                    <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 z-10 bg-crate-orange text-white text-xs font-body font-semibold px-3 py-0.5 rounded-full whitespace-nowrap">
                        {{ $p['badge'] }}
                    </span>
                    @endif
                    <div class="tag-btn h-full border-2 border-crate-sand bg-crate-cream rounded-2xl p-5 text-center
                                    peer-checked:border-crate-orange peer-checked:bg-crate-orange/5
                                    hover:border-crate-amber transition-all">
                        <div class="text-3xl mb-2">{{ $p['icon'] }}</div>
                        <p class="font-display font-bold text-crate-brown text-base">{{ $p['label'] }}</p>
                        <p class="font-body text-crate-stone text-xs mt-1">{{ $p['desc'] }}</p>
                    </div>
                </label>
                @endforeach
            </div>
            @error('periode')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- ===== PILIH PAKET ===== --}}
        <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.1s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1">📋 Pilih Paket</h2>
            <p class="text-crate-stone text-xs font-body mb-5">Sesuaikan paket dengan kebutuhan dan budget kamu</p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach($pakets as $paket)
                <label class="cursor-pointer relative flex">
                    <input type="radio" name="paket" value="{{ $paket->id }}" class="sr-only peer"
                        {{ old('paket', optional($pakets->firstWhere('highlight', true))->slug ?? $pakets->first()?->slug) === $paket->slug ? 'checked' : '' }}>

                    @if($paket->highlight)
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 z-10 bg-crate-brown text-crate-cream text-xs font-body font-semibold px-3 py-0.5 rounded-full whitespace-nowrap">
                        ⭐ Rekomendasi
                    </span>
                    @endif

                    @if($paket->badge)
                    <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 z-10 bg-crate-orange text-white text-xs font-body font-semibold px-3 py-0.5 rounded-full whitespace-nowrap">
                        {{ $paket->badge }}
                    </span>
                    @endif

                    <div class="tag-btn w-full border-2 rounded-2xl p-5 transition-all flex flex-col
                            {{ $paket->highlight ? 'border-crate-brown bg-crate-brown/5' : 'border-crate-sand bg-crate-cream' }}
                            peer-checked:border-crate-orange peer-checked:bg-crate-orange/5
                            hover:border-crate-amber">
                        <div class="text-center mb-4">
                            <div class="text-3xl mb-2">{{ $paket->icon }}</div>
                            <p class="font-display font-bold text-crate-brown text-lg">{{ $paket->nama }}</p>
                            <div class="mt-2">
                                <span class="font-display font-bold text-crate-orange text-2xl">
                                    Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                </span>
                                <span class="text-crate-stone text-xs font-body">/periode</span>
                            </div>
                            <p class="text-crate-stone text-xs font-body mt-1">{{ $paket->jumlah_item }} item per box</p>
                        </div>

                        <div class="border-t border-crate-sand my-3"></div>

                        <ul class="space-y-2 flex-1">
                            @foreach($paket->fitur ?? [] as $f)
                            <li class="flex items-start gap-2 text-xs font-body text-crate-brown/80">
                                <span class="text-crate-orange mt-0.5 shrink-0">✓</span>{{ $f }}
                            </li>
                            @endforeach
                            @foreach($paket->tidak ?? [] as $t)
                            <li class="flex items-start gap-2 text-xs font-body text-crate-stone/60 line-through">
                                <span class="mt-0.5 shrink-0">✗</span>{{ $t }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </label>
                @endforeach
            </div>
            @error('paket')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- ===== METODE PEMBAYARAN ===== --}}
        <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.15s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1">💳 Metode Pembayaran</h2>
            <p class="text-crate-stone text-xs font-body mb-5">Pilih cara pembayaran yang paling mudah buat kamu</p>

            @php
            $metodes = [
            ['value' => 'transfer_bank', 'label' => 'Transfer Bank', 'icon' => '🏦', 'desc' => 'BCA, Mandiri, BNI, BRI'],
            ['value' => 'ewallet', 'label' => 'E-Wallet', 'icon' => '📱', 'desc' => 'GoPay, OVO, DANA, ShopeePay'],
            ['value' => 'qris', 'label' => 'QRIS', 'icon' => '🔲', 'desc' => 'Scan & bayar dari semua e-wallet'],
            ['value' => 'cod', 'label' => 'Bayar di Tempat', 'icon' => '💵', 'desc' => 'COD (area tertentu)'],
            ];
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach($metodes as $m)
                <label class="cursor-pointer">
                    <input type="radio" name="metode_bayar" value="{{ $m['value'] }}" class="sr-only peer"
                        {{ old('metode_bayar', 'transfer_bank') === $m['value'] ? 'checked' : '' }}>
                    <div class="tag-btn border-2 border-crate-sand bg-crate-cream rounded-2xl p-4 text-center
                                    peer-checked:border-crate-orange peer-checked:bg-crate-orange/5
                                    hover:border-crate-amber transition-all">
                        <div class="text-2xl mb-1.5">{{ $m['icon'] }}</div>
                        <p class="font-body font-semibold text-crate-brown text-xs">{{ $m['label'] }}</p>
                        <p class="font-body text-crate-stone text-xs mt-0.5 leading-tight">{{ $m['desc'] }}</p>
                    </div>
                </label>
                @endforeach
            </div>
            @error('metode_bayar')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- ===== RINGKASAN PESANAN ===== --}}
        <div class="card-wood rounded-2xl p-6 mb-6" style="animation-delay:0.2s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-4">🧾 Ringkasan Pesanan</h2>

            <div class="bg-crate-cream rounded-xl border border-crate-sand p-5 space-y-3">
                <div class="flex justify-between items-center text-sm font-body">
                    <span class="text-crate-stone">Paket dipilih</span>
                    <span class="text-crate-brown font-semibold" id="summary-paket">Style Box</span>
                </div>
                <div class="flex justify-between items-center text-sm font-body">
                    <span class="text-crate-stone">Periode</span>
                    <span class="text-crate-brown font-semibold" id="summary-periode">Bulanan</span>
                </div>
                <div class="flex justify-between items-center text-sm font-body">
                    <span class="text-crate-stone">Metode bayar</span>
                    <span class="text-crate-brown font-semibold" id="summary-bayar">Transfer Bank</span>
                </div>
                <div class="border-t border-crate-sand my-1"></div>
                <div class="flex justify-between items-center">
                    <span class="font-body font-semibold text-crate-brown">Total per periode</span>
                    <span class="font-display font-bold text-crate-orange text-xl" id="summary-harga">Rp 129.000</span>
                </div>
            </div>

            {{-- Syarat & Ketentuan --}}
            <div class="mt-4">
                <label class="flex items-start gap-3 cursor-pointer group">
                    <div class="relative mt-0.5">
                        <input type="checkbox" name="setuju_syarat" id="setuju_syarat" value="1" class="sr-only peer"
                            {{ old('setuju_syarat') ? 'checked' : '' }}>
                        <div class="w-5 h-5 rounded-md border-2 border-crate-sand bg-crate-cream transition-all
                                    peer-checked:bg-crate-orange peer-checked:border-crate-orange
                                    flex items-center justify-center">
                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs font-body text-crate-stone leading-relaxed">
                        Saya menyetujui
                        <a href="{{ url('/syarat-ketentuan') }}" target="_blank" class="text-crate-orange hover:underline font-medium">Syarat & Ketentuan</a>
                        serta
                        <a href="{{ url('/kebijakan-privasi') }}" target="_blank" class="text-crate-orange hover:underline font-medium">Kebijakan Privasi</a>
                        Cratefit, termasuk kebijakan langganan dan pembayaran berulang.
                    </p>
                </label>
                @error('setuju_syarat')
                <p class="text-red-500 text-xs mt-1 ml-8">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ===== ACTION BUTTONS ===== --}}
        <div class="flex items-center justify-between pt-2 pb-8">
            <a href="{{ url('/alamat') }}"
                class="flex items-center gap-2 text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
                ← Kembali
            </a>
            <button type="submit"
                class="btn-primary text-white font-body font-semibold px-8 py-3.5 rounded-2xl text-sm shadow-lg flex items-center gap-2">
                🎉 Mulai Langganan →
            </button>
        </div>

    </form>
</div>

{{-- ===== JAVASCRIPT RINGKASAN DINAMIS ===== --}}
<script>
    const paketData = {
        @foreach($pakets as $paket)
        "{{ $paket->slug }}": {
            nama: "{{ $paket->nama }}",
            harga: {
                {
                    $paket - > harga
                }
            }
        },
        @endforeach
    };

    const periodeData = {
        bulanan: '1 bulan sekali',
        '2bulan': '2 bulan sekali',
        '3bulan': '3 bulan sekali',
    };

    const metodeData = {
        transfer_bank: 'Transfer Bank',
        ewallet: 'E-Wallet',
        qris: 'QRIS',
        cod: 'Bayar di Tempat',
    };

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function updateSummary() {
        const paket = document.querySelector('input[name="paket"]:checked')?.value || 'style';
        const periode = document.querySelector('input[name="periode"]:checked')?.value || 'bulanan';
        const metode = document.querySelector('input[name="metode_bayar"]:checked')?.value || 'transfer_bank';

        document.getElementById('summary-paket').textContent = paketData[paket]?.nama || '-';
        document.getElementById('summary-harga').textContent = formatRupiah(paketData[paket]?.harga || 0);
        document.getElementById('summary-periode').textContent = periodeData[periode] || '-';
        document.getElementById('summary-bayar').textContent = metodeData[metode] || '-';
    }

    // Centang custom checkbox visual
    const syaratInput = document.getElementById('setuju_syarat');
    const syaratBox = syaratInput?.nextElementSibling;
    const syaratCheck = syaratBox?.querySelector('svg');

    syaratInput?.addEventListener('change', function() {
        if (this.checked) {
            syaratBox.classList.add('bg-crate-orange', 'border-crate-orange');
            syaratBox.classList.remove('border-crate-sand', 'bg-crate-cream');
            syaratCheck.classList.remove('hidden');
        } else {
            syaratBox.classList.remove('bg-crate-orange', 'border-crate-orange');
            syaratBox.classList.add('border-crate-sand', 'bg-crate-cream');
            syaratCheck.classList.add('hidden');
        }
    });

    document.querySelectorAll('input[name="paket"], input[name="periode"], input[name="metode_bayar"]')
        .forEach(el => el.addEventListener('change', updateSummary));

    // Init
    updateSummary();
</script>
@endsection