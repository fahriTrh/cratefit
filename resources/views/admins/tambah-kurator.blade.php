@extends('layouts.admin.app')
@section('title', isset($kurator) ? 'Edit Kurator — ' . $kurator['nama'] : 'Tambah Kurator')

@section('content')

@php
    // Mode edit jika $kurator ada, mode tambah jika tidak
    $isEdit  = isset($kurator);
    $kurator = $kurator ?? [
        'id'           => null,
        'nama'         => '',
        'email'        => '',
        'no_hp'        => '',
        'status'       => 'aktif',
        'spesialisasi' => [],
        'catatan'      => '',
    ];

    $allGaya = [
        'Casual', 'Minimalis', 'Streetwear', 'Vintage', 'Feminine',
        'Boho', 'Smart Casual', 'Eclectic', 'Formal', 'Athleisure',
    ];
@endphp

<div class="fade-in max-w-2xl mx-auto">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm font-body text-crate-stone mb-6">
        <a href="{{ url('/admin/kurator') }}" class="hover:text-crate-brown transition-colors">← Kelola Kurator</a>
        <span>/</span>
        <span class="text-crate-brown font-medium">
            {{ $isEdit ? 'Edit: ' . $kurator['nama'] : 'Tambah Kurator Baru' }}
        </span>
    </div>

    {{-- HEADER --}}
    <div class="mb-6">
        <p class="text-crate-orange font-script text-lg mb-0.5">Panel Admin</p>
        <h1 class="font-display text-3xl text-crate-brown font-bold">
            {{ $isEdit ? 'Edit Kurator' : 'Tambah Kurator' }}
        </h1>
        <p class="text-crate-stone font-body mt-1 text-sm">
            {{ $isEdit ? 'Perbarui data dan spesialisasi kurator.' : 'Daftarkan kurator baru ke dalam sistem Cratefit.' }}
        </p>
    </div>

    {{-- FORM --}}
    <form action="{{ $isEdit
                        ? url('/admin/kurator/' . $kurator['id'])
                        : url('/admin/kurator') }}"
          method="POST"
          class="space-y-5">
        @csrf
        @if($isEdit) @method('PUT') @endif

        {{-- ===== DATA DIRI ===== --}}
        <div class="card-wood rounded-2xl p-6 space-y-4">
            <h2 class="font-display text-base text-crate-brown font-bold">👤 Data Diri</h2>

            {{-- Nama --}}
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                    Nama Lengkap <span class="text-red-400">*</span>
                </label>
                <input type="text" name="nama" required
                       value="{{ old('nama', $kurator['nama']) }}"
                       placeholder="Contoh: Sari Indah Lestari"
                       class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3
                              text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                              @error('nama') border-red-400 @enderror">
                @error('nama')
                <p class="text-red-500 text-xs font-body mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                    Email <span class="text-red-400">*</span>
                </label>
                <input type="email" name="email" required
                       value="{{ old('email', $kurator['email']) }}"
                       placeholder="nama@cratefit.id"
                       class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3
                              text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                              @error('email') border-red-400 @enderror">
                @error('email')
                <p class="text-red-500 text-xs font-body mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- No HP --}}
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                    Nomor HP
                </label>
                <input type="text" name="no_hp"
                       value="{{ old('no_hp', $kurator['no_hp']) }}"
                       placeholder="08xxxxxxxxxx"
                       class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3
                              text-sm font-body text-crate-brown placeholder-crate-stone transition-all">
            </div>

            {{-- Password (hanya untuk tambah baru, atau jika ingin reset) --}}
            @if(!$isEdit)
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                    Password <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <input type="password" name="password" id="input-password" required
                           placeholder="Minimal 8 karakter"
                           class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3 pr-12
                                  text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                                  @error('password') border-red-400 @enderror">
                    <button type="button" onclick="togglePassword()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-crate-stone hover:text-crate-brown
                                   transition-colors text-sm select-none">
                        👁
                    </button>
                </div>
                @error('password')
                <p class="text-red-500 text-xs font-body mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                    Konfirmasi Password <span class="text-red-400">*</span>
                </label>
                <input type="password" name="password_confirmation" required
                       placeholder="Ulangi password"
                       class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3
                              text-sm font-body text-crate-brown placeholder-crate-stone transition-all">
            </div>
            @else
            {{-- Edit: opsi reset password --}}
            <div class="bg-crate-cream rounded-xl p-4 border border-crate-sand">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="reset_password" id="chk-reset"
                           class="accent-crate-orange w-4 h-4"
                           onchange="document.getElementById('section-password').classList.toggle('hidden')">
                    <span class="text-sm font-body text-crate-brown">Reset Password Kurator</span>
                </label>
            </div>
            <div id="section-password" class="hidden space-y-4">
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                        Password Baru <span class="text-red-400">*</span>
                    </label>
                    <input type="password" name="password"
                           placeholder="Minimal 8 karakter"
                           class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3
                                  text-sm font-body text-crate-brown placeholder-crate-stone transition-all">
                </div>
                <div>
                    <label class="block text-xs font-body font-semibold text-crate-brown/70 uppercase tracking-wider mb-2">
                        Konfirmasi Password Baru <span class="text-red-400">*</span>
                    </label>
                    <input type="password" name="password_confirmation"
                           placeholder="Ulangi password baru"
                           class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3
                                  text-sm font-body text-crate-brown placeholder-crate-stone transition-all">
                </div>
            </div>
            @endif

        </div>

        {{-- ===== STATUS ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-4">⚙️ Status Akun</h2>
            <div class="flex items-center gap-4">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" name="status" value="aktif"
                           {{ old('status', $kurator['status']) === 'aktif' ? 'checked' : '' }}
                           class="accent-crate-orange w-4 h-4">
                    <div>
                        <p class="text-sm font-body font-semibold text-crate-brown group-hover:text-crate-orange transition-colors">
                            Aktif
                        </p>
                        <p class="text-xs font-body text-crate-stone">Kurator dapat menerima tugas kurasi</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" name="status" value="nonaktif"
                           {{ old('status', $kurator['status']) === 'nonaktif' ? 'checked' : '' }}
                           class="accent-crate-orange w-4 h-4">
                    <div>
                        <p class="text-sm font-body font-semibold text-crate-brown group-hover:text-crate-orange transition-colors">
                            Nonaktif
                        </p>
                        <p class="text-xs font-body text-crate-stone">Kurator tidak mendapat tugas baru</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- ===== SPESIALISASI GAYA ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-1">🎨 Spesialisasi Gaya</h2>
            <p class="text-crate-stone text-xs font-body mb-4">
                Pilih gaya fashion yang dikuasai kurator ini (bisa lebih dari satu).
            </p>
            <div class="flex flex-wrap gap-2">
                @foreach($allGaya as $gaya)
                <label class="cursor-pointer">
                    <input type="checkbox" name="spesialisasi[]" value="{{ $gaya }}"
                           class="sr-only peer"
                           {{ in_array($gaya, old('spesialisasi', $kurator['spesialisasi'])) ? 'checked' : '' }}>
                    <span class="tag-btn inline-block border border-crate-sand bg-white text-crate-brown
                                 text-sm font-body px-4 py-2 rounded-full transition-all select-none
                                 peer-checked:bg-crate-orange peer-checked:text-white peer-checked:border-crate-orange">
                        {{ $gaya }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- ===== CATATAN INTERNAL ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-1">📝 Catatan Internal</h2>
            <p class="text-crate-stone text-xs font-body mb-4">
                Hanya terlihat oleh admin. Misal: jadwal, keahlian khusus, atau catatan performa.
            </p>
            <textarea name="catatan" rows="3"
                      placeholder="Catatan tentang kurator ini..."
                      class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body
                             text-crate-brown bg-crate-cream placeholder-crate-stone resize-none transition-all">{{ old('catatan', $kurator['catatan']) }}</textarea>
        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-between pt-2 pb-6">
            <a href="{{ url('/admin/kurator') }}"
               class="text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
                ← Batal
            </a>
            <button type="submit"
                    class="btn-primary text-white font-body font-semibold px-8 py-3 rounded-2xl text-sm shadow-lg">
                {{ $isEdit ? '💾 Simpan Perubahan' : '✅ Tambah Kurator' }}
            </button>
        </div>

    </form>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('input-password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

@endsection