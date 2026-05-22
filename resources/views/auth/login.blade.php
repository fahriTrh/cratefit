<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit — Masuk</title>
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

        /* Background pattern */
        .bg-pattern {
            background-color: #FAF3E8;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(200, 90, 26, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 31, 14, 0.06) 0%, transparent 50%);
        }

        .dot-grid {
            background-image: radial-gradient(circle, rgba(200,90,26,0.12) 1px, transparent 1px);
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
            bottom: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200,90,26,0.2) 0%, transparent 70%);
        }

        /* Floating clothing icons */
        .float-icon {
            position: absolute;
            opacity: 0.08;
            font-size: 4rem;
            animation: floatAnim 8s ease-in-out infinite;
        }

        @keyframes floatAnim {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50%       { transform: translateY(-15px) rotate(5deg); }
        }

        /* Card */
        .login-card {
            background: white;
            border: 1px solid #EDE0CC;
            position: relative;
        }

        .login-card::before {
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

        .input-field::placeholder {
            color: #C9B99A;
        }

        /* Button */
        .btn-login {
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

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(200, 90, 26, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #C9B99A;
            font-size: 0.75rem;
            font-family: 'DM Sans', sans-serif;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #EDE0CC;
        }

        /* Animations */
        .fade-up {
            animation: fadeUp 0.6s ease both;
        }

        .fade-up:nth-child(2) { animation-delay: 0.1s; }
        .fade-up:nth-child(3) { animation-delay: 0.2s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Checkbox */
        input[type="checkbox"] {
            accent-color: #C85A1A;
            width: 16px;
            height: 16px;
            cursor: pointer;
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

        .alert-success {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            display: flex;
            gap: 0.625rem;
            align-items: flex-start;
        }
    </style>
</head>
<body class="min-h-screen bg-pattern">

    <div class="dot-grid fixed inset-0 opacity-30 pointer-events-none z-0"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4 lg:p-8">
        <div class="w-full max-w-5xl flex rounded-3xl shadow-2xl overflow-hidden fade-up">

            {{-- ===== LEFT PANEL ===== --}}
            <div class="left-panel hidden lg:flex flex-col justify-between w-[45%] p-12 relative z-10">

                {{-- Floating icons --}}
                <span class="float-icon text-white" style="top:15%; left:10%; animation-delay:0s;">👕</span>
                <span class="float-icon text-white" style="top:40%; right:8%; animation-delay:2s; font-size:3rem;">👗</span>
                <span class="float-icon text-white" style="bottom:25%; left:15%; animation-delay:4s; font-size:2.5rem;">🧥</span>

                {{-- Top: Logo --}}
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-12">
                        <div class="w-12 h-12 rounded-full bg-crate-cream flex items-center justify-center overflow-hidden border-2 border-crate-orange/30 shadow-lg">
                            <img src="{{ asset('assets/imgs/logo-circle.png') }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                            <span class="font-script text-2xl text-crate-orange hidden">C</span>
                        </div>
                        <span class="font-script text-3xl text-crate-warm">Cratefit</span>
                    </div>

                    <h1 class="font-display text-4xl text-white leading-tight mb-4">
                        Fashion thrift,<br>
                        <span class="text-crate-warm italic">dikurasi untukmu.</span>
                    </h1>
                    <p class="text-crate-stone font-body text-sm leading-relaxed">
                        Outfit unik, ramah di kantong, dan selalu sesuai selera kamu — dikirim langsung ke depan pintu.
                    </p>
                </div>

                {{-- Middle: Features --}}
                <div class="relative z-10 space-y-4">
                    @foreach([
                        ['✦', 'Dikurasi Sesuai Gaya', 'Tim stylist kami memilih khusus untukmu'],
                        ['✦', 'Harga Terjangkau', 'Thrift premium tanpa harus keluar banyak'],
                        ['✦', 'Sustainable Fashion', 'Berpakaian keren sambil jaga bumi'],
                    ] as $f)
                    <div class="flex items-start gap-3">
                        <span class="text-crate-orange mt-0.5 text-sm">{{ $f[0] }}</span>
                        <div>
                            <p class="font-body font-semibold text-white text-sm">{{ $f[1] }}</p>
                            <p class="font-body text-crate-stone text-xs mt-0.5">{{ $f[2] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Bottom: Tagline --}}
                <div class="relative z-10">
                    <p class="font-script text-xl text-crate-warm/70">
                        "Stylish tanpa ribet, hemat tanpa kehilangan style."
                    </p>
                </div>
            </div>

            {{-- ===== RIGHT PANEL (Form) ===== --}}
            <div class="login-card flex-1 rounded-3xl lg:rounded-l-none p-8 md:p-10">

                {{-- Mobile logo --}}
                <div class="flex lg:hidden items-center justify-center gap-2 mb-8">
                    <div class="w-10 h-10 rounded-full bg-crate-cream border-2 border-crate-orange/30 overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('assets/imgs/logo-circle.png') }}" class="w-full h-full object-cover"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                        <span class="font-script text-xl text-crate-orange hidden">C</span>
                    </div>
                    <span class="font-script text-2xl text-crate-brown">Cratefit</span>
                </div>

                {{-- Header --}}
                <div class="mb-8">
                    <h2 class="font-display text-3xl text-crate-brown font-bold mb-1.5">Selamat Datang</h2>
                    <p class="font-body text-crate-stone text-sm">Masuk ke akun Cratefit kamu</p>
                </div>

                {{-- Alerts --}}
                @if($errors->any())
                <div class="alert-error mb-5">
                    <span class="shrink-0 mt-0.5">⚠️</span>
                    <div class="flex-1">
                        @foreach($errors->all() as $error)
                        <p class="font-body text-red-700 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="alert-error mb-5">
                    <span class="shrink-0 mt-0.5">⚠️</span>
                    <p class="font-body text-red-700 text-sm">{{ session('error') }}</p>
                </div>
                @endif

                @if(session('success'))
                <div class="alert-success mb-5">
                    <span class="shrink-0 mt-0.5">✅</span>
                    <p class="font-body text-green-700 text-sm">{{ session('success') }}</p>
                </div>
                @endif

                {{-- Form --}}
                <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block font-body text-xs font-semibold text-crate-brown/60 uppercase tracking-wider mb-1.5">
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-crate-stone text-base pointer-events-none">
                                📧
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
                        <label class="block font-body text-xs font-semibold text-crate-brown/60 uppercase tracking-wider mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-crate-stone text-base pointer-events-none">
                                🔒
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
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-crate-stone hover:text-crate-brown transition-colors">
                                <span id="eye-icon">👁</span>
                            </button>
                        </div>
                    </div>

                    {{-- Remember & Lupa password --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" value="1">
                            <span class="font-body text-sm text-crate-stone">Ingat saya</span>
                        </label>
                        {{-- Placeholder lupa password --}}
                        {{-- <a href="{{ url('/lupa-password') }}" class="font-body text-sm text-crate-orange hover:underline">Lupa password?</a> --}}
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
                    <p class="font-body text-sm text-crate-stone">
                        Belum punya akun?
                        <a href="{{ url('/register') }}" class="text-crate-orange font-semibold hover:underline ml-1">
                            Daftar sekarang
                        </a>
                    </p>
                </div>

                {{-- Admin link --}}
                <div class="text-center mt-4">
                    <a href="{{ url('/admin/login') }}" class="font-body text-xs text-crate-stone/60 hover:text-crate-stone transition-colors">
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
            icon.textContent = shown ? '🙈' : '👁';
        }
    </script>

</body>
</html>