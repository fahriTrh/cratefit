<?php

namespace App\Http\Controllers;

use App\Models\Penghasilan;
use App\Models\TarifOperasional;
use Illuminate\Http\Request;

class PenghasilanController extends Controller
{
    // Admin: lihat rekap semua kurir & kurator
    public function index(Request $request)
    {
        $bulan  = $request->get('bulan', now()->format('Y-m'));
        $peran  = $request->get('peran', 'kurir');

        $rekap = Penghasilan::with('user', 'box')
            ->where('peran', $peran)
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$bulan])
            ->get()
            ->groupBy('user_id')
            ->map(function ($items) {
                return [
                    'user'  => $items->first()->user,
                    'total' => $items->sum('nominal'),
                    'jumlah_box' => $items->count(),
                    'detail' => $items,
                ];
            })
            ->values();

        $tarif = TarifOperasional::all()->keyBy('kunci');

        return view('admins.penghasilan', compact('rekap', 'bulan', 'peran', 'tarif'));
    }

    // Admin: update tarif
    public function updateTarif(Request $request)
    {
        $request->validate([
            'tarif_kurir'   => 'required|integer|min:0',
            'tarif_kurator' => 'required|integer|min:0',
        ]);

        TarifOperasional::where('kunci', 'tarif_kurir')
            ->update(['nominal' => $request->tarif_kurir]);

        TarifOperasional::where('kunci', 'tarif_kurator')
            ->update(['nominal' => $request->tarif_kurator]);

        return back()->with('success', 'Tarif berhasil diperbarui.');
    }

    // Kurir: lihat penghasilan sendiri
    public function kurir(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('Y-m'));

        $detail = Penghasilan::with('box')
            ->where('user_id', auth()->id())
            ->where('peran', 'kurir')
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$bulan])
            ->latest()
            ->get();

        $total = $detail->sum('nominal');

        return view('kurirs.penghasilan', compact('detail', 'total', 'bulan'));
    }

    // Kurator: lihat penghasilan sendiri
    public function kurator(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('Y-m'));

        $detail = Penghasilan::with('box')
            ->where('user_id', auth()->id())
            ->where('peran', 'kurator')
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$bulan])
            ->latest()
            ->get();

        $total = $detail->sum('nominal');

        return view('kurators.penghasilan', compact('detail', 'total', 'bulan'));
    }

}
