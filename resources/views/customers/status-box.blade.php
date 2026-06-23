@extends('layouts.app')
@section('title', 'Status Langgananku')

@section('content')
<div class="fade-in">

    <div class="mb-8">
        <p class="mb-1 font-display">Langganan Aktif</p>
        <h1 class="font-display text-3xl text-crate-text font-bold">Status Langgananku</h1>
        <p class="text-gray-500 font-body mt-1 text-sm">Informasi paket dan pengiriman box kamu.</p>
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
                    <p class="font-display font-bold text-crate-text text-xl">{{ $langganan->paket->nama }}</p>
                    <p class="text-gray-500 text-sm font-body">{{ $langganan->paket->jumlah_item }} item per box</p>
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
        <h2 class="font-display text-base font-bold text-crate-text mb-4 flex items-center gap-2">
            <i data-lucide="package" class="w-5 h-5 text-crate-primary"></i> Status Box
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
                        ? 'bg-crate-primary text-white'
                        : 'bg-crate-accent text-gray-400' }}">
                <i data-lucide="{{ $info['icon'] }}" class="w-4 h-4"></i>
            </div>
            <p class="text-xs font-body text-center
                   {{ $currentStep >= $step ? 'text-crate-text font-semibold' : 'text-gray-400' }}">
                {{ $info['label'] }}
            </p>
        </div>
        @if($step < 5)
            <div class="h-0.5 flex-1 mx-1 {{ $currentStep > $step ? 'bg-crate-primary' : 'bg-crate-accent' }}"></div>
        @endif
        @endforeach
    </div>

    {{-- Kode Box & Status --}}
    <div class="bg-crate-bg rounded-xl p-4 mb-4 flex items-center justify-between flex-wrap gap-2">
        <div>
            <p class="text-xs text-gray-500 font-body">Kode Box</p>
            <p class="font-display font-bold text-crate-text text-lg">{{ $box->kode_box }}</p>
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
        <span class="text-gray-500">Nomor Resi</span>
        <span class="font-semibold text-crate-text">{{ $box->nomor_resi }}</span>
    </div>
    @endif

    @if($box->items->count() > 0)
    <div class="mb-4">
        <p class="text-xs font-body font-semibold text-crate-text/50 uppercase tracking-wider mb-2">Isi Box</p>
        <div class="space-y-2">
            @foreach($box->items as $boxItem)
            <div class="flex items-center gap-3 bg-white rounded-xl px-4 py-3 border border-crate-accent">
                <i data-lucide="shirt" class="w-6 h-6 text-crate-primary"></i>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-body font-semibold text-crate-text truncate">
                        {{ $boxItem->item->nama }}
                    </p>
                    <p class="text-xs text-gray-500 font-body">
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
            class="w-full btn-primary text-white font-body font-semibold
                    px-6 py-3 rounded-2xl text-sm flex items-center justify-center gap-2">
            <i data-lucide="check-circle" class="w-4 h-4"></i> Konfirmasi Box Sudah Diterima
        </button>
    </form>
    @endif
</div>
@else
<div class="card-wood rounded-2xl p-6 mb-6 text-center">
    <div class="mb-3 flex justify-center">
        <i data-lucide="clock" class="w-10 h-10 text-crate-primary"></i>
    </div>
    <p class="font-display font-bold text-crate-text">Box Sedang Disiapkan</p>
    <p class="text-gray-500 text-sm font-body mt-1">Kurator sedang memilihkan item terbaik untukmu.</p>
</div>
@endif

{{-- Detail Langganan --}}
<div class="card-wood rounded-2xl p-6 mb-6">
    <h2 class="font-display text-base font-bold text-crate-text mb-4 flex items-center gap-2">
        <i data-lucide="clipboard-list" class="w-5 h-5 text-crate-primary"></i> Detail Langganan
    </h2>
    <div class="space-y-3 text-sm font-body">
        <div class="flex justify-between items-center">
            <span class="text-gray-500">Harga per periode</span>
            <span class="font-display font-bold text-crate-primary text-base">
                Rp {{ number_format($langganan->paket->harga, 0, ',', '.') }}
            </span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-gray-500">Periode pengiriman</span>
            <span class="text-crate-text font-semibold">
                {{ ['bulanan' => 'Setiap bulan', '2bulan' => 'Setiap 2 bulan', '3bulan' => 'Setiap 3 bulan'][$langganan->periode] }}
            </span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-gray-500">Metode bayar</span>
            <span class="text-crate-text font-semibold">
                {{ ['transfer_bank' => 'Transfer Bank', 'ewallet' => 'E-Wallet', 'qris' => 'QRIS', 'cod' => 'COD'][$langganan->metode_bayar] }}
            </span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-gray-500">Mulai langganan</span>
            <span class="text-crate-text font-semibold">
                {{ $langganan->tanggal_mulai->translatedFormat('d F Y') }}
            </span>
        </div>
        <div class="border-t border-crate-accent pt-3 flex justify-between items-center">
            <span class="text-gray-500">Pengiriman berikutnya</span>
            <span class="text-crate-text font-bold">
                {{ $langganan->tanggal_pengiriman_berikutnya?->translatedFormat('d F Y') ?? '-' }}
            </span>
        </div>
    </div>
