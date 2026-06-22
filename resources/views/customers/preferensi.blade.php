@extends('layouts.app')
@section('title', 'Preferensi Fashion')

@section('content')
<div class="fade-in">

    {{-- PAGE HEADER --}}
    <div class="mb-8">
        <p class="text-crate-orange font-script text-lg mb-1">Langkah 2 dari 4</p>
        <h1 class="font-display text-3xl text-crate-brown font-bold">Preferensi Fashion Kamu</h1>
        <p class="text-crate-stone font-body mt-1 text-sm">Ceritakan gaya kamu — kurator kami akan menyusun box yang pas banget!</p>
    </div>

    <form action="" method="POST" class="space-y-6">
        @csrf

        {{-- ===== UKURAN PAKAIAN ===== --}}
        <div class="card-wood rounded-2xl p-6" style="animation-delay:0.05s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1 flex items-center gap-2">
                <i data-lucide="ruler" class="w-5 h-5 text-crate-orange"></i> Ukuran Pakaian
            </h2>
            <p class="text-crate-stone text-xs font-body mb-5">Pilih ukuran yang biasa kamu pakai</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">

                {{-- Atasan --}}
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">Atasan</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['XS','S','M','L','XL','XXL'] as $s)
                        <label class="cursor-pointer">
                            <input type="radio" name="ukuran_atasan" value="{{ $s }}" class="sr-only peer"
                                {{ old('ukuran_atasan', $preferensi->ukuran_atasan ?? '') === $s ? 'checked' : '' }}>
                            <span class="tag-btn block px-3 py-1.5 rounded-lg border border-crate-sand bg-crate-cream
                                             text-sm font-body text-crate-brown
                                             peer-checked:bg-crate-orange peer-checked:text-white peer-checked:border-crate-orange
                                             hover:border-crate-amber transition-all">
                                {{ $s }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    @error('ukuran_atasan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Bawahan --}}
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">Bawahan</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['XS','S','M','L','XL','XXL'] as $s)
                        <label class="cursor-pointer">
                            <input type="radio" name="ukuran_bawahan" value="{{ $s }}" class="sr-only peer"
                                {{ old('ukuran_bawahan', $preferensi->ukuran_bawahan ?? '') === $s ? 'checked' : '' }}>
                            <span class="tag-btn block px-3 py-1.5 rounded-lg border border-crate-sand bg-crate-cream
                                             text-sm font-body text-crate-brown
                                             peer-checked:bg-crate-orange peer-checked:text-white peer-checked:border-crate-orange
                                             hover:border-crate-amber transition-all">
                                {{ $s }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    @error('ukuran_bawahan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Tinggi & Berat --}}
                <div class="sm:col-span-1 space-y-3">
                    <div>
                        <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                            Tinggi Badan (cm)
                        </label>
                        <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan', $preferensi->tinggi_badan ?? '') }}"
                            placeholder="cth: 165"
                            class="w-full border border-crate-sand rounded-xl px-4 py-2.5 text-sm font-body text-crate-brown
                                      bg-crate-cream placeholder-crate-stone transition-all">
                        @error('tinggi_badan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                            Berat Badan (kg)
                        </label>
                        <input type="number" name="berat_badan" value="{{ old('berat_badan', $preferensi->berat_badan ?? '') }}"
                            placeholder="cth: 55"
                            class="w-full border border-crate-sand rounded-xl px-4 py-2.5 text-sm font-body text-crate-brown
                                      bg-crate-cream placeholder-crate-stone transition-all">
                        @error('berat_badan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== STYLE ===== --}}
        <div class="card-wood rounded-2xl p-6" style="animation-delay:0.1s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1 flex items-center gap-2">
                <i data-lucide="palette" class="w-5 h-5 text-crate-orange"></i> Gaya Berpakaian
            </h2>
            <p class="text-crate-stone text-xs font-body mb-5">Pilih satu atau lebih gaya favoritmu</p>

            @php
            $styles = [
            ['icon'=>'shirt',          'name'=>'Casual', 'desc'=>'Santai sehari-hari'],
            ['icon'=>'sparkles',       'name'=>'Streetwear', 'desc'=>'Edgy & urban'],
            ['icon'=>'flower-2',       'name'=>'Feminine', 'desc'=>'Soft & flowy'],
            ['icon'=>'landmark',       'name'=>'Vintage', 'desc'=>'Retro & klasik'],
            ['icon'=>'circle',         'name'=>'Minimalis', 'desc'=>'Clean & simpel'],
            ['icon'=>'sun',            'name'=>'Boho', 'desc'=>'Bohemian & earthy'],
            ['icon'=>'briefcase',      'name'=>'Smart Casual', 'desc'=>'Rapi tapi santai'],
            ['icon'=>'shuffle',        'name'=>'Eclectic', 'desc'=>'Campur & berani'],
            ];
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach($styles as $style)
                <label class="cursor-pointer group">
                    <input type="checkbox" name="gaya_berpakaian[]" value="{{ $style['name'] }}" class="sr-only peer"
                        {{ in_array($style['name'], old('gaya_berpakaian', $preferensi->gaya_berpakaian ?? [])) ? 'checked' : '' }}>
                    <div class="tag-btn h-full border-2 border-crate-sand bg-crate-cream rounded-2xl p-4 text-center
                                    peer-checked:border-crate-orange peer-checked:bg-crate-orange/5
                                    hover:border-crate-amber transition-all">
                        <div class="mb-1 flex justify-center">
                            <i data-lucide="{{ $style['icon'] }}" class="w-7 h-7 text-crate-orange"></i>
                        </div>
                        <p class="font-body font-semibold text-crate-brown text-sm">{{ $style['name'] }}</p>
                        <p class="font-body text-crate-stone text-xs mt-0.5">{{ $style['desc'] }}</p>
                    </div>
                </label>
                @endforeach
            </div>
            @error('gaya_berpakaian')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
        </div>

        {{-- ===== WARNA FAVORIT ===== --}}
        <div class="card-wood rounded-2xl p-6" style="animation-delay:0.15s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1 flex items-center gap-2">
                <i data-lucide="palette" class="w-5 h-5 text-crate-orange"></i> Warna Favorit
            </h2>
            <p class="text-crate-stone text-xs font-body mb-5">Pilih warna yang sering kamu pakai (maks. 5)</p>

            @php
            $colors = [
            ['name'=>'Hitam', 'hex'=>'#1A1A1A'],
            ['name'=>'Putih', 'hex'=>'#F5F5F0'],
            ['name'=>'Abu-abu', 'hex'=>'#9E9E9E'],
            ['name'=>'Navy', 'hex'=>'#1B2A4A'],
            ['name'=>'Biru', 'hex'=>'#3B82F6'],
            ['name'=>'Hijau', 'hex'=>'#22C55E'],
            ['name'=>'Sage', 'hex'=>'#87A878'],
            ['name'=>'Merah', 'hex'=>'#EF4444'],
            ['name'=>'Oranye', 'hex'=>'#F97316'],
            ['name'=>'Kuning', 'hex'=>'#EAB308'],
            ['name'=>'Krem', 'hex'=>'#F5F0E0'],
            ['name'=>'Coklat', 'hex'=>'#7C3F1E'],
            ['name'=>'Ungu', 'hex'=>'#A855F7'],
            ['name'=>'Pink', 'hex'=>'#EC4899'],
            ['name'=>'Dusty Rose','hex'=>'#D4929A'],
            ['name'=>'Terracota', 'hex'=>'#C2694F'],
            ];
            @endphp

            <div class="flex flex-wrap gap-4">
                @foreach($colors as $color)
                <label class="cursor-pointer flex flex-col items-center gap-1.5" title="{{ $color['name'] }}">
                    <input type="checkbox" name="warna_favorit[]" value="{{ $color['name'] }}" class="sr-only peer"
                        {{ in_array($color['name'], old('warna_favorit', $preferensi->warna_favorit ?? [])) ? 'checked' : '' }}>
                    <div class="swatch-btn w-9 h-9 rounded-full border-2 border-transparent peer-checked:border-crate-orange
                                    shadow-sm transition-all ring-1 ring-black/10"
                        style="background:{{ $color['hex'] }}"></div>
                    <span class="text-crate-brown/60 text-xs font-body text-center leading-tight" style="max-width:48px">{{ $color['name'] }}</span>
                </label>
                @endforeach
            </div>
            @error('warna_favorit')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
        </div>

        {{-- ===== PREFERENSI ITEM ===== --}}
        <div class="card-wood rounded-2xl p-6" style="animation-delay:0.2s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1 flex items-center gap-2">
                <i data-lucide="shirt" class="w-5 h-5 text-crate-orange"></i> Jenis Pakaian yang Diinginkan
            </h2>
            <p class="text-crate-stone text-xs font-body mb-5">Pilih item apa yang boleh masuk ke dalam box kamu</p>

            @php
            $items = ['Kaos','Kemeja','Jaket','Hoodie','Blazer','Cardigan','Dress','Rok','Celana Jeans','Celana Casual','Celana Pendek','Outer'];
            @endphp

            <div class="flex flex-wrap gap-2">
                @foreach($items as $item)
                <label class="cursor-pointer">
                    <input type="checkbox" name="jenis_pakaian[]" value="{{ $item }}" class="sr-only peer"
                        {{ in_array($item, old('jenis_pakaian', $preferensi->jenis_pakaian ?? [])) ? 'checked' : '' }}>
                    <span class="tag-btn inline-block px-4 py-2 rounded-full border border-crate-sand bg-crate-cream
                                     text-sm font-body text-crate-brown
                                     peer-checked:bg-crate-orange peer-checked:text-white peer-checked:border-crate-orange
                                     hover:border-crate-amber transition-all">
                        {{ $item }}
                    </span>
                </label>
                @endforeach
            </div>
            @error('jenis_pakaian')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
        </div>

        {{-- ===== PANTANGAN / CATATAN ===== --}}
        <div class="card-wood rounded-2xl p-6" style="animation-delay:0.25s">
            <h2 class="font-display text-lg text-crate-brown font-bold mb-1 flex items-center gap-2">
                <i data-lucide="ban" class="w-5 h-5 text-crate-orange"></i> Pantangan & Catatan Khusus
            </h2>
            <p class="text-crate-stone text-xs font-body mb-5">Ceritakan item yang TIDAK ingin kamu terima, atau hal lain yang perlu diketahui kurator</p>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                        Item yang tidak diinginkan
                    </label>
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach(['Celana Pendek','Dress','Rok','Pakaian Polos','Motif Ramai'] as $pantang)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="pantangan[]" value="{{ $pantang }}" class="sr-only peer"
                                {{ in_array($pantang, old('pantangan', $preferensi->pantangan ?? [])) ? 'checked' : '' }}>
                                <span class="tag-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-crate-sand bg-crate-cream
                                                text-sm font-body text-crate-brown
                                                peer-checked:bg-red-100 peer-checked:text-red-700 peer-checked:border-red-300
                                                hover:border-crate-amber transition-all">
                                    <i data-lucide="ban" class="w-3.5 h-3.5"></i> {{ $pantang }}
                                </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                        Catatan tambahan untuk kurator
                    </label>
                    <textarea name="catatan_kurator" rows="4"
                        placeholder="cth: Saya lebih suka warna earth tone, hindari motif bunga, prefer pakaian yang bisa dipakai ke kampus..."
                        class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                                     bg-crate-cream placeholder-crate-stone resize-none transition-all">{{ old('catatan_kurator', $preferensi->catatan_kurator ?? '') }}</textarea>
                    @error('catatan_kurator')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- ===== ACTION BUTTONS ===== --}}
        <div class="flex items-center justify-between pt-2 pb-8">
            <a href=""
                class="flex items-center gap-2 text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
                ← Kembali
            </a>
            <button type="submit"
                class="btn-primary text-white font-body font-semibold px-8 py-3.5 rounded-2xl text-sm shadow-lg">
                Simpan & Lanjutkan →
            </button>
        </div>

    </form>
</div>
@endsection