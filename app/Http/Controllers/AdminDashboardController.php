<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\InventoryItem;
use App\Models\Langganan;
use App\Models\Retur;
use App\Models\User;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── Statistik Pengguna ──────────────────────────────────────────
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $totalKurator   = User::where('role', 'kurator')->count();
        $totalKurir     = User::where('role', 'kurir')->count();
 
        // Pelanggan baru bulan ini
        $pelangganBaruBulanIni = User::where('role', 'pelanggan')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
 
        // ── Statistik Langganan ─────────────────────────────────────────
        $totalLanggananAktif = Langganan::where('status', 'aktif')->count();
        $totalLanggananBatal = Langganan::where('status', 'batal')->count();
 
        // Langganan baru bulan ini
        $langgananBaruBulanIni = Langganan::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
 
        // ── Statistik Box ───────────────────────────────────────────────
        $totalBoxMenunggu  = Box::where('status', 'menunggu_kurasi')->count();
        $totalBoxDikurasi  = Box::where('status', 'sedang_dikurasi')->count();
        $totalBoxDikirim   = Box::where('status', 'dikirim')->count();
        $totalBoxSelesai   = Box::where('status', 'tiba')->count();
 
        // ── Statistik Inventory ─────────────────────────────────────────
        $totalInventory    = InventoryItem::count();
        $stokHabis         = InventoryItem::where('stok', 0)->count();
        $stokRendah        = InventoryItem::where('stok', '>', 0)->where('stok', '<=', 5)->count();
 
        // ── Statistik Retur ─────────────────────────────────────────────
        $totalReturMenunggu = Retur::where('status', 'menunggu')->count();
        $totalReturProses   = Retur::whereIn('status', ['diproses', 'dijemput'])->count();
        $totalReturSelesai  = Retur::where('status', 'selesai')->count();
 
        // ── Aktivitas Terbaru ───────────────────────────────────────────
        $boxTerbaru = Box::with(['pelanggan', 'kurator'])
            ->latest()
            ->limit(6)
            ->get();
 
        $returTerbaru = Retur::with('user')
            ->latest()
            ->limit(5)
            ->get();
 
        $pelangganTerbaru = User::where('role', 'pelanggan')
            ->latest()
            ->limit(5)
            ->get();
 
        // ── Data Grafik Langganan 6 Bulan Terakhir ──────────────────────
        $grafikLangganan = collect(range(5, 0))->map(function ($bulanLalu) {
            $tanggal = Carbon::now()->subMonths($bulanLalu);
            return [
                'bulan' => $tanggal->translatedFormat('M'),
                'total' => Langganan::whereMonth('created_at', $tanggal->month)
                    ->whereYear('created_at', $tanggal->year)
                    ->count(),
            ];
        });
 
        return view('admins.dashboard', compact(
            'totalPelanggan',
            'totalKurator',
            'totalKurir',
            'pelangganBaruBulanIni',
            'totalLanggananAktif',
            'totalLanggananBatal',
            'langgananBaruBulanIni',
            'totalBoxMenunggu',
            'totalBoxDikurasi',
            'totalBoxDikirim',
            'totalBoxSelesai',
            'totalInventory',
            'stokHabis',
            'stokRendah',
            'totalReturMenunggu',
            'totalReturProses',
            'totalReturSelesai',
            'boxTerbaru',
            'returTerbaru',
            'pelangganTerbaru',
            'grafikLangganan'
        ));
    }

}
