<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit — Daftar Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&family=Caveat:wght@600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'crate-brown':  '#3B1F0E',
                        'crate-dark':   '#2A1508',
                        'crate-orange': '#C85A1A',
                        'crate-amber':  '#E07A3A',
                        'crate-warm':   '#F5A05A',
                        'crate-cream':  '#FAF3E8',
                        'crate-sand':   '#EDE0CC',
                        'crate-stone':  '#C9B99A',
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'body':    ['DM Sans', 'sans-serif'],
                        'script':  ['Caveat', 'cursive'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #FAF3E8;
        }

        .bg-pattern {
            background-color: #FAF3E8;
            background-image:
                radial-gradient(circle at 15% 30%, rgba(200, 90, 26, 0.07) 0%, transparent 50%),
                radial-gradient(circle at 85% 70%, rgba(59, 31, 14, 0.05) 0%, transparent 50%);
        }

        .dot-grid {
            background-image: radial-gradient(circle, rgba(200,90,26,0.10) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        /* Left panel */
        .left-panel {
            background: linear-gradient(160deg, #2A1508 0%, #3B1F0E 60%, #5C2E14 100%);
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.07'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            top: -60px;
            left: -60px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200,90,26,0.18) 0%, transparent 70%);
        }

        .float-icon {
            position: absolute;
            opacity: 0.07;
            animation: floatAnim 9s ease-in-out infinite;
        }

        @keyframes floatAnim {
            0%, 100% { transform: translateY(0px) rotate(-3deg); }
            50%       { transform: translateY(-14px) rotate(3deg); }
        }

        /* Steps */
        .step-dot {
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .step-dot.done    { background: #3B1F0E; color: #FAF3E8; }
        .step-dot.active  { background: #C85A1A; color: white; box-shadow: 0 0 0 4px rgba(200,90,26,0.2); }
        .step-dot.pending { background: #EDE0CC; color: #9B7B5A; }

        /* Card */
        .reg-card {
            background: white;
            border: 1px solid #EDE0CC;
            position: relative;
        }

        .reg-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3B1F0E, #C85A1A, #E07A3A, #C85A1A, #3B1F0E);
            border-radius: 9999px 9999px 0 0;
        }

        /* Input */
        .input-field {
            width: 100%;
            padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            border: 1.5px solid #EDE0CC;
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            color: #3B1F0E;
            background: #FAF3E8;
            transition: all 0.2s;
        }

        .input-field:focus {
            outline: none;
            border-color: #C85A1A;
            background: white;
            box-shadow: 0 0 0 3px rgba(200, 90, 26, 0.12);
        }

        .input-field::placeholder { color: #C9B99A; }

        .input-field.is-error {
            border-color: #F87171;
            background: #FFF5F5;
        }

        .input-no-icon {
            padding-left: 0.875rem;
        }

        /* Password strength */
        .strength-bar {
            height: 4px;
            border-radius: 9999px;
            transition: all 0.3s;
        }

        /* Btn */
        .btn-primary {
            background: linear-gradient(135deg, #C85A1A 0%, #E07A3A 100%);
            color: white;
            width: 100%;
            padding: 0.875rem;
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.9375rem;
            border: none;
            cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 4px 16px rgba(200, 90, 26, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(200, 90, 26, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert */
        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            display: flex;
            gap: 0.625rem;
            align-items: flex-start;
        }

        /* Section transition */
        .form-section {
            transition: all 0.35s ease;
        }

        /* Checkbox */
        input[type="checkbox"] {
            accent-color: #C85A1A;
            width: 16px; height: 16px;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* Animations */
        .fade-up {
            animation: fadeUp 0.55s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Field error message */
        .field-error {
            color: #EF4444;
            font-size: 0.75rem;
            font-family: 'DM Sans', sans-serif;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Select */
        select.input-field {
            padding-left: 0.875rem;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23C9B99A' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 2.5rem;
        }
    </style>
</head>
<body class="min-h-screen bg-pattern">

    <div class="dot-grid fixed inset-0 opacity-25 pointer-events-none z-0"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4 lg:p-8 py-10">
        <div class="w-full max-w-5xl flex rounded-3xl shadow-2xl overflow-hidden fade-up">

            {{-- ===== LEFT PANEL ===== --}}
            <div class="left-panel hidden lg:flex flex-col justify-between w-[42%] p-10 relative z-10">

                {{-- Floating icons --}}
                <span class="float-icon text-white text-6xl" style="top:10%;left:5%;animation-delay:0s">👕</span>
                <span class="float-icon text-white text-5xl" style="top:35%;right:5%;animation-delay:2.5s">🧥</span>
                <span class="float-icon text-white text-4xl" style="bottom:30%;left:12%;animation-delay:5s">👖</span>
                <span class="float-icon text-white text-3xl" style="bottom:10%;right:15%;animation-delay:1.5s">✨</span>

                {{-- Logo --}}
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-11 h-11 rounded-full bg-crate-cream flex items-center justify-center overflow-hidden border-2 border-crate-orange/30 shadow-lg">
                            <img src="{{ asset('assets/imgs/logo-circle.png') }}" class="w-full h-full object-cover"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                            <span class="font-script text-xl text-crate-orange hidden">C</span>
                        </div>
                        <span class="font-script text-3xl text-crate-warm">Cratefit</span>
                    </div>

                    <h1 class="font-display text-3xl text-white leading-tight mb-3">
                        Mulai perjalanan<br>
                        <span class="text-crate-warm italic">style-mu di sini.</span>
                    </h1>
                    <p class="text-crate-stone font-body text-sm leading-relaxed">
                        Daftar sekarang dan biarkan tim kurator kami memilihkan outfit thrift terbaik sesuai gaya kamu.
                    </p>
                </div>

                {{-- Steps preview --}}
                <div class="relative z-10 space-y-4">
                    <p class="text-crate-stone/60 text-xs font-body font-semibold uppercase tracking-widest mb-2">
                        Proses Pendaftaran
                    </p>
                    @foreach([
                        ['1', 'Buat Akun',           'Nama, email & password'],
                        ['2', 'Preferensi Fashion',  'Gaya, ukuran & warna favorit'],
                        ['3', 'Alamat Pengiriman',   'Tujuan pengiriman box'],
                        ['4', 'Pilih Paket',         'Starter, Style, atau Premium'],
                    ] as $s)
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-white/10 border border-white/20 flex items-center justify-center
                                    text-crate-warm font-body font-bold text-xs shrink-0">
                            {{ $s[0] }}
                        </div>
                        <div>
                            <p class="text-white font-body font-semibold text-sm">{{ $s[1] }}</p>
                            <p class="text-crate-stone text-xs font-body">{{ $s[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Tagline --}}
                <div class="relative z-10">
                    <p class="font-script text-xl text-crate-warm/60">
                        "Stylish tanpa ribet, hemat tanpa kehilangan style."
                    </p>
                </div>
            </div>

            {{-- ===== RIGHT PANEL ===== --}}
            <div class="reg-card flex-1 rounded-3xl lg:rounded-l-none p-7 md:p-9 overflow-y-auto max-h-screen lg:max-h-[90vh]">

                {{-- Mobile logo --}}
                <div class="flex lg:hidden items-center justify-center gap-2 mb-6">
                    <div class="w-9 h-9 rounded-full bg-crate-cream border-2 border-crate-orange/30 overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('assets/imgs/logo-circle.png') }}" class="w-full h-full object-cover"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                        <span class="font-script text-lg text-crate-orange hidden">C</span>
                    </div>
                    <span class="font-script text-2xl text-crate-brown">Cratefit</span>
                </div>

                {{-- Header --}}
                <div class="mb-6">
                    <h2 class="font-display text-2xl text-crate-brown font-bold mb-1">Buat Akun Baru</h2>
                    <p class="font-body text-crate-stone text-sm">Langkah 1 dari 4 — Data akun dasar kamu</p>
                </div>

                {{-- Step indicator --}}
                <div class="flex items-center gap-1.5 mb-7">
                    @foreach(['Akun','Preferensi','Alamat','Paket'] as $i => $stepLabel)
                    <div class="flex items-center gap-1.5 {{ $i < 3 ? 'flex-1' : '' }}">
                        <div class="step-dot {{ $i === 0 ? 'active' : 'pending' }}">
                            {{ $i + 1 }}
                        </div>
                        <span class="text-xs font-body hidden sm:block
                                     {{ $i === 0 ? 'text-crate-orange font-semibold' : 'text-crate-stone' }}">
                            {{ $stepLabel }}
                        </span>
                        @if($i < 3)
                        <div class="flex-1 h-px bg-crate-sand mx-1"></div>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{-- Alerts --}}
                @if($errors->any())
                <div class="alert-error mb-5">
                    <span class="shrink-0 text-lg">⚠️</span>
                    <div>
                        @foreach($errors->all() as $error)
                        <p class="font-body text-red-700 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="alert-error mb-5">
                    <span class="shrink-0 text-lg">⚠️</span>
                    <p class="font-body text-red-700 text-sm">{{ session('error') }}</p>
                </div>
                @endif

                {{-- FORM --}}
                <form action="{{ url('/register') }}" method="POST" class="space-y-4" id="register-form">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-brown/60 uppercase tracking-wider mb-1.5">
                            Nama Lengkap <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-base pointer-events-none">👤</span>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required autofocus
                                   placeholder="Nama lengkapmu"
                                   class="input-field @error('name') is-error @enderror">
                        </div>
                        @error('name')
                        <p class="field-error"><span>⚠</span> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-brown/60 uppercase tracking-wider mb-1.5">
                            Nomor HP <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-base pointer-events-none">📱</span>
                            <input type="text"
                                   name="no_hp"
                                   value="{{ old('no_hp') }}"
                                   required
                                   placeholder="08xxxxxxxxxx"
                                   inputmode="numeric"
                                   class="input-field @error('no_hp') is-error @enderror">
                        </div>
                        @error('no_hp')
                        <p class="field-error"><span>⚠</span> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-brown/60 uppercase tracking-wider mb-1.5">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-base pointer-events-none">📧</span>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   placeholder="kamu@email.com"
                                   class="input-field @error('email') is-error @enderror">
                        </div>
                        @error('email')
                        <p class="field-error"><span>⚠</span> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-brown/60 uppercase tracking-wider mb-1.5">
                            Password <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-base pointer-events-none">🔒</span>
                            <input type="password"
                                   name="password"
                                   id="pw-field"
                                   required
                                   placeholder="Minimal 8 karakter"
                                   oninput="checkStrength(this.value)"
                                   class="input-field pr-12 @error('password') is-error @enderror">
                            <button type="button" onclick="togglePw('pw-field', 'eye1')"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-crate-stone hover:text-crate-brown transition-colors">
                                <span id="eye1">👁</span>
                            </button>
                        </div>
                        {{-- Strength bar --}}
                        <div class="mt-2 flex gap-1" id="strength-bars">
                            <div class="strength-bar flex-1 bg-crate-sand" id="bar1"></div>
                            <div class="strength-bar flex-1 bg-crate-sand" id="bar2"></div>
                            <div class="strength-bar flex-1 bg-crate-sand" id="bar3"></div>
                            <div class="strength-bar flex-1 bg-crate-sand" id="bar4"></div>
                        </div>
                        <p id="strength-label" class="text-xs font-body text-crate-stone mt-1"></p>
                        @error('password')
                        <p class="field-error"><span>⚠</span> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-brown/60 uppercase tracking-wider mb-1.5">
                            Konfirmasi Password <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-base pointer-events-none">🔐</span>
                            <input type="password"
                                   name="password_confirmation"
                                   id="pw-confirm"
                                   required
                                   placeholder="Ulangi password"
                                   oninput="checkMatch()"
                                   class="input-field pr-12">
                            <button type="button" onclick="togglePw('pw-confirm', 'eye2')"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-crate-stone hover:text-crate-brown transition-colors">
                                <span id="eye2">👁</span>
                            </button>
                        </div>
                        <p id="match-label" class="text-xs font-body mt-1"></p>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-brown/60 uppercase tracking-wider mb-1.5">
                            Jenis Kelamin <span class="text-red-400">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach([['pria','👨 Pria'], ['wanita','👩 Wanita']] as [$val, $lbl])
                            <label class="cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="{{ $val }}" class="sr-only peer"
                                       {{ old('jenis_kelamin') === $val ? 'checked' : '' }} required>
                                <div class="flex items-center justify-center gap-2 border-2 border-crate-sand
                                            rounded-xl py-2.5 text-sm font-body font-semibold text-crate-stone
                                            transition-all cursor-pointer select-none
                                            peer-checked:border-crate-orange peer-checked:text-crate-orange
                                            peer-checked:bg-orange-50 hover:border-crate-stone">
                                    {{ $lbl }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('jenis_kelamin')
                        <p class="field-error"><span>⚠</span> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-brown/60 uppercase tracking-wider mb-1.5">
                            Tanggal Lahir
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-base pointer-events-none">🗓️</span>
                            <input type="date"
                                   name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir') }}"
                                   max="{{ date('Y-m-d', strtotime('-10 years')) }}"
                                   class="input-field @error('tanggal_lahir') is-error @enderror">
                        </div>
                        @error('tanggal_lahir')
                        <p class="field-error"><span>⚠</span> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Syarat & Ketentuan --}}
                    <div class="pt-1">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="setuju" id="chk-setuju" required
                                   class="mt-0.5"
                                   onchange="updateSubmit()">
                            <span class="text-sm font-body text-crate-stone leading-relaxed">
                                Saya menyetujui
                                <a href="#" class="text-crate-orange font-semibold hover:underline">Syarat & Ketentuan</a>
                                serta
                                <a href="#" class="text-crate-orange font-semibold hover:underline">Kebijakan Privasi</a>
                                Cratefit.
                            </span>
                        </label>
                        @error('setuju')
                        <p class="field-error mt-1"><span>⚠</span> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="btn-submit" class="btn-primary" disabled>
                        Buat Akun & Lanjut →
                    </button>

                </form>

                {{-- Login link --}}
                <div class="text-center mt-5">
                    <p class="font-body text-sm text-crate-stone">
                        Sudah punya akun?
                        <a href="{{ url('/login') }}" class="text-crate-orange font-semibold hover:underline ml-1">
                            Masuk di sini
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script>
        // ===== TOGGLE PASSWORD =====
        const shown = {};
        function togglePw(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon  = document.getElementById(iconId);
            shown[fieldId] = !shown[fieldId];
            field.type     = shown[fieldId] ? 'text' : 'password';
            icon.textContent = shown[fieldId] ? '🙈' : '👁';
        }

        // ===== PASSWORD STRENGTH =====
        function checkStrength(val) {
            const bars   = ['bar1','bar2','bar3','bar4'];
            const label  = document.getElementById('strength-label');
            const colors = ['#EF4444','#F97316','#EAB308','#22C55E'];
            const labels = ['Terlalu lemah','Lemah','Cukup kuat','Kuat 💪'];

            let score = 0;
            if (val.length >= 8)                       score++;
            if (/[A-Z]/.test(val))                     score++;
            if (/[0-9]/.test(val))                     score++;
            if (/[^A-Za-z0-9]/.test(val))              score++;

            bars.forEach((id, i) => {
                document.getElementById(id).style.background =
                    i < score ? colors[score - 1] : '#EDE0CC';
            });

            label.textContent = val.length === 0 ? '' : labels[Math.max(0, score - 1)];
            label.style.color = val.length === 0 ? '' : colors[Math.max(0, score - 1)];
        }

        // ===== CONFIRM MATCH =====
        function checkMatch() {
            const pw      = document.getElementById('pw-field').value;
            const confirm = document.getElementById('pw-confirm').value;
            const label   = document.getElementById('match-label');
            if (!confirm) { label.textContent = ''; return; }
            if (pw === confirm) {
                label.textContent = '✓ Password cocok';
                label.style.color = '#22C55E';
            } else {
                label.textContent = '✗ Password tidak cocok';
                label.style.color = '#EF4444';
            }
        }

        // ===== ENABLE SUBMIT =====
        function updateSubmit() {
            const chk = document.getElementById('chk-setuju');
            const btn = document.getElementById('btn-submit');
            btn.disabled = !chk.checked;
        }

        // ===== AUTO-FORMAT NO HP =====
        document.querySelector('input[name="no_hp"]').addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    </script>

</body>
</html>