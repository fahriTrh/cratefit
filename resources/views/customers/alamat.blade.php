@extends('layouts.app')
@section('title', 'Alamat Pengiriman')

@section('content')
<div class="fade-in">

    {{-- PAGE HEADER --}}
    <div class="mb-8">
        <p class="text-crate-orange font-script text-lg mb-1">Langkah 3 dari 4</p>
        <h1 class="font-display text-3xl text-crate-brown font-bold">Alamat Pengiriman</h1>
        <p class="text-crate-stone font-body mt-1 text-sm">Pastikan alamatmu benar ya — box Cratefit akan dikirim ke sini! 📦</p>
    </div>

    {{-- SAVED ADDRESSES (jika sudah ada) --}}
    @if(isset($addresses) && $addresses->count())
    <div class="card-wood rounded-2xl p-6 mb-6">
        <h2 class="font-display text-lg text-crate-brown font-bold mb-4">📋 Alamat Tersimpan</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach($addresses as $addr)
            <label class="cursor-pointer group">
                <input type="radio" name="alamat_terpilih" value="{{ $addr->id }}" class="sr-only peer"
                    {{ $addr->is_primary ? 'checked' : '' }}>
                <div class="border-2 border-crate-sand rounded-2xl p-4 transition-all
                                    peer-checked:border-crate-orange peer-checked:bg-crate-orange/5
                                    hover:border-crate-amber">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <span class="font-body font-semibold text-crate-brown text-sm">{{ $addr->label }}</span>
                            @if($addr->is_primary)
                            <span class="ml-2 text-xs bg-crate-orange/10 text-crate-orange px-2 py-0.5 rounded-full font-body">Utama</span>
                            @endif
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 border-crate-sand peer-checked:border-crate-orange
                                            flex items-center justify-center shrink-0 transition-all
                                            group-has-[:checked]:border-crate-orange group-has-[:checked]:bg-crate-orange">
                        </div>
                    </div>
                    <p class="text-crate-brown font-body text-sm font-medium">{{ $addr->nama_penerima }}</p>
                    <p class="text-crate-stone font-body text-xs mt-0.5">{{ $addr->no_telepon }}</p>
                    <p class="text-crate-stone font-body text-xs mt-1 leading-relaxed">
                        {{ $addr->alamat_lengkap }}, {{ $addr->kelurahan }}, {{ $addr->kecamatan }},
                        {{ $addr->kota }}, {{ $addr->provinsi }} {{ $addr->kode_pos }}
                    </p>
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('pelanggan.alamat.edit', $addr->id) }}"
                            class="text-xs text-crate-orange font-body hover:underline block" style="margin-top: 5px;">Edit</a>
                        <span class="text-crate-sand">|</span>
                        <form action="{{ route('pelanggan.alamat.destroy', $addr->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 font-body hover:underline"
                                onclick="return confirm('Hapus alamat ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </label>
            @endforeach
        </div>
    </div>
    @endif

    {{-- FORM TAMBAH ALAMAT BARU --}}
    <div class="card-wood rounded-2xl p-6">
        <h2 class="font-display text-lg text-crate-brown font-bold mb-1">
            {{ isset($addresses) && $addresses->count() ? '➕ Tambah Alamat Baru' : '📍 Isi Alamat Pengiriman' }}
        </h2>
        <p class="text-crate-stone text-xs font-body mb-6">Lengkapi data penerima dan lokasi pengiriman</p>

        <form action="{{ isset($editAlamat) ? url('/alamat/' . $editAlamat->id) : url('/alamat') }}"
            method="POST" class="space-y-5">
            @csrf
            @if(isset($editAlamat)) @method('PUT') @endif

            {{-- Label Alamat --}}
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                    Label Alamat
                </label>
                <div class="flex flex-wrap gap-2 mb-3">
                    @foreach(['Rumah','Kos','Asrama','Kantor','Lainnya'] as $label)
                    <label class="cursor-pointer">
                        <input type="radio" name="label" value="{{ $label }}" class="sr-only peer"
                            {{ old('label', $editAlamat->label ?? 'Rumah') === $label ? 'checked' : '' }}>
                        <span class="tag-btn inline-block px-4 py-2 rounded-full border border-crate-sand bg-crate-cream
                                         text-sm font-body text-crate-brown
                                         peer-checked:bg-crate-brown peer-checked:text-crate-cream peer-checked:border-crate-brown
                                         hover:border-crate-amber transition-all">
                            {{ $label === 'Rumah' ? '🏠' : ($label === 'Kos' ? '🏘️' : ($label === 'Asrama' ? '🏫' : ($label === 'Kantor' ? '🏢' : '📌'))) }}
                            {{ $label }}
                        </span>
                    </label>
                    @endforeach
                </div>
                @error('label')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
            </div>

            {{-- Nama & No HP --}}
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                        Nama Penerima <span class="text-crate-orange">*</span>
                    </label>
                    <input type="text" name="nama_penerima" value="{{ old('nama_penerima', $editAlamat->nama_penerima ?? '') }}"
                        placeholder="Nama lengkap penerima"
                        class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                                  bg-crate-cream placeholder-crate-stone transition-all"
                        required>
                    @error('nama_penerima')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                        Nomor Telepon <span class="text-crate-orange">*</span>
                    </label>
                    <div class="flex">
                        <span class="flex items-center px-3 bg-crate-sand border border-r-0 border-crate-sand rounded-l-xl
                                     text-crate-brown font-body text-sm">+62</span>
                        <input type="tel" name="no_telepon" value="{{ old('no_telepon', $editAlamat->no_telepon ?? '') }}"
                            placeholder="812 3456 7890"
                            class="flex-1 border border-crate-sand rounded-r-xl px-4 py-3 text-sm font-body text-crate-brown
                                      bg-crate-cream placeholder-crate-stone transition-all"
                            required>
                    </div>
                    @error('no_telepon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Alamat Lengkap --}}
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                    Alamat Lengkap <span class="text-crate-orange">*</span>
                </label>
                <textarea name="alamat_lengkap" rows="3" required
                    placeholder="Nama jalan, nomor rumah, RT/RW, nama gedung/apartemen (jika ada)..."
                    class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                                 bg-crate-cream placeholder-crate-stone resize-none transition-all">{{ old('alamat_lengkap', $editAlamat->alamat_lengkap ?? '') }}</textarea>
                @error('alamat_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Kelurahan & Kecamatan --}}
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                        Kelurahan / Desa <span class="text-crate-orange">*</span>
                    </label>
                    <input type="text" name="kelurahan" value="{{ old('kelurahan', $editAlamat->kelurahan ?? '') }}"
                        placeholder="cth: Kelurahan Sei Agul"
                        class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                                  bg-crate-cream placeholder-crate-stone transition-all"
                        required>
                    @error('kelurahan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                        Kecamatan <span class="text-crate-orange">*</span>
                    </label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan', $editAlamat->kecamatan ?? '') }}"
                        placeholder="cth: Kecamatan Medan Barat"
                        class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                                  bg-crate-cream placeholder-crate-stone transition-all"
                        required>
                    @error('kecamatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Kota, Provinsi, Kode Pos --}}
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                        Kota / Kabupaten <span class="text-crate-orange">*</span>
                    </label>
                    <input type="text" name="kota" value="{{ old('kota', $editAlamat->kota ?? '') }}"
                        placeholder="cth: Medan"
                        class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                                  bg-crate-cream placeholder-crate-stone transition-all"
                        required>
                    @error('kota')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                        Provinsi <span class="text-crate-orange">*</span>
                    </label>
                    <select name="provinsi"
                        class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                                   bg-crate-cream transition-all appearance-none"
                        required>
                        <option value="">Pilih provinsi</option>
                        @php
                        $provinsi = ['Aceh','Sumatera Utara','Sumatera Barat','Riau','Kepulauan Riau','Jambi',
                        'Sumatera Selatan','Kepulauan Bangka Belitung','Bengkulu','Lampung',
                        'DKI Jakarta','Jawa Barat','Banten','Jawa Tengah','DI Yogyakarta','Jawa Timur',
                        'Bali','Nusa Tenggara Barat','Nusa Tenggara Timur',
                        'Kalimantan Barat','Kalimantan Tengah','Kalimantan Selatan','Kalimantan Timur','Kalimantan Utara',
                        'Sulawesi Utara','Gorontalo','Sulawesi Tengah','Sulawesi Barat','Sulawesi Selatan','Sulawesi Tenggara',
                        'Maluku','Maluku Utara','Papua Barat','Papua'];
                        @endphp
                        @foreach($provinsi as $p)
                        <option value="{{ $p }}" {{ old('provinsi', $editAlamat->provinsi ?? '') === $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                    @error('provinsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                        Kode Pos <span class="text-crate-orange">*</span>
                    </label>
                    <input type="text" name="kode_pos" value="{{ old('kode_pos', $editAlamat->kode_pos ?? '') }}"
                        placeholder="cth: 20117" maxlength="5"
                        class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                                  bg-crate-cream placeholder-crate-stone transition-all"
                        required>
                    @error('kode_pos')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Catatan Kurir --}}
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-1.5">
                    Catatan untuk Kurir <span class="text-crate-stone font-normal normal-case">(opsional)</span>
                </label>
                <input type="text" name="catatan_kurir" value="{{ old('catatan_kurir', $editAlamat->catatan_kurir ?? '') }}"
                    placeholder="cth: Rumah cat kuning, depan masjid. Telepon dulu sebelum kirim."
                    class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body text-crate-brown
                              bg-crate-cream placeholder-crate-stone transition-all">
                @error('catatan_kurir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Jadikan Alamat Utama --}}
            <div class="flex items-center gap-3 p-4 bg-crate-cream rounded-xl border border-crate-sand">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_primary" value="1" class="sr-only peer"
                        {{ old('is_primary', $editAlamat->is_primary ?? false) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-crate-sand rounded-full peer peer-checked:bg-crate-orange transition-all
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                                peer-checked:after:translate-x-5"></div>
                </label>
                <div>
                    <p class="text-sm font-body font-semibold text-crate-brown">Jadikan alamat utama</p>
                    <p class="text-xs font-body text-crate-stone">Box Cratefit akan otomatis dikirim ke alamat ini</p>
                </div>
            </div>

    </div>{{-- end card --}}

    {{-- ===== ACTION BUTTONS ===== --}}
    <div class="flex items-center justify-between pt-2 pb-8">
        <a href="{{ url('/preferensi') }}"
            class="flex items-center gap-2 text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
            ← Kembali ke Preferensi
        </a>
        <button type="submit"
            class="btn-primary text-white font-body font-semibold px-8 py-3.5 rounded-2xl text-sm shadow-lg">
            Simpan & Pilih Paket →
        </button>
    </div>

    </form>
</div>{{-- end outer wrapper --}}

</div>
@endsection