</div>

{{-- Alamat Pengiriman --}}
<div class="card-wood rounded-2xl p-6 mb-6">
    <h2 class="font-display text-base font-bold text-crate-text mb-4 flex items-center gap-2">
        <i data-lucide="map-pin" class="w-5 h-5 text-crate-primary"></i> Alamat Pengiriman
    </h2>
    <p class="text-crate-text font-semibold text-sm font-body">{{ $langganan->alamat->nama_penerima }}</p>
    <p class="text-gray-500 text-sm font-body mt-1 leading-relaxed">
        {{ $langganan->alamat->alamat_lengkap }},
        {{ $langganan->alamat->kelurahan }},
        {{ $langganan->alamat->kecamatan }},
        {{ $langganan->alamat->kota }},
        {{ $langganan->alamat->provinsi }}
        {{ $langganan->alamat->kode_pos }}
    </p>
    @if($langganan->alamat->catatan_kurir)
    <p class="text-gray-400 text-xs font-body mt-2 italic">
        Catatan: {{ $langganan->alamat->catatan_kurir }}
    </p>
    @endif
</div>

{{-- Aksi --}}
<div class="flex flex-col sm:flex-row gap-3 pb-8">
    <a href="{{ url('/retur') }}"
        class="flex-1 text-center border-2 border-crate-accent text-crate-text font-body font-semibold
                px-6 py-3 rounded-2xl text-sm hover:border-crate-primary transition-colors flex items-center justify-center gap-2">
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

{{-- GANTI bagian Rating Section ini di resources/views/customers/status-box.blade.php --}}

