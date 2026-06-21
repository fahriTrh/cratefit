<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit Admin — @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&family=Caveat:wght@600&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&family=Caveat:wght@600&display=swap" rel="stylesheet">
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
                        // Admin accent — deep teal
                        'cur-teal':     '#1A6B5A',
                        'cur-teal-bg':  '#EAF4F1',
                        // Admin accent — slate blue
                        'admin-blue':   '#1E3A5F',
                        'admin-blue-bg':'#EAF0F8',
                    },
                    // fontFamily: {
                    //     'display': ['Playfair Display', 'serif'],
                    //     'body':    ['DM Sans', 'sans-serif'],
                    //     'script':  ['Caveat', 'cursive'],
                    // },
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
        /* body {
            font-family: 'DM Sans', sans-serif;
            background-color: #F4EDE0;
        } */

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F4EDE0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Noise texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* Sidebar */
        #admin-sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-item {
            transition: all 0.18s;
            position: relative;
        }

        .nav-item:hover {
            transform: translateX(3px);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: #C85A1A;
            border-radius: 0 3px 3px 0;
        }

        /* Cards */
        .card-wood {
            background: white;
            border: 1px solid #EDE0CC;
            position: relative;
            overflow: hidden;
        }

        .card-wood::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3B1F0E, #C85A1A, #E07A3A, #3B1F0E);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #C85A1A, #E07A3A);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(200, 90, 26, 0.35);
        }

        .btn-admin {
            background: linear-gradient(135deg, #1E3A5F, #2A5298);
            transition: all 0.2s;
        }

        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30, 58, 95, 0.3);
        }

        /* Status badges */
        .badge-menunggu         { background: #FEF9C3; color: #854D0E; border: 1px solid #FDE68A; }
        .badge-diproses         { background: #DBEAFE; color: #1E40AF; border: 1px solid #BFDBFE; }
        .badge-selesai          { background: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0; }
        .badge-dikirim          { background: #EDE9FE; color: #5B21B6; border: 1px solid #DDD6FE; }
        .badge-aktif            { background: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0; }
        .badge-nonaktif         { background: #F3F4F6; color: #6B7280; border: 1px solid #E5E7EB; }
        .badge-menunggu_pengiriman { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }

        /* Kurator accent */
        .cur-teal-text { color: #1A6B5A; }

        /* Fade-in animation */
        .fade-in {
            animation: fadeUp 0.45s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Tag toggle */
        .tag-btn.selected,
        input[type="checkbox"]:checked + .tag-btn {
            background: #C85A1A;
            color: white;
            border-color: #C85A1A;
        }

        /* Input focus */
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #C85A1A;
            box-shadow: 0 0 0 3px rgba(200, 90, 26, 0.12);
        }

        /* Scrollbar sidebar */
        /* #admin-sidebar::-webkit-scrollbar { width: 4px; }
        #admin-sidebar::-webkit-scrollbar-track { background: transparent; }
        #admin-sidebar::-webkit-scrollbar-thumb { background: #EDE0CC; border-radius: 9999px; } */
        
        #admin-sidebar {
            scrollbar-width: none;      /* Firefox */
            -ms-overflow-style: none;   /* IE/Edge lama */
        }
        #admin-sidebar::-webkit-scrollbar {
            display: none;              /* Chrome, Safari, Edge baru */
        }

        /* Mobile overlay */
        #sidebar-overlay {
            transition: opacity 0.3s;
        }
    </style>
</head>

<body class="min-h-screen relative z-10">

    {{-- ============================================================
         TOP NAVBAR
    ============================================================ --}}
    <nav class="bg-crate-dark text-crate-cream sticky top-0 z-50 shadow-xl"
         style="border-bottom: 1px solid rgba(255,255,255,0.06)">
        <div class="flex items-center justify-between h-16 px-4 sm:px-6">

            {{-- Hamburger (mobile) + Logo --}}
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()"
                        class="lg:hidden w-9 h-9 rounded-lg flex items-center justify-center
                               text-crate-stone hover:text-crate-cream hover:bg-white/10 transition-colors">
                    <svg id="icon-menu" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6"  x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-crate-cream flex items-center justify-center
                                border border-white/20 overflow-hidden shrink-0">
                        <img class="w-full h-full object-cover" src="{{ asset('assets/imgs/logo-circle.png') }}"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                        <span class="text-crate-orange font-script text-lg leading-none hidden">C</span>
                    </div>
                    <div>
                        <span class="font-script text-xl text-crate-warm tracking-wide">Cratefit</span>
                        <span class="hidden sm:inline text-crate-stone text-xs font-body ml-1.5
                                     bg-admin-blue/60 px-2 py-0.5 rounded-full border border-white/10">
                            Admin Panel
                        </span>
                    </div>
                </div>
            </div>

            {{-- Right: notif + user --}}
            <div class="flex items-center gap-2 sm:gap-3">

                {{-- Notifikasi --}}
                <button class="relative w-9 h-9 rounded-lg flex items-center justify-center
                               text-crate-stone hover:text-crate-cream hover:bg-white/10 transition-colors">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    {{-- Badge notif (tampilkan jika ada) --}}
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-crate-orange"></span>
                </button>

                {{-- Divider --}}
                <div class="hidden sm:block w-px h-6 bg-white/10"></div>

                {{-- Admin user --}}
                <div class="flex items-center gap-2.5">
                    <div class="hidden sm:block text-right">
                        <p class="text-crate-cream text-xs font-body font-medium leading-tight">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </p>
                        <p class="text-crate-stone text-xs font-body leading-tight">Administrator</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-crate-orange flex items-center justify-center
                                text-white font-display font-bold text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>

                {{-- Logout --}}
                <form action="{{ url('/logout') }}" method="POST" class="hidden sm:block">
                    @csrf
                    <button type="submit"
                            class="w-9 h-9 rounded-lg flex items-center justify-center
                                   text-crate-stone hover:text-red-400 hover:bg-white/10 transition-colors"
                            title="Logout">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ============================================================
         LAYOUT WRAPPER
    ============================================================ --}}
    <div class="flex min-h-[calc(100vh-64px)] relative">

        {{-- Mobile overlay --}}
        <div id="sidebar-overlay"
             onclick="toggleSidebar()"
             class="lg:hidden fixed inset-0 bg-black/50 z-30 opacity-0 pointer-events-none"
             style="top:64px"></div>

        {{-- ============================================================
             SIDEBAR
        ============================================================ --}}
        <aside id="admin-sidebar"
               class="fixed lg:sticky top-16 left-0 z-40 h-[calc(100vh-64px)]
                      w-64 bg-crate-dark text-crate-cream overflow-y-auto
                      -translate-x-full lg:translate-x-0 shrink-0"
               style="border-right: 1px solid rgba(255,255,255,0.06)">

            <div class="p-5">

                {{-- Admin info box --}}
                <div class="mb-6 p-3 rounded-xl bg-white/5 border border-white/10 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-crate-orange flex items-center justify-center
                                text-white font-bold text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-crate-cream text-xs font-body font-semibold truncate">
                            {{ auth()->user()->name ?? 'Administrator' }}
                        </p>
                        <p class="text-crate-stone text-xs font-body">Admin</p>
                    </div>
                </div>

                {{-- NAV GROUPS --}}
                @php
                

                $navGroups = [
                    [
                        'label' => 'Utama',
                        'items' => [
                            ['icon' => 'layout-dashboard', 'label' => 'Dashboard',          'route' => '/admin/dashboard'],
                        ],
                    ],
                    [
                        'label' => 'Manajemen Pengguna',
                        'items' => [
                            ['icon' => 'users',            'label' => 'Pelanggan',          'route' => '/admin/pelanggan'],
                            ['icon' => 'scissors',         'label' => 'Kurator',            'route' => '/admin/kurator'],
                            ['icon' => 'truck',            'label' => 'Kurir',              'route' => '/admin/kurir'],
                        ],
                    ],
                    [
                        'label' => 'Produk & Layanan',
                        'items' => [
                            ['icon' => 'package',          'label' => 'Paket Subscription', 'route' => '/admin/kelola-paket'],
                            ['icon' => 'shirt',            'label' => 'Inventory Thrift',   'route' => '/admin/inventory'],
                        ],
                    ],
                    [
                        'label' => 'Operasional',
                        'items' => [
                            // ['icon' => 'shopping-cart',  'label' => 'Langganan',          'route' => '/admin/langganan'],
                            // ['icon' => 'send',           'label' => 'Pengiriman',         'route' => '/admin/pengiriman'],
                            ['icon' => 'undo-2',           'label' => 'Retur',              'route' => '/admin/kelola-retur'],
                        ],
                    ],
                ];
                @endphp

                @foreach($navGroups as $group)
                <div class="mb-5">
                    <p class="text-crate-stone/60 text-xs font-body font-semibold uppercase tracking-widest mb-2 px-3">
                        {{ $group['label'] }}
                    </p>
                    <nav class="space-y-0.5">
                        @foreach($group['items'] as $item)
                        @php
                            $isActive = request()->is(trim($item['route'], '/'))
                                     || request()->is(trim($item['route'], '/') . '/*');
                        @endphp
                        <a href="{{ url($item['route']) }}"
                           class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-body
                                  {{ $isActive
                                       ? 'bg-crate-orange/15 text-crate-warm font-medium border border-crate-orange/20'
                                       : 'text-crate-stone hover:bg-white/5 hover:text-crate-cream' }}">
                            <!-- <span class="text-base w-5 text-center shrink-0">{{ $item['icon'] }}</span> -->
                            <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4 shrink-0 {{ $isActive ? 'text-crate-warm' : 'text-crate-stone' }}"></i>
                            <span class="{{ $isActive ? 'active' : '' }}">{{ $item['label'] }}</span>
                        </a>
                        @endforeach
                    </nav>
                </div>
                @endforeach

                {{-- Logout (mobile) --}}
                <div class="mt-4 pt-4 border-t border-white/10 sm:hidden">
                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-body
                                       text-red-400/80 hover:bg-red-500/10 hover:text-red-400 transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4 shrink-0 text-red-400/80"></i>
                            Keluar
                        </button>
                    </form>
                </div>

            </div>
        </aside>

        {{-- ============================================================
             MAIN CONTENT
        ============================================================ --}}
        <main class="flex-1 min-w-0 overflow-x-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 pb-24 lg:pb-10">

                {{-- Session alerts --}}
                @if(session('success'))
                <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200
                            text-emerald-700 rounded-xl px-4 py-3 text-sm font-body fade-in">
                    <span class="text-lg">✅</span>
                    {{ session('success') }}
                    <button onclick="this.parentElement.remove()"
                            class="ml-auto text-emerald-400 hover:text-emerald-700 transition-colors text-lg leading-none">×</button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200
                            text-red-700 rounded-xl px-4 py-3 text-sm font-body fade-in">
                    <span class="text-lg">❌</span>
                    {{ session('error') }}
                    <button onclick="this.parentElement.remove()"
                            class="ml-auto text-red-400 hover:text-red-700 transition-colors text-lg leading-none">×</button>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm font-body fade-in">
                    <div class="flex items-center gap-2 text-red-700 font-semibold mb-2">
                        <span>⚠️</span> Ada beberapa kesalahan:
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </div>
        </main>

    </div>

    {{-- ============================================================
         FOOTER
    ============================================================ --}}
    {{-- <footer class="bg-crate-dark text-crate-stone"
            style="border-top: 1px solid rgba(255,255,255,0.06)">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span class="font-script text-crate-warm text-lg">Cratefit Admin</span>
            <p class="text-xs font-body">Sistem manajemen internal Cratefit</p>
            <p class="text-xs font-body">© 2025 Cratefit</p>
        </div>
    </footer> --}}

    {{-- ============================================================
         MOBILE BOTTOM NAV
    ============================================================ --}}
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-crate-dark"
         style="border-top:1px solid rgba(255,255,255,0.08);padding-bottom:env(safe-area-inset-bottom)">
        <div class="flex justify-around items-center h-14">
            @php
            

            $mobileNav = [
                ['icon'=>'layout-dashboard', 'label'=>'Dashboard', 'route'=>'/admin/dashboard'],
                ['icon'=>'users',            'label'=>'Pelanggan', 'route'=>'/admin/pelanggan'],
                ['icon'=>'scissors',         'label'=>'Kurator',   'route'=>'/admin/kurator'],
                ['icon'=>'package',          'label'=>'Paket',     'route'=>'/admin/kelola-paket'],
                ['icon'=>'menu',             'label'=>'Lainnya',   'route'=>'#', 'toggle'=>true],
            ];
            @endphp
            @foreach($mobileNav as $nav)
            @php
                $mbActive = !isset($nav['toggle']) && (request()->is(trim($nav['route'], '/')) || request()->is(trim($nav['route'], '/') . '/*'));
            @endphp
            @if(isset($nav['toggle']))
            <button onclick="toggleSidebar()"
                    style="display:flex;flex-direction:column;align-items:center;gap:3px;
                           background:none;border:none;color:#C9B99A;font-size:0.6rem;
                           font-family:'Plus Jakarta Sans',sans-serif;padding:0 0.5rem;cursor:pointer">
                <i data-lucide="{{ $nav['icon'] }}" style="width:18px;height:18px"></i>{{ $nav['label'] }}
            </button>
            @else
            <a href="{{ url($nav['route']) }}"
               style="display:flex;flex-direction:column;align-items:center;gap:3px;
                      text-decoration:none;font-size:0.6rem;font-family:'Plus Jakarta Sans',sans-serif;
                      padding:0 0.5rem;color:{{ $mbActive ? '#F5A05A' : '#C9B99A' }}">
                <i data-lucide="{{ $nav['icon'] }}" style="width:18px;height:18px"></i>
                <span style="{{ $mbActive ? 'font-weight:600' : '' }}">{{ $nav['label'] }}</span>
            </a>
            @endif
            @endforeach
        </div>
    </div>

    <script>
        // ===== SIDEBAR TOGGLE (mobile) =====
        let sidebarOpen = false;

        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            const sidebar  = document.getElementById('admin-sidebar');
            const overlay  = document.getElementById('sidebar-overlay');

            if (sidebarOpen) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        // Tutup sidebar saat resize ke desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024 && sidebarOpen) {
                sidebarOpen = false;
                document.getElementById('sidebar-overlay').classList.add('opacity-0', 'pointer-events-none');
            }
        });

        // Auto-dismiss alert setelah 5 detik
        document.querySelectorAll('[class*="bg-emerald-50"], [class*="bg-red-50"]').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.4s';
                el.style.opacity    = '0';
                setTimeout(() => el.remove(), 400);
            }, 5000);
        });
    </script>
    <script>lucide.createIcons();</script>

    @stack('scripts')
</body>

</html>