<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit — Stylish Tanpa Ribet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Caveat:wght@600;700&display=swap" rel="stylesheet">
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
                        'crate-muted':   '#7A6A5F',
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
        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F5F2;
            color: #2B2B2B;
            overflow-x: hidden;
        }

        /* Subtle noise texture */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes floatBox {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50%       { transform: translateY(-12px) rotate(-2deg); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes pulse-ring {
            0%   { transform: scale(1); opacity: 0.4; }
            100% { transform: scale(1.8); opacity: 0; }
        }

        .animate-fade-up { animation: fadeUp 0.6s ease both; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        .float-box { animation: floatBox 4s ease-in-out infinite; }

        /* ── Nav ── */
        .nav-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #E9D8CC;
        }

        /* ── Hero ── */
        .hero-gradient {
            background: linear-gradient(135deg, #FDF6F0 0%, #F8F5F2 50%, #EDE0D4 100%);
        }

        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        /* ── Box visual ── */
        .box-visual {
            position: relative;
            width: 260px;
            height: 260px;
            flex-shrink: 0;
        }
        .box-main {
            width: 200px;
            height: 200px;
            background: linear-gradient(145deg, #FFFFFF, #F8F0EA);
            border: 2px solid #E9D8CC;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(216,169,140,0.25), 0 4px 16px rgba(0,0,0,0.06);
            position: absolute;
            top: 30px;
            left: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 8px;
        }
        .box-ribbon {
            position: absolute;
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 40px;
            background: linear-gradient(to bottom, #D8A98C, #C4927A);
            border-radius: 0 0 4px 4px;
        }
        .box-ribbon::after {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 16px;
            background: #D8A98C;
            border-radius: 50% 50% 0 0 / 60% 60% 0 0;
        }
        .box-tag {
            position: absolute;
            padding: 6px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* ── Cards ── */
        .card-wood {
            background: #FFFFFF;
            border: 1px solid #E9D8CC;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            border-radius: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-wood:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(216,169,140,0.2);
        }

        /* ── Step line ── */
        .step-connector {
            flex: 1;
            height: 2px;
            background: linear-gradient(to right, #D8A98C, #E9D8CC);
        }

        /* ── Pricing ── */
        .pricing-card {
            background: #FFFFFF;
            border: 1.5px solid #E9D8CC;
            border-radius: 20px;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        }
        .pricing-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(216,169,140,0.2);
        }
        .pricing-card.featured {
            border-color: #D8A98C;
            box-shadow: 0 8px 32px rgba(216,169,140,0.25);
        }

        /* ── Buttons ── */
        .btn-primary {
            background: #D8A98C;
            color: white;
            font-weight: 600;
            border-radius: 100px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary:hover {
            background: #C4927A;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(216,169,140,0.4);
        }
        .btn-outline {
            background: transparent;
            color: #2B2B2B;
            font-weight: 600;
            border: 1.5px solid #E9D8CC;
            border-radius: 100px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-outline:hover {
            border-color: #D8A98C;
            color: #D8A98C;
        }

        /* ── Testimonial ── */
        .testi-card {
            background: #FFFFFF;
            border: 1px solid #E9D8CC;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        }

        /* ── FAQ ── */
        .faq-item summary {
            cursor: pointer;
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-item[open] .faq-icon { transform: rotate(45deg); }
        .faq-icon { transition: transform 0.2s; }

        /* ── Footer ── */
        .footer-gradient {
            background: linear-gradient(180deg, #F8F5F2 0%, #EDE0D4 100%);
        }

        /* Shimmer badge */
        .shimmer-badge {
            background: linear-gradient(90deg, #D8A98C, #F0C9A8, #D8A98C);
            background-size: 200% auto;
            animation: shimmer 2.5s linear infinite;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="relative">

{{-- ════════════════════════════════════════
     NAVBAR
════════════════════════════════════════ --}}
<nav class="nav-glass sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">
        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2">
            <div class="w-24 h-12 flex items-center overflow-hidden">
                <img src="{{ asset('assets/imgs/cratefit-new-nobg.png') }}" alt="Cratefit" class="h-full w-full object-contain">
            </div>
        </a>

        {{-- Nav links --}}
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-crate-muted">
            <a href="#cara-kerja" class="hover:text-crate-text transition-colors">Cara Kerja</a>
            <a href="#paket" class="hover:text-crate-text transition-colors">Paket</a>
            <a href="#faq" class="hover:text-crate-text transition-colors">FAQ</a>
        </div>

        {{-- CTA --}}
        <div class="flex items-center gap-3">
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-outline text-sm px-5 py-2">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-crate-muted hover:text-crate-text transition-colors hidden sm:block">Masuk</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary text-sm px-5 py-2">
                            Mulai Sekarang
                            <i data-lucide="arrow-right" style="width:14px;height:14px"></i>
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>


{{-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ --}}
<section class="hero-gradient relative overflow-hidden min-h-[90vh] flex items-center">

    {{-- Blobs --}}
    <div class="hero-blob w-96 h-96 bg-crate-primary opacity-10 -top-20 -right-20" style="position:absolute"></div>
    <div class="hero-blob w-64 h-64 bg-amber-200 opacity-15 bottom-10 left-10" style="position:absolute"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20 relative z-10 w-full">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

            {{-- Text --}}
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-white border border-crate-accent rounded-full px-4 py-1.5 text-xs font-semibold text-crate-muted mb-6 animate-fade-up">
                    <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span>
                    Pengiriman ke seluruh Indonesia
                </div>

                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold text-crate-text leading-tight animate-fade-up delay-100">
                    Tampil Stylish<br>
                    <span class="font-script text-5xl sm:text-6xl lg:text-7xl shimmer-badge">Tanpa Ribet</span>
                </h1>

                <p class="mt-5 text-base sm:text-lg text-crate-muted max-w-lg mx-auto lg:mx-0 animate-fade-up delay-200">
                    Kurator fashion kami memilihkan pakaian terbaik sesuai selera kamu, dikemas rapi dalam satu box, dikirim langsung ke pintu rumahmu.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start animate-fade-up delay-300">
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary px-7 py-3.5 text-base">
                            Coba Sekarang — Gratis
                            <i data-lucide="package" style="width:16px;height:16px"></i>
                        </a>
                    @endif
                    <a href="#cara-kerja" class="btn-outline px-7 py-3.5 text-base justify-center">
                        Lihat Cara Kerja
                    </a>
                </div>

                {{-- Stats --}}
                <div class="mt-10 flex gap-8 justify-center lg:justify-start animate-fade-up delay-400">
                    <div>
                        <p class="font-display text-2xl font-extrabold text-crate-text">500+</p>
                        <p class="text-xs text-crate-muted">Pelanggan Aktif</p>
                    </div>
                    <div class="w-px bg-crate-accent"></div>
                    <div>
                        <p class="font-display text-2xl font-extrabold text-crate-text">4.9★</p>
                        <p class="text-xs text-crate-muted">Rating Kurator</p>
                    </div>
                    <div class="w-px bg-crate-accent"></div>
                    <div>
                        <p class="font-display text-2xl font-extrabold text-crate-text">100%</p>
                        <p class="text-xs text-crate-muted">Bisa Retur</p>
                    </div>
                </div>
            </div>

            {{-- Box Illustration --}}
            <div class="flex-shrink-0 animate-fade-up delay-200">
                <div class="relative" style="width:300px;height:300px;">

                    {{-- Glow ring --}}
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:220px;height:220px;border-radius:50%;background:rgba(216,169,140,0.15);"></div>

                    {{-- Main box --}}
                    <div class="float-box" style="position:absolute;top:40px;left:40px;">
                        <div style="
                            width:220px;height:220px;
                            background:linear-gradient(145deg,#FFFFFF,#FAF0E8);
                            border:2px solid #E9D8CC;
                            border-radius:24px;
                            box-shadow:0 24px 64px rgba(216,169,140,0.3),0 4px 16px rgba(0,0,0,0.06);
                            display:flex;align-items:center;justify-content:center;
                            flex-direction:column;gap:10px;position:relative;overflow:hidden;
                        ">
                            {{-- Ribbon --}}
                            <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:5px;height:44px;background:linear-gradient(to bottom,#D8A98C,#C4927A);border-radius:0 0 5px 5px;"></div>
                            <div style="position:absolute;top:0;left:50%;transform:translateX(-50%);width:6px;height:5px;"></div>

                            {{-- Bow --}}
                            <svg style="position:absolute;top:-4px;left:50%;transform:translateX(-50%)" width="40" height="20" viewBox="0 0 40 20">
                                <path d="M20 10 Q10 0 2 4 Q0 8 6 10 Q10 12 20 10Z" fill="#D8A98C" opacity="0.8"/>
                                <path d="M20 10 Q30 0 38 4 Q40 8 34 10 Q30 12 20 10Z" fill="#D8A98C" opacity="0.8"/>
                                <circle cx="20" cy="10" r="4" fill="#C4927A"/>
                            </svg>

                            {{-- Icon --}}
                            <i data-lucide="shirt" style="width:52px;height:52px;color:#D8A98C;stroke-width:1.5;margin-top:16px"></i>
                            <p style="font-size:11px;font-weight:700;color:#7A6A5F;letter-spacing:0.08em;text-transform:uppercase">CrateFit Box</p>

                            {{-- Corner accent --}}
                            <div style="position:absolute;bottom:0;right:0;width:60px;height:60px;background:linear-gradient(135deg,transparent 50%,rgba(216,169,140,0.12) 50%);border-radius:0 0 22px 0;"></div>
                        </div>
                    </div>

                    {{-- Floating badges --}}
                    <div class="box-tag animate-fade-up delay-400" style="background:#FFFFFF;border:1.5px solid #E9D8CC;color:#2B2B2B;top:4px;right:4px;box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                        <span style="margin-right:4px">✨</span> Dipilih Kurator
                    </div>
                    <div class="box-tag animate-fade-up delay-500" style="background:#D8A98C;color:white;bottom:10px;left:-4px;box-shadow:0 4px 12px rgba(216,169,140,0.35);">
                        <span style="margin-right:4px">📦</span> Siap Kirim
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Wave divider --}}
    <div style="position:absolute;bottom:-2px;left:0;right:0;">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60L60 50C120 40 240 20 360 15C480 10 600 20 720 25C840 30 960 30 1080 25C1200 20 1320 10 1380 5L1440 0V60H0Z" fill="#F8F5F2"/>
        </svg>
    </div>
</section>


{{-- ════════════════════════════════════════
     CARA KERJA
════════════════════════════════════════ --}}
<section id="cara-kerja" class="py-20 px-4 sm:px-6 relative z-10">
    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-14">
            <p class="text-crate-primary font-semibold text-sm uppercase tracking-widest mb-2">Cara Kerja</p>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-crate-text">Sesederhana itu</h2>
            <p class="text-crate-muted mt-3 max-w-lg mx-auto">Dari daftar sampai box tiba di rumahmu, cuma 4 langkah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
            $steps = [
                ['icon'=>'user-plus',   'no'=>'01', 'title'=>'Buat Akun',         'desc'=>'Daftar gratis. Tidak perlu kartu kredit untuk memulai.'],
                ['icon'=>'sparkles',    'no'=>'02', 'title'=>'Isi Preferensi',     'desc'=>'Ceritakan style, ukuran, dan warna favoritmu kepada kami.'],
                ['icon'=>'map-pin',     'no'=>'03', 'title'=>'Atur Alamat',        'desc'=>'Masukkan alamat pengiriman agar box sampai dengan tepat.'],
                ['icon'=>'package',     'no'=>'04', 'title'=>'Terima Box-mu',      'desc'=>'Kurator kami meracik box fashion, lalu langsung dikirim.'],
            ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="card-wood p-6 text-center relative">
                {{-- Number --}}
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-7 h-7 rounded-full bg-crate-primary text-white text-xs font-bold flex items-center justify-center">
                    {{ $step['no'] }}
                </div>
                <div class="w-12 h-12 rounded-2xl bg-crate-accent flex items-center justify-center mx-auto mb-4 mt-2">
                    <i data-lucide="{{ $step['icon'] }}" class="w-6 h-6 text-crate-primary"></i>
                </div>
                <h3 class="font-display font-bold text-crate-text mb-2">{{ $step['title'] }}</h3>
                <p class="text-sm text-crate-muted leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════
     KEUNGGULAN
════════════════════════════════════════ --}}
<section class="py-20 px-4 sm:px-6" style="background:linear-gradient(180deg,#F8F5F2 0%,#EDE0D4 100%);">
    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-14">
            <p class="text-crate-primary font-semibold text-sm uppercase tracking-widest mb-2">Kenapa Cratefit?</p>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-crate-text">Fashion tanpa drama</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $features = [
                ['icon'=>'heart',       'title'=>'Dipilih Personal',       'desc'=>'Kurator kami mengenal seleramu dan memilihkan item yang benar-benar cocok, bukan asal-asalan.'],
                ['icon'=>'rotate-ccw',  'title'=>'Retur Gratis',           'desc'=>'Tidak suka salah satu item? Kembalikan saja. Tanpa biaya, tanpa pertanyaan panjang.'],
                ['icon'=>'calendar',    'title'=>'Jadwal Fleksibel',       'desc'=>'Pilih kiriman bulanan, 2 bulan sekali, atau 3 bulan sekali. Sesuaikan dengan kebutuhanmu.'],
                ['icon'=>'shield-check','title'=>'Kualitas Terjamin',      'desc'=>'Setiap item melewati seleksi ketat dari kurator berpengalaman sebelum masuk ke box-mu.'],
                ['icon'=>'truck',       'title'=>'Pengiriman Tercepat',    'desc'=>'Box dikirim ke seluruh Indonesia dengan mitra ekspedisi terpercaya dan bisa dilacak real-time.'],
                ['icon'=>'tag',         'title'=>'Harga Transparan',       'desc'=>'Tidak ada biaya tersembunyi. Bayar sesuai paket yang dipilih, kapan saja bisa berhenti.'],
            ];
            @endphp
            @foreach($features as $f)
            <div class="card-wood p-6">
                <div class="w-10 h-10 rounded-xl bg-crate-accent flex items-center justify-center mb-4">
                    <i data-lucide="{{ $f['icon'] }}" class="w-5 h-5 text-crate-primary"></i>
                </div>
                <h3 class="font-display font-bold text-crate-text mb-2">{{ $f['title'] }}</h3>
                <p class="text-sm text-crate-muted leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════
     PAKET HARGA
════════════════════════════════════════ --}}
<section id="paket" class="py-20 px-4 sm:px-6 bg-crate-bg relative z-10">
    <div class="max-w-4xl mx-auto">

        <div class="text-center mb-14">
            <p class="text-crate-primary font-semibold text-sm uppercase tracking-widest mb-2">Paket Langganan</p>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-crate-text">Pilih yang pas buat kamu</h2>
            <p class="text-crate-muted mt-3 max-w-md mx-auto">Semua paket sudah termasuk kurator personal dan pengiriman ke seluruh Indonesia.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Bulanan --}}
            <div class="pricing-card p-7">
                <div class="mb-5">
                    <p class="text-xs font-semibold text-crate-muted uppercase tracking-widest mb-1">Bulanan</p>
                    <p class="font-display text-3xl font-extrabold text-crate-text">Rp 149k</p>
                    <p class="text-xs text-crate-muted mt-1">per bulan · 1 box</p>
                </div>
                <ul class="space-y-2.5 mb-7 text-sm text-crate-muted">
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>3–5 item fashion pilihan kurator</li>
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>Retur bebas dalam 7 hari</li>
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>Pengiriman gratis</li>
                    <li class="flex gap-2 items-start text-gray-300"><i data-lucide="minus" class="w-4 h-4 shrink-0 mt-0.5"></i>Bonus item eksklusif</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-outline w-full justify-center py-3 text-sm">Pilih Paket</a>
            </div>

            {{-- 2 Bulan - Featured --}}
            <div class="pricing-card featured p-7 relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-crate-primary text-white text-xs font-bold px-4 py-1 rounded-full whitespace-nowrap">
                    ✨ Paling Populer
                </div>
                <div class="mb-5 mt-2">
                    <p class="text-xs font-semibold text-crate-muted uppercase tracking-widest mb-1">2 Bulan Sekali</p>
                    <p class="font-display text-3xl font-extrabold text-crate-text">Rp 269k</p>
                    <p class="text-xs text-crate-muted mt-1">per 2 bulan · 1 box</p>
                </div>
                <ul class="space-y-2.5 mb-7 text-sm text-crate-muted">
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>4–6 item fashion pilihan kurator</li>
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>Retur bebas dalam 7 hari</li>
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>Pengiriman gratis</li>
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>1 bonus item eksklusif</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-primary w-full justify-center py-3 text-sm">Pilih Paket</a>
            </div>

            {{-- 3 Bulan --}}
            <div class="pricing-card p-7">
                <div class="mb-5">
                    <p class="text-xs font-semibold text-crate-muted uppercase tracking-widest mb-1">3 Bulan Sekali</p>
                    <p class="font-display text-3xl font-extrabold text-crate-text">Rp 379k</p>
                    <p class="text-xs text-crate-muted mt-1">per 3 bulan · 1 box</p>
                </div>
                <ul class="space-y-2.5 mb-7 text-sm text-crate-muted">
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>5–7 item fashion pilihan kurator</li>
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>Retur bebas dalam 10 hari</li>
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>Pengiriman gratis</li>
                    <li class="flex gap-2 items-start"><i data-lucide="check" class="w-4 h-4 text-crate-primary shrink-0 mt-0.5"></i>2 bonus item eksklusif</li>
                </ul>
                <a href="{{ route('register') }}" class="btn-outline w-full justify-center py-3 text-sm">Pilih Paket</a>
            </div>

        </div>

        <p class="text-center text-xs text-crate-muted mt-6">
            💡 Harga bisa disesuaikan saat checkout. Bisa berhenti berlangganan kapan saja.
        </p>

    </div>
</section>


{{-- ════════════════════════════════════════
     TESTIMONIAL
════════════════════════════════════════ --}}
<section class="py-20 px-4 sm:px-6" style="background:linear-gradient(180deg,#F8F5F2 0%,#EDE0D4 100%);">
    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-12">
            <p class="text-crate-primary font-semibold text-sm uppercase tracking-widest mb-2">Testimoni</p>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-crate-text">Kata mereka 💬</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
            $testimonials = [
                ['name'=>'Rina S.',      'loc'=>'Jakarta',   'avatar'=>'R', 'rating'=>5, 'text'=>'"Awalnya skeptis, tapi ternyata kuratornya benar-benar paham selera aku. Semua item langsung cocok dipakai!"'],
                ['name'=>'Dinda A.',     'loc'=>'Surabaya',  'avatar'=>'D', 'rating'=>5, 'text'=>'"Returnya mudah banget. Pernah ada satu item yang kurang cocok, langsung diproses tanpa ribet. Recommended!"'],
                ['name'=>'Mega P.',      'loc'=>'Bandung',   'avatar'=>'M', 'rating'=>5, 'text'=>'"Hemat waktu banget! Gak perlu pusing milih baju lagi. Box-nya juga kemasannya cantik, sayang mau dibuka 😄"'],
            ];
            @endphp
            @foreach($testimonials as $t)
            <div class="testi-card">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-crate-primary text-white font-bold flex items-center justify-center text-sm shrink-0">
                        {{ $t['avatar'] }}
                    </div>
                    <div>
                        <p class="font-display font-semibold text-sm text-crate-text">{{ $t['name'] }}</p>
                        <p class="text-xs text-crate-muted">{{ $t['loc'] }}</p>
                    </div>
                    <div class="ml-auto flex gap-0.5">
                        @for($i = 0; $i < $t['rating']; $i++)
                        <span class="text-amber-400 text-sm">★</span>
                        @endfor
                    </div>
                </div>
                <p class="text-sm text-crate-muted leading-relaxed">{{ $t['text'] }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════
     FAQ
════════════════════════════════════════ --}}
<section id="faq" class="py-20 px-4 sm:px-6 bg-crate-bg">
    <div class="max-w-2xl mx-auto">

        <div class="text-center mb-12">
            <p class="text-crate-primary font-semibold text-sm uppercase tracking-widest mb-2">FAQ</p>
            <h2 class="font-display text-3xl font-extrabold text-crate-text">Pertanyaan umum</h2>
        </div>

        <div class="space-y-3">
            @php
            $faqs = [
                ['q'=>'Apakah saya bisa memilih item sendiri?',
                 'a'=>'Tidak perlu! Justru itu keunggulan Cratefit. Kamu cukup isi preferensi fashion sekali, lalu kurator kami yang bekerja memilihkan item terbaik untukmu.'],
                ['q'=>'Bagaimana proses returrnya?',
                 'a'=>'Jika ada item yang tidak sesuai, kamu bisa mengajukan retur melalui halaman Retur di aplikasi dalam batas waktu yang ditentukan. Kami akan menjemput item tersebut dari rumahmu.'],
                ['q'=>'Kapan box saya dikirim setelah berlangganan?',
                 'a'=>'Box biasanya disiapkan dalam 2–3 hari kerja setelah pendaftaran berhasil, kemudian dikirim oleh mitra ekspedisi kami. Kamu bisa memantau status pengiriman di halaman Status Box.'],
                ['q'=>'Apakah saya bisa berhenti berlangganan kapan saja?',
                 'a'=>'Ya, kamu bisa membatalkan langganan kapan saja melalui halaman Langganan tanpa biaya penalti apapun.'],
                ['q'=>'Kurator siapa yang akan memilihkan baju saya?',
                 'a'=>'Tim kurator Cratefit adalah para fashion enthusiast berpengalaman yang sudah melalui proses seleksi ketat. Mereka akan mencocokkan pilihan dengan data preferensi yang kamu isi.'],
            ];
            @endphp
            @foreach($faqs as $faq)
            <details class="faq-item card-wood p-5 group">
                <summary class="font-display font-semibold text-crate-text text-sm sm:text-base">
                    {{ $faq['q'] }}
                    <span class="faq-icon text-crate-muted ml-3 shrink-0">
                        <i data-lucide="plus" style="width:16px;height:16px"></i>
                    </span>
                </summary>
                <p class="mt-3 text-sm text-crate-muted leading-relaxed">{{ $faq['a'] }}</p>
            </details>
            @endforeach
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════
     CTA AKHIR
════════════════════════════════════════ --}}
<section class="py-20 px-4 sm:px-6" style="background:linear-gradient(135deg,#2B2B2B 0%,#3D2E25 100%);">
    <div class="max-w-2xl mx-auto text-center">
        <p class="font-script text-3xl text-crate-primary mb-3">Sudah siap?</p>
        <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-white mb-4">
            Mulai tampil stylish<br>mulai hari ini.
        </h2>
        <p class="text-gray-400 mb-8 text-sm sm:text-base">
            Daftar gratis sekarang — box pertamamu sudah menunggu.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            @if(Route::has('register'))
                <a href="{{ route('register') }}" class="btn-primary px-8 py-4 text-base justify-center">
                    Daftar Gratis Sekarang
                    <i data-lucide="arrow-right" style="width:16px;height:16px"></i>
                </a>
            @endif
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="btn-outline px-8 py-4 text-base justify-center" style="color:white;border-color:rgba(255,255,255,0.2);">
                    Sudah punya akun? Masuk
                </a>
            @endif
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════
     FOOTER
════════════════════════════════════════ --}}
<footer class="footer-gradient border-t border-crate-accent">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-20 h-10 overflow-hidden">
                    <img src="{{ asset('assets/imgs/cratefit-new-nobg.png') }}" alt="Cratefit" class="h-full w-full object-contain">
                </div>
                <p class="text-xs text-crate-muted">"Stylish tanpa ribet, hemat tanpa kehilangan style."</p>
            </div>
            <div class="flex gap-6 text-sm text-crate-muted">
                <a href="#cara-kerja" class="hover:text-crate-text transition-colors">Cara Kerja</a>
                <a href="#paket" class="hover:text-crate-text transition-colors">Paket</a>
                <a href="#faq" class="hover:text-crate-text transition-colors">FAQ</a>
                @if(Route::has('login'))
                    <a href="{{ route('login') }}" class="hover:text-crate-text transition-colors">Masuk</a>
                @endif
            </div>
        </div>
        <div class="mt-6 pt-6 border-t border-crate-accent text-center text-xs text-crate-muted">
            © {{ date('Y') }} Cratefit. All rights reserved.
        </div>
    </div>
</footer>

<script>lucide.createIcons();</script>

</body>
</html>