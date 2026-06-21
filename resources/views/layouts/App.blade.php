<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit — @yield('title', 'Stylish tanpa ribet')</title>
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
            background-color: #FAF3E8;
        }

        /* Texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        .sidebar-nav a {
            transition: all 0.2s;
        }

        .sidebar-nav a:hover {
            transform: translateX(4px);
        }

        /* Step indicator active */
        .step-active {
            background: #C85A1A;
            color: white;
        }

        .step-done {
            background: #3B1F0E;
            color: #FAF3E8;
        }

        .step-todo {
            background: #EDE0CC;
            color: #9B7B5A;
        }

        /* Tag toggle */
        .tag-btn {
            transition: all 0.18s;
            cursor: pointer;
        }

        .tag-btn.selected {
            background: #C85A1A;
            color: white;
            border-color: #C85A1A;
        }

        /* Color swatch */
        .swatch-btn {
            transition: transform 0.18s, box-shadow 0.18s;
        }

        .swatch-btn.selected {
            transform: scale(1.15);
            box-shadow: 0 0 0 3px #C85A1A;
        }

        /* Input focus */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #C85A1A;
            box-shadow: 0 0 0 3px rgba(200, 90, 26, 0.15);
        }

        /* Animate fade-in sections */
        .fade-in {
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, #C85A1A, #E07A3A);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(200, 90, 26, 0.35);
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
    </style>
</head>

<body class="min-h-screen relative z-10">

    {{-- TOP NAV --}}
    <nav class="bg-crate-brown text-crate-cream sticky top-0 z-50 shadow-lg py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-crate-cream flex items-center justify-center overflow-hidden border border-white">
                    <img class="w-full h-full" src="{{ asset('assets/imgs/logo-circle.png') }}">
                    <!-- <span class="text-crate-orange font-script text-lg leading-none">C</span> -->
                </div>
                <div>
                    <span class="font-script text-2xl text-crate-warm tracking-wide">Cratefit</span>
                    <span class="hidden sm:block text-crate-stone text-xs font-body ml-1">Stylish tanpa ribet</span>
                </div>
            </div>

            {{-- User --}}
            <div class="flex items-center gap-3">
                <span class="text-crate-stone text-sm hidden sm:block">Halo, <span class="text-crate-warm font-medium">{{ auth()->user()->name }}</span></span>
                <div class="w-9 h-9 rounded-full bg-crate-orange flex items-center justify-center text-white font-display font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-crate-stone hover:text-crate-warm text-sm font-body transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- LAYOUT --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 flex gap-8">

        {{-- SIDEBAR --}}
        <aside class="hidden lg:block w-60 shrink-0">
            <div class="card-wood rounded-2xl p-5 sticky top-24">
                <p class="text-crate-stone text-xs font-body font-medium uppercase tracking-widest mb-4">Menu Pelanggan</p>
                <nav class="sidebar-nav space-y-1">
                    @php
                    $menu = [
                    // ['icon'=>'👤','label'=>'Profil Saya', 'route'=>'/profil'],
                    ['icon'=>'✨','label'=>'Preferensi Fashion', 'route'=>'/preferensi'],
                    ['icon'=>'📍','label'=>'Alamat Pengiriman', 'route'=>'/alamat'],
                    ['icon'=>'📦','label'=>'Langganan Paket', 'route'=>'/langganan'],
                    ['icon'=>'🚚','label'=>'Status Box', 'route'=>'/status-box'],
                    ['icon'=>'↩️','label'=>'Retur', 'route'=>'/retur'],
                    ];
                    @endphp

                    @foreach($menu as $item)

                    @php
                    $isActive = request()->is(trim($item['route'], '/'));
                    @endphp

                    <a href="{{ url($item['route']) }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-body
        {{ $isActive
            ? 'bg-crate-orange/10 text-crate-orange font-medium border border-crate-orange/20'
            : 'text-crate-brown/70 hover:bg-crate-sand hover:text-crate-brown' }}">

                        <span class="text-base">{{ $item['icon'] }}</span>
                        {{ $item['label'] }}
                    </a>

                    @endforeach
                </nav>

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-body
                            text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <span class="text-base">🚪</span> Keluar
                    </button>
                </form>
                <div class="mt-6 p-3 bg-crate-cream rounded-xl border border-crate-sand text-center">
                    <p class="text-crate-stone text-xs font-body">Paket aktif</p>
                    <p class="text-crate-orange font-display font-bold text-sm mt-0.5">— Belum berlangganan —</p>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-w-0 pb-20 lg:pb-0">

            {{-- STEP PROGRESS --}}
            <div class="flex items-center gap-2 mb-8 overflow-x-auto pb-2">
                @php
                $steps = [
                ['no'=>1,'label'=>'Daftar Akun'],
                ['no'=>2,'label'=>'Preferensi Fashion'],
                ['no'=>3,'label'=>'Alamat Pengiriman'],
                ['no'=>4,'label'=>'Pilih Paket'],
                ];
                $currentStep = $currentStep ?? 4; // ubah sesuai halaman
                @endphp
                @foreach($steps as $i => $step)
                <div class="flex items-center gap-2 shrink-0">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-body font-bold
                                {{ $step['no'] < $currentStep ? 'step-done' :
                                   ($step['no'] === $currentStep ? 'step-active' : 'step-todo') }}">
                            {{ $step['no'] < $currentStep ? '✓' : $step['no'] }}
                        </div>
                        <span class="text-sm font-body
                                {{ $step['no'] === $currentStep ? 'text-crate-orange font-medium' : 'text-crate-stone' }}">
                            {{ $step['label'] }}
                        </span>
                    </div>
                    @if(!$loop->last)
                    <div class="w-8 h-px bg-crate-sand mx-1"></div>
                    @endif
                </div>
                @endforeach
            </div>

            @yield('content')
        </main>
    </div>

    {{-- FOOTER --}}
    <footer class="mt-16 bg-crate-brown text-crate-stone">
        <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span class="font-script text-crate-warm text-xl">Cratefit</span>
            <p class="text-xs font-body text-center">"Stylish tanpa ribet, hemat tanpa kehilangan style."</p>
            <p class="text-xs font-body">© 2025 Cratefit</p>
        </div>
    </footer>

    <!-- MOBILE BOTTOM NAV -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50" style="background:#3B1F0E;border-top:1px solid rgba(255,255,255,0.08);padding-bottom:env(safe-area-inset-bottom)">
        <div style="display:flex;justify-content:space-around;align-items:center;height:60px">
            <!-- <a href="#" style="display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;color:#C9B99A;font-size:0.6rem;font-family:'DM Sans',sans-serif;padding:0 0.75rem">
                <span style="font-size:1.25rem">👤</span>Profil
            </a> -->
            <a href="/preferensi" style="display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;color:#F5A05A;font-size:0.6rem;font-family:'DM Sans',sans-serif;padding:0 0.75rem">
                <span style="font-size:1.25rem">✨</span><span style="color:#F5A05A;font-weight:600">Preferensi</span>
            </a>
            <a href="/alamat" style="display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;color:#C9B99A;font-size:0.6rem;font-family:'DM Sans',sans-serif;padding:0 0.75rem">
                <span style="font-size:1.25rem">📍</span>Alamat
            </a>
            <a href="/status-box" style="display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;color:#C9B99A;font-size:0.6rem;font-family:'DM Sans',sans-serif;padding:0 0.75rem">
                <span style="font-size:1.25rem">📦</span>Paket
            </a>
            <a href="#" onclick="toggleMobileMenu()" style="display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;color:#C9B99A;font-size:0.6rem;font-family:'DM Sans',sans-serif;padding:0 0.75rem">
                <span style="font-size:1.25rem">☰</span>Lainnya
            </a>
        </div>
    </div>

    <!-- MOBILE SLIDE-UP DRAWER (untuk "Lainnya") -->
    <div id="mobile-drawer" onclick="toggleMobileMenu()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:60;backdrop-filter:blur(2px)">
        <div onclick="event.stopPropagation()" style="position:absolute;bottom:0;left:0;right:0;background:#FAF3E8;border-radius:1.5rem 1.5rem 0 0;padding:1.5rem 1.5rem calc(1.5rem + env(safe-area-inset-bottom))">
            <!-- Handle -->
            <div style="width:40px;height:4px;background:#EDE0CC;border-radius:9999px;margin:0 auto 1.25rem"></div>
            <p style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:#C9B99A;margin-bottom:0.75rem">Menu Pelanggan</p>
            <nav style="display:flex;flex-direction:column;gap:0.25rem">
                <a href="/status-box" style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:0.75rem;font-size:0.9rem;color:rgba(59,31,14,0.7);text-decoration:none;font-family:'DM Sans',sans-serif" onmouseover="this.style.background='#EDE0CC'" onmouseout="this.style.background='transparent'">🚚 &nbsp;Status Box</a>
                <a href="/retur" style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:0.75rem;font-size:0.9rem;color:rgba(59,31,14,0.7);text-decoration:none;font-family:'DM Sans',sans-serif" onmouseover="this.style.background='#EDE0CC'" onmouseout="this.style.background='transparent'">↩️ &nbsp;Retur</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:0.75rem;font-size:0.9rem;color:#ef4444;text-decoration:none;font-family:'DM Sans',sans-serif;width:100%;background:none;border:none;cursor:pointer;text-align:left">
                        🚪 &nbsp;Keluar
                    </button>
                </form>
            </nav>
            <div style="margin-top:1rem;padding:0.75rem;background:white;border-radius:0.75rem;border:1px solid #EDE0CC;text-align:center">
                <p style="color:#C9B99A;font-size:0.75rem;margin:0">Paket aktif</p>
                <p style="color:#C85A1A;font-family:'Playfair Display',serif;font-weight:700;font-size:0.875rem;margin:2px 0 0">— Belum berlangganan —</p>
            </div>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const drawer = document.getElementById('mobile-drawer');
            const isHidden = drawer.style.display === 'none';
            drawer.style.display = isHidden ? 'block' : 'none';
            if (isHidden) {
                // animate slide up
                const panel = drawer.querySelector('div');
                panel.style.transform = 'translateY(100%)';
                panel.style.transition = 'transform 0.3s ease';
                requestAnimationFrame(() => {
                    panel.style.transform = 'translateY(0)'
                });
            }
        }
    </script>
</body>

</html>