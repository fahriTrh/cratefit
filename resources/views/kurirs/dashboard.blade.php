<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit Kurir — Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Caveat:wght@600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'crate-primary': '#D8A98C',
                        'crate-accent':  '#E9D8CC',
                        'crate-bg':      '#F8F5F2',
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

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        .card-wood {
            background: #FFFFFF;
            border: 1px solid #E9D8CC;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        }

        .card-wood::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: #D8A98C;
        }

        .btn-primary {
            background: #D8A98C;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(216, 169, 140, 0.35);
        }

        .fade-in {
            animation: fadeUp 0.4s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-white px-6 py-2 flex items-center justify-between sticky top-0 z-50 shadow-sm" style="border-bottom:1px solid #E9D8CC">
        <div class="flex items-center gap-3">
            <div class="h-20 flex items-center">
                <img
                    class="h-full w-auto object-contain"
                    src="{{ asset('assets/imgs/cratefit-new-nobg.png') }}"
                    alt="Cratefit">
            </div>
            <span class="text-crate-text/40 text-xs font-body tracking-widest uppercase">Portal Kurir</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-crate-text/60 text-sm font-body hidden sm:block">{{ $kurir->name }}</span>
            <form action="{{ route('kurir.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="border border-crate-accent text-crate-text/50 hover:text-red-500 hover:border-red-200
                        text-xs font-body px-3 py-1.5 rounded-lg transition-colors">
                    Keluar
                </button>
            </form>
        </div>
    </nav>


    <div class="max-w-4xl mx-auto px-4 py-8 fade-in">

        {{-- HEADER --}}
        <div class="mb-8">
            <p class="text-crate-primary font-script text-lg mb-1">Selamat datang,</p>
            <h1 class="font-display text-3xl text-crate-text font-bold">{{ $kurir->name }}</h1>
            <p class="text-crate-text/50 font-body text-sm mt-1">Kelola pengiriman box Cratefit hari ini.</p>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            <p class="text-green-700 text-sm font-body">{{ session('success') }}</p>
        </div>
        @endif

        {{-- STATISTIK --}}
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="relative card-wood rounded-2xl p-5 text-center overflow-hidden">
                <p class="text-3xl font-display font-bold text-crate-primary">{{ $boxSiapDikirim->count() }}</p>
                <p class="text-crate-text/50 text-xs font-body mt-1">Siap Dikirim</p>
            </div>
            <div class="relative card-wood rounded-2xl p-5 text-center overflow-hidden">
                <p class="text-3xl font-display font-bold text-blue-500">{{ $boxDalamPengiriman->count() }}</p>
                <p class="text-crate-text/50 text-xs font-body mt-1">Dalam Pengiriman</p>
            </div>
            <div class="relative card-wood rounded-2xl p-5 text-center overflow-hidden">
                <p class="text-3xl font-display font-bold text-emerald-500">{{ $riwayat->count() }}</p>
                <p class="text-crate-text/50 text-xs font-body mt-1">Selesai</p>
            </div>
        </div>

        {{-- BOX DALAM PENGIRIMAN --}}
        @if($boxDalamPengiriman->count() > 0)
        <div class="mb-8">
            <h2 class="font-display text-lg font-bold text-crate-text mb-4 flex items-center gap-2">
                <i data-lucide="truck" class="w-5 h-5 text-crate-primary"></i> Sedang Dikirim
            </h2>
            <div class="space-y-4">
                @foreach($boxDalamPengiriman as $box)
                <div class="relative card-wood rounded-2xl p-5 overflow-hidden">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <p class="font-display font-bold text-crate-text text-base">{{ $box->kode_box }}</p>
                            <p class="text-crate-text/50 text-sm font-body mt-0.5">{{ $box->pelanggan->name }}</p>
                            @if($box->langganan?->alamat)
                            <p class="text-crate-text/50 text-xs font-body mt-1 leading-relaxed max-w-sm flex gap-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0 mt-0.5"></i> {{ $box->langganan->alamat->alamat_lengkap }},
                                {{ $box->langganan->alamat->kecamatan }},
                                {{ $box->langganan->alamat->kota }}
                            </p>
                            @endif
                            <p class="text-xs font-body mt-2">
                                <span class="text-crate-text/50">Resi:</span>
                                <span class="font-semibold text-crate-text">{{ $box->nomor_resi }}</span>
                                <span class="text-crate-text/50 ml-2">·</span>
                                <span class="text-crate-text/50 ml-2">{{ $box->ekspedisi }}</span>
                            </p>
                            <p class="text-xs text-crate-text/50 font-body mt-1">
                                Dikirim: {{ $box->tanggal_dikirim?->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                        <form action="{{ url('/kurir/box/' . $box->id . '/konfirmasi-tiba') }}" method="POST"
                            onsubmit="return confirm('Konfirmasi box sudah tiba di pelanggan?')">
                            @csrf
                            <button type="submit"
                                class="btn-primary text-white font-body font-semibold
                                        px-4 py-2.5 rounded-xl text-sm shadow flex items-center gap-2">
                                <i data-lucide="check-circle" class="w-4 h-4"></i> Konfirmasi Tiba
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- BOX SIAP DIKIRIM --}}
        <div class="mb-8">
            <h2 class="font-display text-lg font-bold text-crate-text mb-4 flex items-center gap-2">
                <i data-lucide="package" class="w-5 h-5 text-crate-primary"></i> Siap Dikirim
            </h2>
            @if($boxSiapDikirim->count() === 0)
            <div class="relative card-wood rounded-2xl p-8 text-center overflow-hidden">
                <div class="mb-3 flex justify-center">
                    <i data-lucide="inbox" class="w-10 h-10 text-crate-text/50"></i>
                </div>
                <p class="font-display font-bold text-crate-text">Tidak ada box</p>
                <p class="text-crate-text/50 text-sm font-body mt-1">Semua box sudah diambil atau belum ada yang siap.</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach($boxSiapDikirim as $box)
                <div class="relative card-wood rounded-2xl p-5 overflow-hidden" x-data="{ open: false }">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <p class="font-display font-bold text-crate-text text-base">{{ $box->kode_box }}</p>
                            <p class="text-crate-text/50 text-sm font-body mt-0.5">{{ $box->pelanggan->name }}</p>
                            @if($box->langganan?->alamat)
                            <p class="text-crate-text/50 text-xs font-body mt-1 leading-relaxed max-w-sm">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0 mt-0.5"></i> {{ $box->langganan->alamat->alamat_lengkap }},
                                {{ $box->langganan->alamat->kecamatan }},
                                {{ $box->langganan->alamat->kota }}
                            </p>
                            @endif
                        </div>
                        <button type="button"
                            onclick="toggleForm('form-{{ $box->id }}')"
                            class="btn-primary text-white font-body font-semibold
                                    px-4 py-2.5 rounded-xl text-sm shadow shrink-0 flex items-center gap-2">
                            <i data-lucide="truck" class="w-4 h-4"></i> Ambil & Kirim
                        </button>
                    </div>

                    {{-- Form input resi (tersembunyi, muncul saat klik) --}}
                    <div id="form-{{ $box->id }}" class="hidden mt-4 pt-4 border-t border-crate-accent">
                        <form action="{{ url('/kurir/box/' . $box->id . '/ambil') }}" method="POST">
                            @csrf

                            @if($box->nomor_resi)
                            {{-- Resi sudah diisi kurator, tampilkan saja --}}
                            <div class="mb-3 p-3 bg-crate-accent rounded-xl border border-crate-accent">
                                <p class="text-xs font-body text-crate-text/50">Nomor resi sudah diisi kurator:</p>
                                <p class="font-semibold text-crate-text text-sm mt-0.5">{{ $box->nomor_resi }}</p>
                            </div>
                            @endif

                            <div class="grid sm:grid-cols-2 gap-3 mb-3">
                                @if(!$box->nomor_resi)
                                <div>
                                    <label class="block text-xs font-body font-semibold text-crate-text/70
                               uppercase tracking-wider mb-1">Nomor Resi</label>
                                    <input type="text" name="nomor_resi"
                                        id="resi-{{ $box->id }}"
                                        placeholder="Contoh: JNE123456789"
                                        class="w-full px-3 py-2.5 border border-crate-accent rounded-xl
                              text-sm font-body text-crate-text bg-crate-accent
                              focus:outline-none focus:border-crate-orange">
                                </div>
                                @endif
                                <div>
                                    <label class="block text-xs font-body font-semibold text-crate-text/70
                               uppercase tracking-wider mb-1">Ekspedisi</label>
                                    <select name="ekspedisi" required
                                        onchange="toggleResi(this, 'resi-{{ $box->id }}')"
                                        class="w-full px-3 py-2.5 border border-crate-accent rounded-xl
                               text-sm font-body text-crate-text bg-crate-accent
                               focus:outline-none focus:border-crate-orange">
                                        <option value="">Pilih ekspedisi</option>
                                        <option value="JNE">JNE</option>
                                        <option value="J&T">J&T</option>
                                        <option value="SiCepat">SiCepat</option>
                                        <option value="AnterAja">AnterAja</option>
                                        <option value="Ninja Xpress">Ninja Xpress</option>
                                        <option value="Pos Indonesia">Pos Indonesia</option>
                                        <option value="Kurir Internal">Kurir Internal</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn-primary text-white font-body font-semibold
                                    px-5 py-2.5 rounded-xl text-sm shadow flex items-center gap-2">
                                Konfirmasi Pengiriman <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ─── RETUR PICKUP ─────────────────────────────── --}}
        @if($returPickup->count() > 0)
        <div class="mb-8">
            <h2 class="font-display text-xl text-crate-text font-bold mb-4 flex items-center gap-2">
                <i data-lucide="undo-2" class="w-5 h-5 text-crate-primary"></i> Penjemputan Retur
            </h2>
            <div class="space-y-4">
                @foreach($returPickup as $retur)
                <div class="card-wood relative rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div>
                            <p class="font-body font-semibold text-crate-text">{{ $retur->kode_retur }}</p>
                            <p class="text-crate-text/50 text-xs font-body mt-0.5">
                                {{ $retur->user?->name }} · Box #{{ $retur->box?->kode_box }}
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs
                            font-body font-semibold bg-blue-100 text-blue-700 border border-blue-200 shrink-0">
                            <i data-lucide="truck" class="w-3.5 h-3.5"></i> Perlu Dijemput
                        </span>
                    </div>
                    <p class="text-crate-text/50 text-xs font-body mb-4 flex items-start gap-1">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 shrink-0 mt-0.5"></i> Alamat: {{ $retur->box?->langganan?->alamat?->alamat_lengkap ?? 'Lihat detail pelanggan' }}
                    </p>
                    <form action="{{ url('/kurir/retur/' . $retur->id . '/konfirmasi-jemput') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="btn-primary text-white font-body font-semibold px-5 py-2.5
                            rounded-xl text-sm shadow flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4"></i> Konfirmasi Sudah Dijemput
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- RIWAYAT --}}
        @if($riwayat->count() > 0)
        <div class="mb-8">
            <h2 class="font-display text-lg font-bold text-crate-text mb-4 flex items-center gap-2">
                <i data-lucide="clipboard-list" class="w-5 h-5 text-crate-primary"></i> Riwayat Terakhir
            </h2>
            <div class="relative card-wood rounded-2xl overflow-hidden">
                <table class="w-full text-sm font-body">
                    <thead class="bg-crate-accent">
                        <tr>
                            <th class="text-left px-5 py-3 text-crate-text/70 font-semibold text-xs uppercase tracking-wider">Kode Box</th>
                            <th class="text-left px-5 py-3 text-crate-text/70 font-semibold text-xs uppercase tracking-wider">Pelanggan</th>
                            <th class="text-left px-5 py-3 text-crate-text/70 font-semibold text-xs uppercase tracking-wider hidden sm:table-cell">Tiba</th>
                            <th class="text-left px-5 py-3 text-crate-text/70 font-semibold text-xs uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-crate-accent">
                        @foreach($riwayat as $box)
                        <tr>
                            <td class="px-5 py-3 font-semibold text-crate-text">{{ $box->kode_box }}</td>
                            <td class="px-5 py-3 text-crate-text/50">{{ $box->pelanggan->name }}</td>
                            <td class="px-5 py-3 text-crate-text/50 hidden sm:table-cell">
                                {{ $box->tanggal_tiba?->translatedFormat('d F Y') ?? '-' }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                             {{ $box->status === 'selesai'
                                                ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                                : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                    {{ $box->status === 'selesai' ? 'Selesai' : 'Sudah Tiba' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>

    <script>
        function toggleForm(id) {
            const el = document.getElementById(id);
            el.classList.toggle('hidden');
        }
    </script>
    <script>lucide.createIcons();</script>


</body>

</html>