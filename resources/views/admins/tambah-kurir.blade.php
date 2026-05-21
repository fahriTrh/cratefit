@extends('layouts.admin.app')
@section('title', isset($kurir) && isset($kurir['id']) ? 'Edit Kurir — ' . $kurir['nama'] : 'Tambah Kurir')

@section('content')

@php
$isEdit = isset($kurir);
$kurir = $kurir ?? [
'id' => null,
'nama' => '',
'email' => '',
'no_hp' => '',
'status' => 'aktif',
'kendaraan' => '',
'plat' => '',
'wilayah' => '',
'tanggal_bergabung' => date('Y-m-d'),
'catatan' => '',
];
@endphp

<div class="fade-in">

    {{-- HEADER --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm font-body text-crate-stone mb-3">
            <a href="{{ url('/admin/kurir') }}"
                class="hover:text-crate-brown transition-colors">← Kelola Kurir</a>
            <span>/</span>
            <span class="text-crate-brown font-medium">
                {{ $isEdit ? 'Edit: ' . $kurir['nama'] : 'Tambah Kurir' }}
            </span>
        </div>
        <p class="text-crate-orange font-script text-lg mb-0.5">Panel Admin</p>
        <h1 class="font-display text-3xl text-crate-brown font-bold">
            {{ $isEdit ? 'Edit Kurir' : 'Tambah Kurir Baru' }}
        </h1>
        <p class="text-crate-stone font-body mt-1 text-sm">
            {{ $isEdit ? 'Perbarui data kurir.' : 'Isi formulir berikut untuk mendaftarkan kurir baru ke sistem Cratefit.' }}
        </p>
    </div>

    <form action="{{ $isEdit ? url('/admin/kurir/' . $kurir['id']) : url('/admin/kurir') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- ============================================================
                 KOLOM KIRI: Form Utama
            ============================================================ --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- INFORMASI PRIBADI --}}
                <div class="card-wood rounded-2xl p-6">

                    <h2 class="font-display text-base text-crate-brown font-bold mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-crate-orange/10 flex items-center justify-center text-sm">👤</span>
                        Informasi Pribadi
                    </h2>

                    <div class="grid sm:grid-cols-2 gap-4">

                        {{-- Nama Lengkap --}}
                        <div class="sm:col-span-2">
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                Nama Lengkap <span class="text-red-400">*</span>
                            </label>
                            <input type="text"
                                name="nama"
                                value="{{ old('nama', $kurir['nama']) }}"
                                placeholder="Contoh: Budi Santoso"
                                required
                                class="w-full border border-crate-sand bg-white rounded-xl px-4 py-2.5
                                          text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                                          @error('nama') border-red-300 @enderror">
                            @error('nama')
                            <p class="mt-1 text-red-500 text-xs font-body">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                Email <span class="text-red-400">*</span>
                            </label>
                            <input type="email"
                                name="email"
                                value="{{ old('email', $kurir['email']) }}"
                                placeholder="kurir@cratefit.id"
                                required
                                class="w-full border border-crate-sand bg-white rounded-xl px-4 py-2.5
                                          text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                                          @error('email') border-red-300 @enderror">
                            @error('email')
                            <p class="mt-1 text-red-500 text-xs font-body">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- No. HP --}}
                        <div>
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                No. HP / WhatsApp <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-crate-stone text-xs font-body">
                                    +62
                                </span>
                                <input type="text"
                                    name="no_hp"
                                    value="{{ old('no_hp', $kurir['no_hp']) }}"
                                    placeholder="81234567890"
                                    required
                                    class="w-full border border-crate-sand bg-white rounded-xl pl-12 pr-4 py-2.5
                                              text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                                              @error('no_hp') border-red-300 @enderror">
                            </div>
                            @error('no_hp')
                            <p class="mt-1 text-red-500 text-xs font-body">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                Password <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Min. 8 karakter"
                                    {{ $isEdit ? '' : 'required' }}
                                    class="w-full border border-crate-sand bg-white rounded-xl px-4 py-2.5 pr-10
                                              text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                                              @error('password') border-red-300 @enderror">
                                <button type="button"
                                    onclick="togglePassword('password', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-crate-stone
                                               hover:text-crate-brown transition-colors text-xs">
                                    👁
                                </button>
                            </div>
                            @error('password')
                            <p class="mt-1 text-red-500 text-xs font-body">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                Konfirmasi Password <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    placeholder="Ulangi password"
                                    {{ $isEdit ? '' : 'required' }}
                                    class="w-full border border-crate-sand bg-white rounded-xl px-4 py-2.5 pr-10
                                              text-sm font-body text-crate-brown placeholder-crate-stone transition-all">
                                <button type="button"
                                    onclick="togglePassword('password_confirmation', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-crate-stone
                                               hover:text-crate-brown transition-colors text-xs">
                                    👁
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- INFORMASI KENDARAAN --}}
                <div class="card-wood rounded-2xl p-6">

                    <h2 class="font-display text-base text-crate-brown font-bold mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-crate-orange/10 flex items-center justify-center text-sm">🏍️</span>
                        Informasi Kendaraan
                    </h2>

                    <div class="grid sm:grid-cols-2 gap-4">

                        {{-- Jenis Kendaraan --}}
                        <div>
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                Jenis Kendaraan <span class="text-red-400">*</span>
                            </label>
                            <select name="kendaraan"
                                required
                                onchange="togglePlat(this.value)"
                                class="w-full border border-crate-sand bg-white rounded-xl px-4 py-2.5
                                           text-sm font-body text-crate-brown transition-all
                                           @error('kendaraan') border-red-300 @enderror">
                                <option value="" disabled {{ old('kendaraan') ? '' : 'selected' }}>
                                    — Pilih kendaraan —
                                </option>
                                <option value="Motor" {{ old('kendaraan', $kurir['kendaraan']) === 'Motor'  ? 'selected' : '' }}>🏍️ Motor</option>
                                <option value="Sepeda" {{ old('kendaraan', $kurir['kendaraan']) === 'Sepeda' ? 'selected' : '' }}>🚲 Sepeda</option>
                                <option value="Mobil" {{ old('kendaraan', $kurir['kendaraan']) === 'Mobil'  ? 'selected' : '' }}>🚗 Mobil</option>
                            </select>
                            @error('kendaraan')
                            <p class="mt-1 text-red-500 text-xs font-body">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor Plat --}}
                        <div id="wrap-plat">
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                Nomor Plat
                                <span class="text-crate-stone font-normal normal-case tracking-normal">
                                    (kosongkan jika sepeda)
                                </span>
                            </label>
                            <input type="text"
                                name="plat"
                                id="input-plat"
                                value="{{ old('plat', $kurir['plat']) }}"
                                placeholder="Contoh: BK 1234 AB"
                                class="w-full border border-crate-sand bg-white rounded-xl px-4 py-2.5
                                          text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                                          uppercase @error('plat') border-red-300 @enderror">
                            @error('plat')
                            <p class="mt-1 text-red-500 text-xs font-body">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- WILAYAH & PENUGASAN --}}
                <div class="card-wood rounded-2xl p-6">

                    <h2 class="font-display text-base text-crate-brown font-bold mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-crate-orange/10 flex items-center justify-center text-sm">📍</span>
                        Wilayah & Penugasan
                    </h2>

                    <div class="grid sm:grid-cols-2 gap-4">

                        {{-- Wilayah Tugas --}}
                        <div>
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                Wilayah Tugas <span class="text-red-400">*</span>
                            </label>
                            <select name="wilayah"
                                required
                                class="w-full border border-crate-sand bg-white rounded-xl px-4 py-2.5
                                           text-sm font-body text-crate-brown transition-all
                                           @error('wilayah') border-red-300 @enderror">
                                <option value="" disabled {{ old('wilayah') ? '' : 'selected' }}>
                                    — Pilih wilayah —
                                </option>
                                @php
                                $wilayahList = [
                                'Medan Kota', 'Medan Baru', 'Medan Timur', 'Medan Selatan',
                                'Medan Barat', 'Medan Deli', 'Medan Helvetia', 'Medan Johor',
                                'Medan Maimun', 'Medan Marelan', 'Medan Petisah', 'Medan Polonia',
                                'Medan Selayang', 'Medan Sunggal', 'Medan Tuntungan',
                                'Medan Area', 'Medan Amplas', 'Medan Belawan',
                                'Medan Denai', 'Medan Labuhan', 'Medan Perjuangan',
                                ];
                                @endphp
                                @foreach($wilayahList as $w)
                                <option value="{{ $w }}" {{ old('wilayah', $kurir['wilayah']) === $w ? 'selected' : '' }}>
                                    {{ $w }}
                                </option>
                                @endforeach
                            </select>
                            @error('wilayah')
                            <p class="mt-1 text-red-500 text-xs font-body">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Bergabung --}}
                        <div>
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                Tanggal Bergabung <span class="text-red-400">*</span>
                            </label>
                            <input type="date"
                                name="tanggal_bergabung"
                                value="{{ old('tanggal_bergabung', $kurir['tanggal_bergabung']) }}"
                                required
                                class="w-full border border-crate-sand bg-white rounded-xl px-4 py-2.5
                                          text-sm font-body text-crate-brown transition-all
                                          @error('tanggal_bergabung') border-red-300 @enderror">
                            @error('tanggal_bergabung')
                            <p class="mt-1 text-red-500 text-xs font-body">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- CATATAN INTERNAL --}}
                <div class="card-wood rounded-2xl p-6">

                    <h2 class="font-display text-base text-crate-brown font-bold mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-crate-orange/10 flex items-center justify-center text-sm">📝</span>
                        Catatan Internal
                        <span class="text-crate-stone text-xs font-body font-normal ml-1">(opsional)</span>
                    </h2>

                    <textarea name="catatan"
                        rows="4"
                        placeholder="Tambahkan catatan internal tentang kurir ini..."
                        class="w-full border border-crate-sand bg-crate-cream rounded-xl px-4 py-3
                 text-sm font-body text-crate-brown placeholder-crate-stone
                 resize-none transition-all">{{ old('catatan', $kurir['catatan']) }}</textarea>

                </div>

            </div>

            {{-- ============================================================
                 KOLOM KANAN: Sidebar
            ============================================================ --}}
            <div class="space-y-6">

                {{-- STATUS & PUBLIKASI --}}
                <div class="card-wood rounded-2xl p-6">
                    <h2 class="font-display text-base text-crate-brown font-bold mb-4">
                        ⚙️ Status Akun
                    </h2>

                    <div class="space-y-3">

                        {{-- Status --}}
                        <div>
                            <label class="block text-crate-brown text-xs font-body font-semibold uppercase tracking-wider mb-1.5">
                                Status Awal
                            </label>
                            <div class="flex gap-2">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="aktif"
                                        class="sr-only peer"
                                        {{ old('status', $kurir['status']) === 'aktif'    ? 'checked' : '' }}>
                                    <div class="text-center border border-crate-sand rounded-xl py-2.5 text-sm font-body
                                                font-semibold transition-all
                                                peer-checked:border-emerald-400 peer-checked:bg-emerald-50
                                                peer-checked:text-emerald-700 text-crate-stone hover:border-crate-stone">
                                        ● Aktif
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="nonaktif"
                                        class="sr-only peer"
                                        {{ old('status', $kurir['status']) === 'nonaktif' ? 'checked' : '' }}>
                                    <div class="text-center border border-crate-sand rounded-xl py-2.5 text-sm font-body
                                                font-semibold transition-all
                                                peer-checked:border-crate-stone/40 peer-checked:bg-crate-sand
                                                peer-checked:text-crate-stone text-crate-stone hover:border-crate-stone">
                                        ○ Nonaktif
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- FOTO PROFIL --}}
                <div class="card-wood rounded-2xl p-6">
                    <h2 class="font-display text-base text-crate-brown font-bold mb-4">
                        🖼️ Foto Profil
                        <span class="text-crate-stone text-xs font-body font-normal ml-1">(opsional)</span>
                    </h2>

                    {{-- Drop area --}}
                    <label for="foto"
                        class="group relative block border-2 border-dashed border-crate-sand
                                  rounded-xl p-6 cursor-pointer hover:border-crate-orange/40
                                  hover:bg-crate-cream/50 transition-all text-center">
                        <div id="foto-preview" class="hidden mb-3">
                            <img id="foto-img" src="" alt="Preview" class="w-20 h-20 rounded-full object-cover mx-auto">
                        </div>
                        <div id="foto-placeholder">
                            <div class="w-14 h-14 rounded-full bg-crate-sand/60 flex items-center justify-center
                                        mx-auto mb-3 text-2xl group-hover:bg-crate-orange/10 transition-colors">
                                📷
                            </div>
                            <p class="text-crate-brown text-xs font-body font-semibold">
                                Klik untuk unggah foto
                            </p>
                            <p class="text-crate-stone text-xs font-body mt-0.5">
                                JPG, PNG · Maks. 2 MB
                            </p>
                        </div>
                        <input type="file"
                            name="foto"
                            id="foto"
                            accept="image/jpeg,image/png"
                            class="sr-only"
                            onchange="previewFoto(this)">
                    </label>

                    <p class="text-crate-stone text-xs font-body mt-2 text-center">
                        Jika tidak diunggah, inisial nama akan digunakan sebagai avatar.
                    </p>
                </div>

                {{-- RINGKASAN --}}
                <div class="card-wood rounded-2xl p-6">
                    <h2 class="font-display text-base text-crate-brown font-bold mb-4">
                        📋 Ringkasan
                    </h2>
                    <div class="space-y-3 text-sm font-body">
                        <div class="flex justify-between items-center">
                            <span class="text-crate-stone">Bergabung</span>
                            <span class="text-crate-brown font-semibold" id="ringkasan-bergabung">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-crate-stone">Kendaraan</span>
                            <span class="text-crate-brown font-semibold" id="ringkasan-kendaraan">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-crate-stone">Wilayah</span>
                            <span class="text-crate-brown font-semibold" id="ringkasan-wilayah">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-crate-stone">Status</span>
                            <span id="ringkasan-status"
                                class="text-xs font-semibold px-2 py-0.5 rounded-full
                                         bg-emerald-50 text-emerald-700 border border-emerald-200">
                                ● Aktif
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-crate-sand mt-4 pt-4 space-y-2">
                        <button type="submit"
                            class="btn-primary w-full text-white font-body font-semibold
                                       py-3 rounded-xl text-sm shadow-md">
                            {{ $isEdit ? '💾 Simpan Perubahan' : '+ Simpan Kurir' }}
                        </button>
                        <a href="{{ url('/admin/kurir') }}"
                            class="block w-full text-center border border-crate-sand text-crate-stone
                                  font-body font-semibold py-2.5 rounded-xl text-sm hover:bg-crate-sand
                                  hover:text-crate-brown transition-colors">
                            Batal
                        </a>
                    </div>
                </div>

                {{-- PANDUAN --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <p class="text-amber-800 text-xs font-body font-semibold mb-2">💡 Panduan</p>
                    <ul class="space-y-1.5 text-xs font-body text-amber-700">
                        <li class="flex gap-2">
                            <span class="shrink-0">•</span>
                            Gunakan email resmi Cratefit (opsional, bisa email pribadi).
                        </li>
                        <li class="flex gap-2">
                            <span class="shrink-0">•</span>
                            Nomor plat wajib diisi untuk kendaraan bermotor (motor/mobil).
                        </li>
                        <li class="flex gap-2">
                            <span class="shrink-0">•</span>
                            Password dapat diubah kapan saja melalui halaman edit.
                        </li>
                        <li class="flex gap-2">
                            <span class="shrink-0">•</span>
                            Kurir yang nonaktif tidak akan muncul di daftar penugasan.
                        </li>
                    </ul>
                </div>

            </div>

        </div>

    </form>

</div>

@push('scripts')
<script>
    // ===== Toggle visibility password =====
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = '🙈';
        } else {
            input.type = 'password';
            btn.textContent = '👁';
        }
    }

    // ===== Preview foto =====
    function previewFoto(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('foto-img').src = e.target.result;
            document.getElementById('foto-preview').classList.remove('hidden');
            document.getElementById('foto-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }

    // ===== Toggle field plat berdasarkan kendaraan =====
    function togglePlat(val) {
        const wrap = document.getElementById('wrap-plat');
        const input = document.getElementById('input-plat');
        if (val === 'Sepeda') {
            input.value = '';
            input.disabled = true;
            input.placeholder = 'Tidak diperlukan';
            wrap.style.opacity = '0.45';
        } else {
            input.disabled = false;
            input.placeholder = 'Contoh: BK 1234 AB';
            wrap.style.opacity = '1';
        }
        updateRingkasan();
    }

    // ===== Update ringkasan sidebar secara live =====
    function updateRingkasan() {

        // Bergabung
        const tgl = document.querySelector('[name="tanggal_bergabung"]').value;
        const ringBergabung = document.getElementById('ringkasan-bergabung');
        if (tgl) {
            const d = new Date(tgl);
            ringBergabung.textContent = d.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        } else {
            ringBergabung.textContent = '—';
        }

        // Kendaraan
        const kend = document.querySelector('[name="kendaraan"]').value;
        document.getElementById('ringkasan-kendaraan').textContent = kend || '—';

        // Wilayah
        const wil = document.querySelector('[name="wilayah"]').value;
        document.getElementById('ringkasan-wilayah').textContent = wil || '—';

        // Status
        const statusEl = document.getElementById('ringkasan-status');
        const statusVal = document.querySelector('[name="status"]:checked')?.value ?? 'aktif';
        if (statusVal === 'aktif') {
            statusEl.textContent = '● Aktif';
            statusEl.className = 'text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200';
        } else {
            statusEl.textContent = '○ Nonaktif';
            statusEl.className = 'text-xs font-semibold px-2 py-0.5 rounded-full bg-crate-sand text-crate-stone border border-crate-stone/20';
        }
    }

    // Event listeners untuk ringkasan
    document.querySelector('[name="tanggal_bergabung"]').addEventListener('change', updateRingkasan);
    document.querySelector('[name="kendaraan"]').addEventListener('change', updateRingkasan);
    document.querySelector('[name="wilayah"]').addEventListener('change', updateRingkasan);
    document.querySelectorAll('[name="status"]').forEach(el => el.addEventListener('change', updateRingkasan));

    // Format input plat ke uppercase otomatis
    document.getElementById('input-plat').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Init ringkasan saat halaman load
    updateRingkasan();

    // Inisialisasi state plat jika ada old value
    @if(old('kendaraan', $kurir['kendaraan'] ?? '') === 'Sepeda')
    togglePlat('Sepeda');
    @endif
</script>
@endpush

@endsection