<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cratefit Kurir — Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500;600&family=Caveat:wght@600&display=swap" rel="stylesheet">
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

        .card-wood {
            background: white;
            border: 1px solid #EDE0CC;
        }

        .card-wood::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3B1F0E, #C85A1A, #E07A3A, #3B1F0E);
        }

        .btn-primary {
            background: linear-gradient(135deg, #C85A1A, #E07A3A);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(200, 90, 26, 0.35);
        }

        .fade-in {
            animation: fadeUp 0.4s ease both;
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
    </style>
</head>

<body class="min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-crate-dark px-6 py-4 flex items-center justify-between sticky top-0 z-50 shadow-lg">
        <div class="flex items-center gap-3">
            <span class="font-script text-2xl text-crate-warm">Cratefit</span>
            <span class="text-crate-stone text-xs font-body tracking-widest uppercase">Portal Kurir</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-crate-stone text-sm font-body hidden sm:block">{{ $kurir->name }}</span>
            <form action="{{ route('kurir.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="border border-crate-stone/40 text-crate-stone hover:text-crate-warm
                               text-xs font-body px-3 py-1.5 rounded-lg transition-colors">
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8 fade-in">

        {{-- HEADER --}}
        <div class="mb-8">
            <p class="text-crate-orange font-script text-lg mb-1">Selamat datang,</p>
            <h1 class="font-display text-3xl text-crate-brown font-bold">{{ $kurir->name }}</h1>
            <p class="text-crate-stone font-body text-sm mt-1">Kelola pengiriman box Cratefit hari ini.</p>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
            <span class="text-lg">✅</span>
            <p class="text-green-700 text-sm font-body">{{ session('success') }}</p>
        </div>
        @endif

        {{-- STATISTIK --}}
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="relative card-wood rounded-2xl p-5 text-center overflow-hidden">
                <p class="text-3xl font-display font-bold text-crate-orange">{{ $boxSiapDikirim->count() }}</p>
                <p class="text-crate-stone text-xs font-body mt-1">Siap Dikirim</p>
            </div>
            <div class="relative card-wood rounded-2xl p-5 text-center overflow-hidden">
                <p class="text-3xl font-display font-bold text-blue-500">{{ $boxDalamPengiriman->count() }}</p>
                <p class="text-crate-stone text-xs font-body mt-1">Dalam Pengiriman</p>
            </div>
            <div class="relative card-wood rounded-2xl p-5 text-center overflow-hidden">
                <p class="text-3xl font-display font-bold text-emerald-500">{{ $riwayat->count() }}</p>
                <p class="text-crate-stone text-xs font-body mt-1">Selesai</p>
            </div>
        </div>

        {{-- BOX DALAM PENGIRIMAN --}}
        @if($boxDalamPengiriman->count() > 0)
        <div class="mb-8">
            <h2 class="font-display text-lg font-bold text-crate-brown mb-4">🚚 Sedang Dikirim</h2>
            <div class="space-y-4">
                @foreach($boxDalamPengiriman as $box)
                <div class="relative card-wood rounded-2xl p-5 overflow-hidden">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <p class="font-display font-bold text-crate-brown text-base">{{ $box->kode_box }}</p>
                            <p class="text-crate-stone text-sm font-body mt-0.5">{{ $box->pelanggan->name }}</p>
                            @if($box->langganan?->alamat)
                            <p class="text-crate-stone text-xs font-body mt-1 leading-relaxed max-w-sm">
                                📍 {{ $box->langganan->alamat->alamat_lengkap }},
                                {{ $box->langganan->alamat->kecamatan }},
                                {{ $box->langganan->alamat->kota }}
                            </p>
                            @endif
                            <p class="text-xs font-body mt-2">
                                <span class="text-crate-stone">Resi:</span>
                                <span class="font-semibold text-crate-brown">{{ $box->nomor_resi }}</span>
                                <span class="text-crate-stone ml-2">·</span>
                                <span class="text-crate-stone ml-2">{{ $box->ekspedisi }}</span>
                            </p>
                            <p class="text-xs text-crate-stone font-body mt-1">
                                Dikirim: {{ $box->tanggal_dikirim?->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                        <form action="{{ url('/kurir/box/' . $box->id . '/konfirmasi-tiba') }}" method="POST"
                            onsubmit="return confirm('Konfirmasi box sudah tiba di pelanggan?')">
                            @csrf
                            <button type="submit"
                                class="btn-primary text-white font-body font-semibold
                                           px-4 py-2.5 rounded-xl text-sm shadow">
                                ✅ Konfirmasi Tiba
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
            <h2 class="font-display text-lg font-bold text-crate-brown mb-4">📦 Siap Dikirim</h2>
            @if($boxSiapDikirim->count() === 0)
            <div class="relative card-wood rounded-2xl p-8 text-center overflow-hidden">
                <p class="text-4xl mb-3">📭</p>
                <p class="font-display font-bold text-crate-brown">Tidak ada box</p>
                <p class="text-crate-stone text-sm font-body mt-1">Semua box sudah diambil atau belum ada yang siap.</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach($boxSiapDikirim as $box)
                <div class="relative card-wood rounded-2xl p-5 overflow-hidden" x-data="{ open: false }">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <p class="font-display font-bold text-crate-brown text-base">{{ $box->kode_box }}</p>
                            <p class="text-crate-stone text-sm font-body mt-0.5">{{ $box->pelanggan->name }}</p>
                            @if($box->langganan?->alamat)
                            <p class="text-crate-stone text-xs font-body mt-1 leading-relaxed max-w-sm">
                                📍 {{ $box->langganan->alamat->alamat_lengkap }},
                                {{ $box->langganan->alamat->kecamatan }},
                                {{ $box->langganan->alamat->kota }}
                            </p>
                            @endif
                        </div>
                        <button type="button"
                            onclick="toggleForm('form-{{ $box->id }}')"
                            class="btn-primary text-white font-body font-semibold
                                       px-4 py-2.5 rounded-xl text-sm shadow shrink-0">
                            🚚 Ambil & Kirim
                        </button>
                    </div>

                    {{-- Form input resi (tersembunyi, muncul saat klik) --}}
                    <div id="form-{{ $box->id }}" class="hidden mt-4 pt-4 border-t border-crate-sand">
                        <form action="{{ url('/kurir/box/' . $box->id . '/ambil') }}" method="POST">
                            @csrf

                            @if($box->nomor_resi)
                            {{-- Resi sudah diisi kurator, tampilkan saja --}}
                            <div class="mb-3 p-3 bg-crate-cream rounded-xl border border-crate-sand">
                                <p class="text-xs font-body text-crate-stone">Nomor resi sudah diisi kurator:</p>
                                <p class="font-semibold text-crate-brown text-sm mt-0.5">{{ $box->nomor_resi }}</p>
                            </div>
                            @endif

                            <div class="grid sm:grid-cols-2 gap-3 mb-3">
                                @if(!$box->nomor_resi)
                                <div>
                                    <label class="block text-xs font-body font-semibold text-crate-brown/70
                               uppercase tracking-wider mb-1">Nomor Resi</label>
                                    <input type="text" name="nomor_resi"
                                        id="resi-{{ $box->id }}"
                                        placeholder="Contoh: JNE123456789"
                                        class="w-full px-3 py-2.5 border border-crate-sand rounded-xl
                              text-sm font-body text-crate-brown bg-crate-cream
                              focus:outline-none focus:border-crate-orange">
                                </div>
                                @endif
                                <div>
                                    <label class="block text-xs font-body font-semibold text-crate-brown/70
                               uppercase tracking-wider mb-1">Ekspedisi</label>
                                    <select name="ekspedisi" required
                                        onchange="toggleResi(this, 'resi-{{ $box->id }}')"
                                        class="w-full px-3 py-2.5 border border-crate-sand rounded-xl
                               text-sm font-body text-crate-brown bg-crate-cream
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
                       px-5 py-2.5 rounded-xl text-sm shadow">
                                Konfirmasi Pengiriman →
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- RIWAYAT --}}
        @if($riwayat->count() > 0)
        <div class="mb-8">
            <h2 class="font-display text-lg font-bold text-crate-brown mb-4">📋 Riwayat Terakhir</h2>
            <div class="relative card-wood rounded-2xl overflow-hidden">
                <table class="w-full text-sm font-body">
                    <thead class="bg-crate-cream">
                        <tr>
                            <th class="text-left px-5 py-3 text-crate-brown/70 font-semibold text-xs uppercase tracking-wider">Kode Box</th>
                            <th class="text-left px-5 py-3 text-crate-brown/70 font-semibold text-xs uppercase tracking-wider">Pelanggan</th>
                            <th class="text-left px-5 py-3 text-crate-brown/70 font-semibold text-xs uppercase tracking-wider hidden sm:table-cell">Tiba</th>
                            <th class="text-left px-5 py-3 text-crate-brown/70 font-semibold text-xs uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-crate-sand">
                        @foreach($riwayat as $box)
                        <tr>
                            <td class="px-5 py-3 font-semibold text-crate-brown">{{ $box->kode_box }}</td>
                            <td class="px-5 py-3 text-crate-stone">{{ $box->pelanggan->name }}</td>
                            <td class="px-5 py-3 text-crate-stone hidden sm:table-cell">
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

</body>

</html>