@extends('layouts.admin.app')
@section('title', 'Penghasilan')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="font-display text-2xl ">Rekap Penghasilan</h1>
        <p class="text-crate-text/50 text-sm font-body mt-1">Kelola tarif dan lihat rekap penghasilan kurir & kurator.</p>
    </div>

    {{-- Tarif Setting --}}
    <div class="card-wood rounded-2xl p-5">
        <h2 class="text-crate-text font-display text-base mb-4 flex items-center gap-2">
            <i data-lucide="settings" class="w-4 h-4 text-crate-primary"></i> Atur Tarif
        </h2>
        <form action="{{ route('admin.tarif.update') }}" method="POST" class="flex flex-wrap gap-4 items-end">
            @csrf
            <div>
                <label class="text-crate-text/50 text-xs font-body block mb-1">Tarif Kurir (per paket terkirim)</label>
                <div class="flex items-center gap-2">
                    <span class="text-crate-text/50 text-sm">Rp</span>
                    <input type="number" name="tarif_kurir" value="{{ $tarif['tarif_kurir']->nominal ?? 0 }}"
                           class="border border-crate-accent bg-white rounded-lg px-3 py-2 text-crate-text text-sm font-body w-36"
>
                </div>
            </div>
            <div>
                <label class="text-crate-text/50 text-xs font-body block mb-1">Tarif Kurator (per box dikurasi)</label>
                <div class="flex items-center gap-2">
                    <span class="text-crate-text/50 text-sm">Rp</span>
                    <input type="number" name="tarif_kurator" value="{{ $tarif['tarif_kurator']->nominal ?? 0 }}"
                           class="border border-crate-accent bg-white rounded-lg px-3 py-2 text-crate-text text-sm font-body w-36"
>
                </div>
            </div>
            <button type="submit"
                    class="px-4 py-2 bg-crate-primary hover:bg-crate-primary/80 text-white text-sm font-body rounded-lg transition-colors">
                Simpan Tarif
            </button>
        </form>
    </div>

    {{-- Filter --}}
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="text-crate-text/50 text-xs font-body block mb-1">Bulan</label>
            <input type="month" name="bulan" value="{{ $bulan }}"
                   class="border border-crate-accent bg-white rounded-lg px-3 py-2 text-crate-text text-sm font-body"
>
        </div>
        <div>
            <label class="text-crate-text/50 text-xs font-body block mb-1">Peran</label>
            <select name="peran" class="border border-crate-accent bg-white rounded-lg px-3 py-2 text-crate-text text-sm font-body"
>
                <option value="kurir"   {{ $peran === 'kurir'   ? 'selected' : '' }}>Kurir</option>
                <option value="kurator" {{ $peran === 'kurator' ? 'selected' : '' }}>Kurator</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-crate-primary hover:bg-crate-primary/80 text-white text-sm font-body rounded-lg transition-colors">
            Tampilkan
        </button>
    </form>

    {{-- Rekap Table --}}
    @if($rekap->isEmpty())
    <div class="text-center py-16 text-crate-text/50 font-body text-sm">
        Belum ada data penghasilan untuk periode ini.
    </div>
    @else
    <div class="card-wood rounded-2xl overflow-hidden">
        <table class="w-full text-sm font-body">
            <thead>
                <tr class="border-b border-crate-accent bg-crate-accent/30">

                    <th class="text-left px-5 py-3 text-crate-text/50 text-xs uppercase tracking-wider">Nama</th>
                    <th class="text-center px-5 py-3 text-crate-text/50 text-xs uppercase tracking-wider">Jumlah Box</th>
                    <th class="text-right px-5 py-3 text-crate-text/50 text-xs uppercase tracking-wider">Total Penghasilan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-crate-accent">
                @foreach($rekap as $r)
                <tr class="hover:bg-crate-accent/40 transition-colors">
                <td class="px-5 py-3 text-crate-text font-body">{{ $r['user']->name }}</td>
                <td class="px-5 py-3 text-center text-crate-text/50">{{ $r['jumlah_box'] }} box</td>
                <td class="px-5 py-3 text-right text-crate-primary font-medium">
                        Rp {{ number_format($r['total'], 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t border-crate-accent bg-crate-accent/30">
                    <td colspan="2" class="px-5 py-3 text-crate-text/50 text-xs font-body uppercase tracking-wider font-semibold">Total Keseluruhan</td>
                    <td class="px-5 py-3 text-right text-crate-primary font-display font-bold">
                        Rp {{ number_format($rekap->sum('total'), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

</div>
@endsection