<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghasilan Saya</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
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
        }

        .btn-primary:hover {
            opacity: .9;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="bg-[#2A1508] px-6 py-4 flex items-center justify-between sticky top-0 z-50 shadow-lg">
        <div class="flex items-center gap-3">
            <span class="text-orange-400 text-2xl font-bold">Cratefit</span>
            <span class="text-stone-300 text-xs uppercase tracking-widest">Portal Kurir</span>
        </div>

        <div class="flex items-center gap-4">
            <span class="text-stone-300 text-sm">{{ auth()->user()->name }}</span>

            <form action="{{ route('kurir.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="border border-stone-400 text-stone-300 hover:text-orange-300 text-xs px-3 py-1.5 rounded-lg">
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#3B1F0E]">Penghasilan Saya</h1>
            <p class="text-gray-500 mt-1">
                Rekap penghasilan per bulan berdasarkan paket yang berhasil diantar.
            </p>
        </div>

        {{-- FILTER BULAN --}}
        <div class="relative card-wood rounded-2xl p-5 mb-6 overflow-hidden">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">
                        Pilih Bulan
                    </label>

                    <input type="month"
                        name="bulan"
                        value="{{ $bulan }}"
                        class="border rounded-xl px-3 py-2">
                </div>

                <button type="submit"
                    class="btn-primary text-white px-4 py-2 rounded-xl">
                    Tampilkan
                </button>
            </form>
        </div>

        {{-- TOTAL --}}
        <div class="relative card-wood rounded-2xl p-6 mb-6 overflow-hidden">
            <div class="flex justify-between items-center flex-wrap gap-4">

                <div>
                    <p class="text-xs uppercase text-gray-500">
                        Total Bulan Ini
                    </p>

                    <h2 class="text-4xl font-bold text-orange-600 mt-2">
                        Rp {{ number_format($total,0,',','.') }}
                    </h2>
                </div>

                <div class="text-right">
                    <p class="text-xs text-gray-500">
                        Jumlah Pengiriman
                    </p>

                    <p class="text-2xl font-bold text-[#3B1F0E] mt-2">
                        {{ $detail->count() }} Box
                    </p>
                </div>

            </div>
        </div>

        {{-- DETAIL PENGHASILAN --}}
        @if($detail->isEmpty())

            <div class="relative card-wood rounded-2xl p-10 text-center overflow-hidden">
                <p class="text-gray-500">
                    Belum ada penghasilan pada bulan ini.
                </p>
            </div>

        @else

            <div class="relative card-wood rounded-2xl overflow-hidden">

                <table class="w-full text-sm">
                    <thead class="bg-orange-50">
                        <tr>
                            <th class="text-left px-5 py-3">Kode Box</th>
                            <th class="text-left px-5 py-3">Tanggal</th>
                            <th class="text-right px-5 py-3">Nominal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($detail as $item)
                        <tr class="border-t">
                            <td class="px-5 py-3 font-semibold">
                                {{ $item->box->kode_box }}
                            </td>

                            <td class="px-5 py-3 text-gray-600">
                                {{ $item->created_at->format('d M Y') }}
                            </td>

                            <td class="px-5 py-3 text-right font-semibold text-green-600">
                                Rp {{ number_format($item->nominal,0,',','.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        @endif

    </div>

</body>
</html>