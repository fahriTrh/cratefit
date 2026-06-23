@extends('layouts.kurator.App') {{-- sesuaikan layout --}}
@section('title', 'Penghasilan Saya')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl ">Penghasilan Saya</h1>
        <p class="text-crate-stone text-sm font-body mt-1">Rekap penghasilan per bulan berdasarkan paket yang berhasil diantar.</p>
    </div>

    <form method="GET" class="flex gap-3 items-end">
        <div>
            <label class="text-crate-stone text-xs font-body block mb-1">Pilih Bulan</label>
            <input type="month" name="bulan" value="{{ $bulan }}"
                   class="bg-white/10 border border-white/20 rounded-lg px-3 py-2  text-sm font-body focus:outline-none focus:border-crate-orange">
        </div>
        <button type="submit" class="px-4 py-2 bg-crate-orange hover:bg-crate-amber text-white text-sm font-body rounded-lg transition-colors">
            Tampilkan
        </button>
    </form>

    {{-- Summary --}}
    <div class="bg-crate-orange/10 border border-crate-orange/20 rounded-2xl p-5 flex items-center justify-between">
        <div>
            <p class="text-crate-stone text-xs font-body uppercase tracking-wider">Total Bulan Ini</p>
            <p class="text-crate-warm font-display font-bold text-3xl mt-1">Rp {{ number_format($total, 0, ',', '.') }}</p>
        </div>
        <div class="text-right">
            <p class="text-crate-stone text-xs font-body">Jumlah Pengiriman</p>
            <p class=" font-display font-bold text-xl mt-1">{{ $detail->count() }} box</p>
        </div>
    </div>

    {{-- Detail --}}
    @if($detail->isEmpty())
    <div class="text-center py-12 text-crate-stone font-body text-sm">Belum ada penghasilan bulan ini.</div>
    @else
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
        <table class="w-full text-sm font-body">
            <thead>
                <tr class="border-b border-white/10">
                    <th class="text-left px-5 py-3 text-crate-stone text-xs uppercase tracking-wider">Kode Box</th>
                    <th class="text-left px-5 py-3 text-crate-stone text-xs uppercase tracking-wider">Tanggal</th>
                    <th class="text-right px-5 py-3 text-crate-stone text-xs uppercase tracking-wider">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($detail as $item)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-5 py-3 ">{{ $item->box->kode_box }}</td>
                    <td class="px-5 py-3 text-crate-stone">{{ $item->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-right text-crate-warm">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection