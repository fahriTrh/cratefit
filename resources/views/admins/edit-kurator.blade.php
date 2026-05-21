@extends('layouts.admin.app')
@section('title', 'Edit Kurator — ' . ($kurator['nama'] ?? 'Kurator'))

@section('content')

@php
    $kurator = $kurator ?? [
        'id'           => 1,
        'nama'         => 'Sari Indah Lestari',
        'email'        => 'sari@cratefit.id',
        'no_hp'        => '081234567890',
        'status'       => 'aktif',
        'spesialisasi' => ['Casual', 'Minimalis', 'Vintage'],
        'catatan'      => 'Kurator senior, hasil kurasi konsisten.',
    ];

    $allGaya = [
        'Casual', 'Minimalis', 'Streetwear', 'Vintage', 'Feminine',
        'Boho', 'Smart Casual', 'Eclectic', 'Formal', 'Athleisure',
    ];
@endphp

<div class="fade-in max-w-2xl mx-auto">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm font-body text-crate-stone mb-6">
        <a href="{{ url('/admin/kurator') }}"
           class="hover:text-crate-brown transition-colors">← Kelola Kurator</a>
        <span>/</span>
        <a href="{{ url('/admin/kurator/' . $kurator['id']) }}"
           class="hover:text-crate-brown transition-colors">{{ $kurator['nama'] }}</a>
        <span>/</span>
        <span class="text-crate-brown font-medium">Edit</span>
    </div>

    {{-- HEADER --}}
    <div class="mb-6">
        <p class="text-crate-orange font-script text-lg mb-0.5">Panel Admin</p>
        <h1 class="font-display text-3xl text-crate-brown font-bold">Edit Kurator</h1>
        <p class="text-crate-stone font-body mt-1 text-sm">
            Perbarui data, status, dan spesialisasi kurator.
        </p>
    </div>

    {{-- FORM --}}
    <form action="{{ url('/admin/kurator/' . $kurator['id']) }}"
          method="POST"
          class="space-y-5">
        @csrf
        @method('PUT')

        {{-- ===== DATA DIRI ===== --}}
        <div class="card-wood rounded-2xl p-6 space-y-4">
            <h2 class="font-display text-base text-crate-brown font-bold">👤 Data Diri</h2>

            {{-- Nama --}}
            <div>
                <label for="nama"
                       class="block text-xs font-body font-semibold text-crate-brown/70
                              uppercase tracking-wider mb-2">
                    Nama Lengkap <span class="text-red-400">*</span>
                </label>
                <input type="text"
                       id="nama"
                       name="nama"
                       required
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
                <label for="email"
                       class="block text-xs font-body font-semibold text-crate-brown/70
                              uppercase tracking-wider mb-2">
                    Email <span class="text-red-400">*</span>
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       required
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
                <label for="no_hp"
                       class="block text-xs font-body font-semibold text-crate-brown/70
                              uppercase tracking-wider mb-2">
                    Nomor HP
                </label>
                <input type="text"
                       id="no_hp"
                       name="no_hp"
                       value="{{ old('no_hp', $kurator['no_hp']) }}"
                       placeholder="08xxxxxxxxxx"
                       class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3
                              text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                              @error('no_hp') border-red-400 @enderror">
                @error('no_hp')
                    <p class="text-red-500 text-xs font-body mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Reset Password (opsional) --}}
            <div class="bg-crate-cream rounded-xl p-4 border border-crate-sand">
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox"
                           name="reset_password"
                           id="chk-reset"
                           value="1"
                           {{ old('reset_password') ? 'checked' : '' }}
                           class="accent-crate-orange w-4 h-4"
                           onchange="toggleResetPassword(this)">
                    <div>
                        <p class="text-sm font-body font-semibold text-crate-brown">
                            Reset Password Kurator
                        </p>
                        <p class="text-xs font-body text-crate-stone">
                            Centang untuk mengatur ulang password akun kurator ini.
                        </p>
                    </div>
                </label>
            </div>

            <div id="section-password"
                 class="{{ old('reset_password') ? '' : 'hidden' }} space-y-4">

                {{-- Password Baru --}}
                <div>
                    <label for="password"
                           class="block text-xs font-body font-semibold text-crate-brown/70
                                  uppercase tracking-wider mb-2">
                        Password Baru <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="Minimal 8 karakter"
                               class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3 pr-12
                                      text-sm font-body text-crate-brown placeholder-crate-stone transition-all
                                      @error('password') border-red-400 @enderror">
                        <button type="button"
                                onclick="togglePassword('password', 'icon-pw')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-crate-stone
                                       hover:text-crate-brown transition-colors text-sm select-none">
                            <span id="icon-pw">👁</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs font-body mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation"
                           class="block text-xs font-body font-semibold text-crate-brown/70
                                  uppercase tracking-wider mb-2">
                        Konfirmasi Password Baru <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Ulangi password baru"
                               class="w-full border border-crate-sand bg-white rounded-xl px-4 py-3 pr-12
                                      text-sm font-body text-crate-brown placeholder-crate-stone transition-all">
                        <button type="button"
                                onclick="togglePassword('password_confirmation', 'icon-pw-confirm')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-crate-stone
                                       hover:text-crate-brown transition-colors text-sm select-none">
                            <span id="icon-pw-confirm">👁</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- ===== STATUS AKUN ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-4">⚙️ Status Akun</h2>
            <div class="flex flex-col sm:flex-row gap-4">

                <label class="flex items-center gap-3 cursor-pointer group flex-1
                              border border-crate-sand rounded-xl p-4 transition-all
                              hover:border-crate-orange/40 hover:bg-crate-orange/5
                              has-[:checked]:border-crate-orange has-[:checked]:bg-crate-orange/5">
                    <input type="radio"
                           name="status"
                           value="aktif"
                           {{ old('status', $kurator['status']) === 'aktif' ? 'checked' : '' }}
                           class="accent-crate-orange w-4 h-4 shrink-0">
                    <div>
                        <p class="text-sm font-body font-semibold text-crate-brown">✅ Aktif</p>
                        <p class="text-xs font-body text-crate-stone mt-0.5">
                            Kurator dapat menerima dan mengerjakan tugas kurasi.
                        </p>
                    </div>
                </label>

                <label class="flex items-center gap-3 cursor-pointer group flex-1
                              border border-crate-sand rounded-xl p-4 transition-all
                              hover:border-crate-stone/40 hover:bg-crate-sand/40
                              has-[:checked]:border-crate-stone has-[:checked]:bg-crate-sand/40">
                    <input type="radio"
                           name="status"
                           value="nonaktif"
                           {{ old('status', $kurator['status']) === 'nonaktif' ? 'checked' : '' }}
                           class="accent-crate-orange w-4 h-4 shrink-0">
                    <div>
                        <p class="text-sm font-body font-semibold text-crate-brown">○ Nonaktif</p>
                        <p class="text-xs font-body text-crate-stone mt-0.5">
                            Kurator tidak mendapat tugas baru hingga diaktifkan kembali.
                        </p>
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
                <label class="cursor-pointer select-none">
                    <input type="checkbox"
                           name="spesialisasi[]"
                           value="{{ $gaya }}"
                           class="sr-only peer"
                           {{ in_array($gaya, old('spesialisasi', $kurator['spesialisasi'])) ? 'checked' : '' }}>
                    <span class="inline-block border border-crate-sand bg-white text-crate-brown
                                 text-sm font-body px-4 py-2 rounded-full transition-all
                                 peer-checked:bg-crate-orange peer-checked:text-white
                                 peer-checked:border-crate-orange hover:border-crate-orange/50">
                        {{ $gaya }}
                    </span>
                </label>
                @endforeach
            </div>
            @error('spesialisasi')
                <p class="text-red-500 text-xs font-body mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- ===== CATATAN INTERNAL ===== --}}
        <div class="card-wood rounded-2xl p-6">
            <h2 class="font-display text-base text-crate-brown font-bold mb-1">📝 Catatan Internal</h2>
            <p class="text-crate-stone text-xs font-body mb-4">
                Hanya terlihat oleh admin. Misal: jadwal, keahlian khusus, atau catatan performa.
            </p>
            <textarea id="catatan"
                      name="catatan"
                      rows="4"
                      placeholder="Catatan tentang kurator ini..."
                      class="w-full border border-crate-sand rounded-xl px-4 py-3 text-sm font-body
                             text-crate-brown bg-crate-cream placeholder-crate-stone resize-none
                             transition-all @error('catatan') border-red-400 @enderror">{{ old('catatan', $kurator['catatan']) }}</textarea>
            @error('catatan')
                <p class="text-red-500 text-xs font-body mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- ===== ACTIONS ===== --}}
        <div class="flex items-center justify-between pt-2 pb-6">
            <a href="{{ url('/admin/kurator/' . $kurator['id']) }}"
               class="text-crate-stone font-body text-sm hover:text-crate-brown transition-colors">
                ← Batal
            </a>
            <button type="submit"
                    class="btn-primary text-white font-body font-semibold px-8 py-3
                           rounded-2xl text-sm shadow-lg">
                💾 Simpan Perubahan
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
    // Toggle seksi reset password
    function toggleResetPassword(checkbox) {
        const section = document.getElementById('section-password');
        const inputs  = section.querySelectorAll('input');

        if (checkbox.checked) {
            section.classList.remove('hidden');
            // Aktifkan required agar validasi berjalan
            inputs.forEach(i => { if (i.name === 'password') i.required = true; });
        } else {
            section.classList.add('hidden');
            // Hapus required & kosongkan value
            inputs.forEach(i => { i.required = false; i.value = ''; });
        }
    }

    // Toggle visibilitas password
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type  = 'text';
            icon.textContent = '🙈';
        } else {
            input.type  = 'password';
            icon.textContent = '👁';
        }
    }

    // Pulihkan state reset-password saat ada old input (setelah validasi gagal)
    document.addEventListener('DOMContentLoaded', () => {
        const chk = document.getElementById('chk-reset');
        if (chk && chk.checked) {
            document.getElementById('section-password').classList.remove('hidden');
        }
    });
</script>
@endpush

@endsection