{{-- Rating Section --}}
@if($box && $box->status === 'selesai')
<div class="rounded-2xl p-6 mt-6" style="background-color: #fef5e7; border: 2px solid #f9e79f;">
    <h3 class="font-display text-lg font-bold text-crate-text mb-4 flex items-center gap-2">
        <i data-lucide="star" class="w-5 h-5 text-yellow-500"></i> Beri Rating
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Rating Kurator --}}
        @if($box->kurator)
        <div class="card-wood rounded-2xl p-6" style="background: white;">
            <h4 class="font-display font-semibold mb-2 text-crate-text">Rating Kurator</h4>
            <p class="text-sm text-gray-600 mb-4 font-body">{{ $box->kurator->name }}</p>
            
            @php
                $ratingKurator = $box->ratingKurator();
                $ratingValueKurator = $ratingKurator ? $ratingKurator->rating : 0;
            @endphp

            <form action="{{ route('rating.store') }}" method="POST">
                @csrf
                <input type="hidden" name="box_id" value="{{ $box->id }}">
                <input type="hidden" name="rated_user_id" value="{{ $box->kurator->id }}">
                <input type="hidden" name="tipe" value="kurator">
                <input type="hidden" name="rating" id="ratingKuratorValue" value="{{ $ratingValueKurator }}">

                {{-- Star Rating --}}
                <div class="flex gap-1 mb-4" id="ratingKuratorStars">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" 
                                data-rating="{{ $i }}" 
                                class="star-button focus:outline-none transition-transform hover:scale-110"
                                onclick="setRating(this, 'ratingKuratorValue', 'ratingKuratorStars')">
                            <svg class="w-9 h-9 transition-colors duration-200" 
                                 viewBox="0 0 24 24" 
                                 fill="{{ $i <= $ratingValueKurator ? '#fbbf24' : '#e5e7eb' }}"
                                 stroke="currentColor" 
                                 stroke-width="0">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </button>
                    @endfor
                </div>

                {{-- Comment --}}
                <textarea name="komentar" 
                          placeholder="Komentar (opsional)" 
                          class="w-full border-2 border-crate-accent rounded-lg px-3 py-2 text-sm mb-4 font-body focus:border-crate-primary focus:outline-none" 
                          rows="2" 
                          maxlength="500">{{ $ratingKurator->komentar ?? '' }}</textarea>

                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-body font-semibold py-2.5 rounded-lg transition-colors">
                    {{ $ratingKurator ? 'Update Rating' : 'Kirim Rating' }}
                </button>
            </form>
        </div>
        @endif

        {{-- Rating Kurir --}}
        @if($box->kurir_id)
        <div class="card-wood rounded-2xl p-6" style="background: white;">
            <h4 class="font-display font-semibold mb-2 text-crate-text">Rating Kurir</h4>
            <p class="text-sm text-gray-600 mb-4 font-body">{{ $box->kurir->name ?? 'Kurir' }}</p>
            
            @php
                $ratingKurir = $box->ratings()->where('tipe', 'kurir')->first();
                $ratingValueKurir = $ratingKurir ? $ratingKurir->rating : 0;
            @endphp

            <form action="{{ route('rating.store') }}" method="POST">
                @csrf
                <input type="hidden" name="box_id" value="{{ $box->id }}">
                <input type="hidden" name="rated_user_id" value="{{ $box->kurir_id }}">
                <input type="hidden" name="tipe" value="kurir">
                <input type="hidden" name="rating" id="ratingKurirValue" value="{{ $ratingValueKurir }}">

                {{-- Star Rating --}}
                <div class="flex gap-1 mb-4" id="ratingKurirStars">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" 
                                data-rating="{{ $i }}" 
                                class="star-button focus:outline-none transition-transform hover:scale-110"
                                onclick="setRating(this, 'ratingKurirValue', 'ratingKurirStars')">
                            <svg class="w-9 h-9 transition-colors duration-200" 
                                 viewBox="0 0 24 24" 
                                 fill="{{ $i <= $ratingValueKurir ? '#fbbf24' : '#e5e7eb' }}"
                                 stroke="currentColor" 
                                 stroke-width="0">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </button>
                    @endfor
                </div>

                {{-- Comment --}}
                <textarea name="komentar" 
                          placeholder="Komentar (opsional)" 
                          class="w-full border-2 border-crate-accent rounded-lg px-3 py-2 text-sm mb-4 font-body focus:border-crate-primary focus:outline-none" 
                          rows="2" 
                          maxlength="500">{{ $ratingKurir->komentar ?? '' }}</textarea>

                <button type="submit" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-body font-semibold py-2.5 rounded-lg transition-colors">
                    {{ $ratingKurir ? 'Update Rating' : 'Kirim Rating' }}
                </button>
            </form>
        </div>
        @endif
    </div>
</div>

{{-- JavaScript untuk Star Rating --}}
<script>
function setRating(button, inputId, containerId) {
    const rating = button.dataset.rating;
    document.getElementById(inputId).value = rating;
    
    const container = document.getElementById(containerId);
    const buttons = container.querySelectorAll('button');
    
    buttons.forEach((btn, index) => {
        const svg = btn.querySelector('svg');
        if (index < rating) {
            svg.setAttribute('fill', '#fbbf24'); // Yellow
        } else {
            svg.setAttribute('fill', '#e5e7eb'); // Gray
        }
    });
}

// Hover effect untuk star rating
document.querySelectorAll('[id$="Stars"]').forEach(container => {
    const buttons = container.querySelectorAll('button');
    
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            const rating = this.dataset.rating;
            buttons.forEach((btn, index) => {
                const svg = btn.querySelector('svg');
                if (index < rating) {
                    svg.setAttribute('fill', '#fcd34d'); // Lighter yellow
                } else {
                    svg.setAttribute('fill', '#d1d5db'); // Lighter gray
                }
            });
        });
    });
    
    container.addEventListener('mouseleave', function() {
        const inputId = container.id.replace('Stars', 'Value');
        const currentRating = document.getElementById(inputId).value || 0;
        buttons.forEach((btn, index) => {
            const svg = btn.querySelector('svg');
            if (index < currentRating) {
                svg.setAttribute('fill', '#fbbf24');
            } else {
                svg.setAttribute('fill', '#e5e7eb');
            }
        });
    });
});
</script>
@endif
</div>
@endsection