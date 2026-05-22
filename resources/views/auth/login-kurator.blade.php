<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit Kurator — Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&family=Caveat:wght@600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'crate-brown': '#3B1F0E',
                        'crate-dark': '#2A1508',
                        'crate-orange': '#C85A1A',
                        'crate-amber': '#E07A3A',
                        'crate-warm': '#F5A05A',
                        'crate-cream': '#FAF3E8',
                        'crate-sand': '#EDE0CC',
                        'crate-stone': '#C9B99A',
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'body': ['DM Sans', 'sans-serif'],
                        'script': ['Caveat', 'cursive'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #2A1508;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.06'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        .card-wood {
            background: white;
            border: 1px solid #EDE0CC;
            position: relative;
            overflow: hidden;
        }

        .card-wood::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3B1F0E, #C85A1A, #E07A3A, #3B1F0E);
        }

        .btn-primary {
            background: linear-gradient(135deg, #C85A1A, #E07A3A);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(200, 90, 26, 0.4);
        }

        .fade-in {
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        input:focus {
            outline: none;
            border-color: #C85A1A;
            box-shadow: 0 0 0 3px rgba(200, 90, 26, 0.15);
        }

        .dot-pattern {
            background-image: radial-gradient(circle, rgba(200, 90, 26, 0.15) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>

<body class="min-h-screen relative z-10 flex items-center justify-center p-4">

    {{-- Background pattern --}}
    <div class="fixed inset-0 dot-pattern opacity-40 z-0"></div>

    {{-- Card Login --}}
    <div class="card-wood rounded-3xl w-full max-w-md shadow-2xl fade-in relative z-10">

        {{-- Header --}}
        <div class="bg-crate-dark px-8 pt-10 pb-8 text-center rounded-t-3xl"
            style="background: linear-gradient(160deg, #2A1508 0%, #3B1F0E 100%);">

            {{-- Logo --}}
            <div class="w-20 h-20 rounded-full bg-crate-cream flex items-center justify-center
                        mx-auto mb-5 shadow-lg border-4 border-crate-orange/30 overflow-hidden">
                <img src="{{ asset('assets/imgs/logo-circle.png') }}"
                    class="w-full h-full object-cover"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                <span class="font-script text-3xl text-crate-orange hidden items-center justify-center w-full h-full">C</span>
            </div>

            <h1 class="font-script text-3xl text-crate-warm tracking-wide mb-1">Cratefit</h1>
            <p class="text-crate-stone text-xs font-body tracking-widest uppercase">Portal Kurator</p>
        </div>

        {{-- Form --}}
        <div class="px-8 py-8">

            <div class="mb-7 text-center">
                <h2 class="font-display text-2xl text-crate-brown font-bold">Selamat Datang</h2>
                <p class="text-crate-stone font-body text-sm mt-1">Masuk untuk mengelola Cratefit</p>
            </div>

            {{-- Error --}}
            @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl flex gap-3">
                <span class="text-lg shrink-0">⚠️</span>
                <div>
                    @foreach($errors->all() as $error)
                    <p class="text-red-700 font-body text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-2xl flex gap-3">
                <span class="text-lg shrink-0">⚠️</span>
                <p class="text-red-700 font-body text-sm">{{ session('error') }}</p>
            </div>
            @endif

            @if(session('success'))
            <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-2xl flex gap-3">
                <span class="text-lg shrink-0">✅</span>
                <p class="text-green-700 font-body text-sm">{{ session('success') }}</p>
            </div>
            @endif

            <form action="{{ route('kurator.login.post') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-xs font-body font-semibold text-crate-brown/70
                                  uppercase tracking-wider mb-1.5">
                        Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-crate-stone text-base">📧</span>
                        <input type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="kurator@cratefit.id"
                            class="w-full pl-10 pr-4 py-3 border border-crate-sand rounded-xl
                                      text-sm font-body text-crate-brown bg-crate-cream
                                      placeholder-crate-stone transition-all">
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label class="block text-xs font-body font-semibold text-crate-brown/70
                                  uppercase tracking-wider mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-crate-stone text-base">🔒</span>
                        <input type="password"
                            name="password"
                            id="password-input"
                            required
                            placeholder="••••••••"
                            class="w-full pl-10 pr-12 py-3 border border-crate-sand rounded-xl
                                      text-sm font-body text-crate-brown bg-crate-cream
                                      placeholder-crate-stone transition-all">
                        <button type="button"
                            onclick="togglePassword()"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-crate-stone
                                       hover:text-crate-brown transition-colors text-sm"
                            id="toggle-icon">
                            👁
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox"
                            name="remember"
                            class="w-4 h-4 rounded border-crate-sand accent-crate-orange">
                        <span class="text-crate-stone font-body text-sm">Ingat saya</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="btn-primary w-full text-white font-body font-semibold
                               py-3.5 rounded-2xl text-sm shadow-lg flex items-center justify-center gap-2">
                    Masuk ke Portal Kurator
                </button>

            </form>
        </div>

        {{-- Footer card --}}
        <div class="px-8 pb-7 text-center">
            <p class="text-crate-stone text-xs font-body">
                Bukan kurator?
                <a href="{{ url('/login') }}" class="text-crate-orange hover:underline">Login sebagai pelanggan</a>
            </p>
        </div>

    </div>

    <script>
        let shown = false;

        function togglePassword() {
            const input = document.getElementById('password-input');
            const icon = document.getElementById('toggle-icon');
            shown = !shown;
            input.type = shown ? 'text' : 'password';
            icon.textContent = shown ? '🙈' : '👁';
        }
    </script>

</body>

</html>