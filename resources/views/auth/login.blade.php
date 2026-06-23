<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit — Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Caveat:wght@600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'crate-primary': '#D8A98C',
                        'crate-accent':  '#E9D8CC',
                        'crate-bg':      '#F8F5F2',
                        'crate-card':    '#FFFFFF',
                        'crate-text':    '#2B2B2B',
                    },
                    fontFamily: {
                        'display': ['Plus Jakarta Sans', 'sans-serif'],
                        'body':    ['Plus Jakarta Sans', 'sans-serif'],
                        'script':  ['Caveat', 'cursive'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F5F2;
            color: #2B2B2B;
        }

        /* Subtle noise texture */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* Left panel */
        .left-panel {
            background: #2B2B2B;
            position: relative;
            overflow: hidden;
        }

        /* Warm glow orbs */
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -60px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(216,169,140,0.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .orb-top {
            position: absolute;
            top: -80px;
            left: -80px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(216,169,140,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Login card */
        .login-card {
            background: #FFFFFF;
            border-left: 1px solid #E9D8CC;
        }

        /* Accent line on top of card (mobile) */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: #D8A98C;
            border-radius: 9999px 9999px 0 0;
        }

        /* Input */
        .input-field {
            width: 100%;
            padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            border: 1.5px solid #E9D8CC;
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            color: #2B2B2B;
            background: #F8F5F2;
            transition: all 0.2s;
        }

        .input-field:focus {
            outline: none;
            border-color: #D8A98C;
            background: white;
            box-shadow: 0 0 0 3px rgba(216, 169, 140, 0.18);
        }

        .input-field::placeholder {
            color: #aaa;
        }

        /* Button */
        .btn-login {
            background: #D8A98C;
            color: white;
            width: 100%;
            padding: 0.875rem;
            border-radius: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            font-size: 0.9375rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(216, 169, 140, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(216, 169, 140, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #aaa;
            font-size: 0.75rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E9D8CC;
        }

        /* Fade up animation */
        .fade-up {
            animation: fadeUp 0.55s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Checkbox */
        input[type="checkbox"] {
            accent-color: #D8A98C;
            width: 15px;
            height: 15px;
            cursor: pointer;
        }
    </style>
</head>
<body class="min-h-screen relative">

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4 lg:p-8">
        <div class="w-full max-w-4xl flex rounded-3xl shadow-xl overflow-hidden fade-up">

            {{-- ===== LEFT PANEL ===== --}}
            <div class="left-panel hidden lg:flex flex-col justify-between w-[44%] p-10 relative">
                <div class="orb-top"></div>

                {{-- Top: Logo + Heading --}}
                <div class="relative z-10">
                    <div class="mb-10">
                        <div class="w-28 h-20 overflow-hidden flex items-center">
                            <img src="{{ asset('assets/imgs/cratefit-new-nobg.png') }}"
                                 class="w-full h-full object-contain brightness-0 invert opacity-90"
                                 alt="Cratefit">
                        </div>
                    </div>

                    <h1 class="font-display text-3xl font-bold text-white leading-snug mb-3">
                        Fashion thrift,<br>
                        <span class="text-crate-primary">dikurasi untukmu.</span>
                    </h1>
                    <p class="text-white/50 font-body text-sm leading-relaxed">
                        Outfit unik, ramah di kantong, selalu sesuai selera — dikirim langsung ke pintumu.
                    </p>
                </div>

                {{-- Middle: Features --}}
                <div class="relative z-10 space-y-5">
                    @foreach([
                        ['sparkles',   'Dikurasi Sesuai Gaya',    'Tim stylist kami memilih khusus untukmu'],
                        ['tag',        'Harga Terjangkau',         'Thrift premium tanpa harus keluar banyak'],
                        ['leaf',       'Sustainable Fashion',      'Berpakaian keren sambil jaga bumi'],
                    ] as $f)
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-crate-primary/15 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="{{ $f[0] }}" class="w-3.5 h-3.5 text-crate-primary"></i>
                        </div>
                        <div>
                            <p class="font-body font-semibold text-white text-sm">{{ $f[1] }}</p>
                            <p class="font-body text-white/40 text-xs mt-0.5">{{ $f[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Bottom: Tagline --}}
                <div class="relative z-10">
                    <p class="font-script text-lg text-crate-primary/60">
                        "Stylish tanpa ribet, hemat tanpa kehilangan style."
                    </p>
                </div>
            </div>

            {{-- ===== RIGHT PANEL (Form) ===== --}}
            <div class="login-card relative flex-1 rounded-3xl lg:rounded-l-none p-8 md:p-10">

                {{-- Mobile logo --}}
                <div class="flex lg:hidden items-center justify-center mb-8">
                    <div class="w-28 h-16 overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('assets/imgs/cratefit-new-nobg.png') }}"
                             class="w-full h-full object-contain"
                             alt="Cratefit">
                    </div>
                </div>

                {{-- Header --}}
                <div class="mb-7">
                    <h2 class="font-display text-2xl font-bold text-crate-text mb-1">Selamat datang</h2>
                    <p class="font-body text-gray-400 text-sm">Masuk ke akun Cratefit kamu</p>
                </div>

                {{-- Alerts --}}
                @if($errors->any())
                <div class="mb-5 p-3.5 bg-red-50 border border-red-100 rounded-xl flex gap-2.5 items-start">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-red-400 shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        @foreach($errors->all() as $error)
                        <p class="font-body text-red-600 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-5 p-3.5 bg-red-50 border border-red-100 rounded-xl flex gap-2.5 items-start">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-red-400 shrink-0 mt-0.5"></i>
                    <p class="font-body text-red-600 text-sm">{{ session('error') }}</p>
                </div>
                @endif

                @if(session('success'))
                <div class="mb-5 p-3.5 bg-green-50 border border-green-100 rounded-xl flex gap-2.5 items-start">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-500 shrink-0 mt-0.5"></i>
                    <p class="font-body text-green-700 text-sm">{{ session('success') }}</p>
                </div>
                @endif

                {{-- Form --}}
                <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-text/50 uppercase tracking-wider mb-1.5">
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                                <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                            </span>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   placeholder="kamu@email.com"
                                   class="input-field">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-text/50 uppercase tracking-wider mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                                <i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
                            </span>
                            <input type="password"
                                   name="password"
                                   id="password-field"
                                   required
                                   placeholder="••••••••"
                                   class="input-field pr-12">
                            <button type="button"
                                    id="toggle-btn"
                                    onclick="togglePassword()"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-crate-text transition-colors">
                                <i data-lucide="eye" id="eye-icon" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" value="1">
                            <span class="font-body text-sm text-gray-400">Ingat saya</span>
                        </label>
                        {{-- <a href="{{ url('/lupa-password') }}" class="font-body text-sm text-crate-primary hover:underline">Lupa password?</a> --}}
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-login">
                        Masuk ke Cratefit
                    </button>
                </form>

                {{-- Divider --}}
                <div class="divider my-6">atau</div>

                {{-- Register link --}}
                <div class="text-center">
                    <p class="font-body text-sm text-gray-400">
                        Belum punya akun?
                        <a href="{{ url('/register') }}" class="text-crate-primary font-semibold hover:underline ml-1">
                            Daftar sekarang
                        </a>
                    </p>
                </div>

                {{-- Admin link --}}
                <div class="text-center mt-4">
                    <a href="{{ url('/admin/login') }}" class="font-body text-xs text-gray-300 hover:text-gray-400 transition-colors">
                        Masuk sebagai Admin / Kurator
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        let shown = false;
        function togglePassword() {
            const field = document.getElementById('password-field');
            const icon  = document.getElementById('eye-icon');
            shown = !shown;
            field.type = shown ? 'text' : 'password';
            icon.setAttribute('data-lucide', shown ? 'eye-off' : 'eye');
            lucide.createIcons();
        }
    </script>
    <script>lucide.createIcons();</script>
</body>
</html>