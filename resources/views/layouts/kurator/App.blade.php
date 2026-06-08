<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit Kurator — @yield('title', 'Dashboard Kurator')</title>
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
                        // Kurator accent — teal/forest agar beda dari portal pelanggan
                        'cur-teal': '#1A6B5A',
                        'cur-teal-lt': '#228F76',
                        'cur-teal-bg': '#EAF4F1',
                        'cur-gold': '#B8860B',
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
            background-color: #F2EDE3;
        }

        /* Noise texture */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* Sidebar nav links */
        .sidebar-nav a {
            transition: all 0.2s;
        }

        .sidebar-nav a:hover {
            transform: translateX(4px);
        }

        /* Card style */
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
            background: linear-gradient(90deg, #1A6B5A, #228F76, #B8860B, #1A6B5A);
        }

        /* Kurator primary button */
        .btn-curator {
            background: linear-gradient(135deg, #1A6B5A, #228F76);
            transition: all 0.2s;
        }

        .btn-curator:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26, 107, 90, 0.35);
        }

        /* Badge status */
        .badge-menunggu {
            background: #FEF3C7;
            color: #92400E;
            border: 1px solid #FDE68A;
        }

        .badge-diproses {
            background: #DBEAFE;
            color: #1E40AF;
            border: 1px solid #BFDBFE;
        }

        .badge-selesai {
            background: #D1FAE5;
            color: #065F46;
            border: 1px solid #6EE7B7;
        }

        .badge-dikirim {
            background: #EDE9FE;
            color: #4C1D95;
            border: 1px solid #C4B5FD;
        }

        /* Input focus */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #1A6B5A;
            box-shadow: 0 0 0 3px rgba(26, 107, 90, 0.15);
        }

        /* Fade-in */
        .fade-in {
            animation: fadeUp 0.45s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Top nav kurator stripe */
        .nav-curator {
            background: linear-gradient(135deg, #2A1508 60%, #1A3D32);
        }

        /* Kurator badge chip on nav */
        .chip-curator {
            background: rgba(26, 107, 90, 0.25);
            border: 1px solid rgba(34, 143, 118, 0.4);
            color: #6ECFBB;
        }
    </style>
</head>

<body class="min-h-screen relative z-10">

    {{-- ===== TOP NAV ===== --}}
    <nav class="nav-curator text-crate-cream sticky top-0 z-50 shadow-lg py-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">

            {{-- Logo + role badge --}}
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-full bg-crate-cream flex items-center justify-center overflow-hidden border border-white/20">
                    <img class="w-full h-full" src="{{ asset('assets/imgs/logo-circle.png') }}" alt="Cratefit">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-script text-2xl text-crate-warm tracking-wide">Cratefit</span>
                        <span class="chip-curator text-xs font-body font-semibold px-2 py-0.5 rounded-full tracking-wide">KURATOR</span>
                    </div>
                    <span class="hidden sm:block text-crate-stone text-xs font-body">Panel Kurator Fashion</span>
                </div>
            </div>

            {{-- Kurator info --}}
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col items-end">
                    <span class="text-crate-stone text-xs font-body">Masuk sebagai</span>
                    <span class="text-crate-warm font-semibold text-sm font-body">{{ $kuratorNama ?? 'Kurator' }}</span>
                </div>
                <div class="w-9 h-9 rounded-full bg-cur-teal flex items-center justify-center text-white font-display font-bold text-sm">
                    {{ strtoupper(substr($kuratorNama ?? 'K', 0, 1)) }}
                </div>
                {{-- Logout --}}
                <form method="POST" action="/kurator/logout">
                    @csrf
                    <button type="submit"
                        class="hidden sm:flex items-center gap-1.5 text-crate-stone hover:text-white text-xs font-body transition-colors ml-2">
                        <span>↗</span> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ===== LAYOUT ===== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 flex gap-8">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="hidden lg:block w-64 shrink-0">
            <div class="card-wood rounded-2xl p-5 sticky top-24">

                {{-- Kurator identity --}}
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-crate-sand">
                    <div class="w-10 h-10 rounded-full bg-cur-teal flex items-center justify-center text-white font-display font-bold">
                        {{ strtoupper(substr($kuratorNama ?? 'K', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-crate-brown font-semibold text-sm font-body">{{ $kuratorNama ?? 'Kurator' }}</p>
                        <p class="text-cur-teal text-xs font-body">Kurator Fashion</p>
                    </div>
                </div>

                <p class="text-crate-stone text-xs font-body font-medium uppercase tracking-widest mb-3">Menu Kurator</p>

                <nav class="sidebar-nav space-y-1">
                    @php
                    $menu = [
                    ['icon' => '👥', 'label' => 'Profil Pelanggan', 'route' => '/kurator/pelanggan'],
                    ['icon' => '👕', 'label' => 'Pilih Item', 'route' => '/kurator/pilih-item'],
                    ['icon' => '📦', 'label' => 'Susun Isi Box', 'route' => '/kurator/susun-box'],
                    ];
                    @endphp

                    @foreach($menu as $item)
                    @php
                    $isActive = request()->is(trim($item['route'], '/')) || request()->is(trim($item['route'], '/') . '/*');
                    @endphp
                    <a href="{{ url($item['route']) }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-body
                                  {{ $isActive
                                      ? 'bg-cur-teal/10 text-cur-teal font-semibold border border-cur-teal/20'
                                      : 'text-crate-brown/70 hover:bg-crate-sand hover:text-crate-brown' }}">
                        <span class="text-base">{{ $item['icon'] }}</span>
                        {{ $item['label'] }}
                        @if($isActive)
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-cur-teal"></span>
                        @endif
                    </a>
                    @endforeach
                </nav>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="flex-1 min-w-0 pb-24 lg:pb-0">
            @yield('content')
        </main>
    </div>

    {{-- ===== FOOTER ===== --}}
    <footer class="mt-16 bg-crate-brown text-crate-stone">
        <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span class="font-script text-crate-warm text-xl">Cratefit</span>
            <p class="text-xs font-body text-center">"Stylish tanpa ribet, hemat tanpa kehilangan style."</p>
            <p class="text-xs font-body">© 2025 Cratefit — Panel Kurator</p>
        </div>
    </footer>

    {{-- ===== MOBILE BOTTOM NAV ===== --}}
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50"
        style="background:#2A1508;border-top:1px solid rgba(255,255,255,0.08);padding-bottom:env(safe-area-inset-bottom)">
        <div style="display:flex;justify-content:space-around;align-items:center;height:60px">
            <a href="{{ url('/kurator/pelanggan') }}"
                style="display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;
                      color:{{ request()->is('kurator/pelanggan*') ? '#6ECFBB' : '#C9B99A' }};
                      font-size:0.6rem;font-family:'DM Sans',sans-serif;padding:0 0.75rem">
                <span style="font-size:1.25rem">👥</span>Pelanggan
            </a>
            <a href="{{ url('/kurator/pilih-item') }}"
                style="display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;
                      color:{{ request()->is('kurator/pilih-item*') ? '#6ECFBB' : '#C9B99A' }};
                      font-size:0.6rem;font-family:'DM Sans',sans-serif;padding:0 0.75rem">
                <span style="font-size:1.25rem">👕</span>Pilih Item
            </a>
            <a href="{{ url('/kurator/susun-box') }}"
                style="display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;
                      color:{{ request()->is('kurator/susun-box*') ? '#6ECFBB' : '#C9B99A' }};
                      font-size:0.6rem;font-family:'DM Sans',sans-serif;padding:0 0.75rem">
                <span style="font-size:1.25rem">📦</span>Susun Box
            </a>
            <a href="#" onclick="toggleMobileMenu()"
                style="display:flex;flex-direction:column;align-items:center;gap:3px;text-decoration:none;
                      color:#C9B99A;font-size:0.6rem;font-family:'DM Sans',sans-serif;padding:0 0.75rem">
                <span style="font-size:1.25rem">☰</span>Lainnya
            </a>
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div id="mobile-drawer" onclick="toggleMobileMenu()"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:60;backdrop-filter:blur(2px)">
        <div onclick="event.stopPropagation()"
            style="position:absolute;bottom:0;left:0;right:0;background:#FAF3E8;
                    border-radius:1.5rem 1.5rem 0 0;
                    padding:1.5rem 1.5rem calc(1.5rem + env(safe-area-inset-bottom))">
            <div style="width:40px;height:4px;background:#EDE0CC;border-radius:9999px;margin:0 auto 1.25rem"></div>
            <p style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:#C9B99A;margin-bottom:0.75rem">Menu Kurator</p>
            <nav style="display:flex;flex-direction:column;gap:0.25rem">
                <a href="{{ url('/kurator/pelanggan') }}"
                    style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:0.75rem;
                          font-size:0.9rem;color:rgba(59,31,14,0.7);text-decoration:none;font-family:'DM Sans',sans-serif">
                    👥 &nbsp;Profil Pelanggan
                </a>
                <a href="{{ url('/kurator/pilih-item') }}"
                    style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:0.75rem;
                          font-size:0.9rem;color:rgba(59,31,14,0.7);text-decoration:none;font-family:'DM Sans',sans-serif">
                    👕 &nbsp;Pilih Item
                </a>
                <a href="{{ url('/kurator/susun-box') }}"
                    style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:0.75rem;
                          font-size:0.9rem;color:rgba(59,31,14,0.7);text-decoration:none;font-family:'DM Sans',sans-serif">
                    📦 &nbsp;Susun Isi Box
                </a>
            </nav>
            <form method="POST" action="" class="mt-4">
                @csrf
                <button type="submit"
                    style="width:100%;padding:0.75rem;background:#EDE0CC;border-radius:0.75rem;
                               font-size:0.875rem;color:rgba(59,31,14,0.7);font-family:'DM Sans',sans-serif;
                               border:none;cursor:pointer;text-align:center">
                    ↗ Keluar
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const drawer = document.getElementById('mobile-drawer');
            const isHidden = drawer.style.display === 'none';
            drawer.style.display = isHidden ? 'block' : 'none';
            if (isHidden) {
                const panel = drawer.querySelector('div');
                panel.style.transform = 'translateY(100%)';
                panel.style.transition = 'transform 0.3s ease';
                requestAnimationFrame(() => {
                    panel.style.transform = 'translateY(0)';
                });
            }
        }
    </script>

    @stack('scripts')
</body>

</html>