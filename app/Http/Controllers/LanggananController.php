<?php

namespace App\Http\Controllers;

use App\Models\Langganan;
use App\Models\PaketSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LanggananController extends Controller
{
    public function create()
    {
        $langganan = auth()->user()->langgananAktif()->with('paket')->first();

        // Kalau sudah punya langganan aktif, langsung ke halaman status
        if ($langganan) {
            return redirect('/status-box')->with('info', 'Kamu sudah memiliki langganan aktif.');
        }

        $pakets = PaketSubscription::where('aktif', true)
            ->orderBy('harga')
            ->get();

        return view('customers.langganan', compact('pakets'));
    }

    public function store(Request $request)
    {

        if (auth()->user()->langgananAktif()->exists()) {
            return redirect('/status-box')->with('info', 'Kamu sudah memiliki langganan aktif.');
        }

        // dd($request->all());
        $request->validate([
            'paket' => 'required|exists:paket_subscription,id',
            'periode'      => 'required|in:bulanan,2bulan,3bulan',
            'metode_bayar' => 'required|in:transfer_bank,ewallet,qris,cod',
            'setuju_syarat' => 'accepted',
        ]);

        // Cari paket berdasarkan slug
        $paket = PaketSubscription::where('id', $request->paket)
            ->where('aktif', true)
            ->firstOr(fn() => abort(422, 'Paket tidak tersedia.'));

        // Hitung tanggal pengiriman berikutnya
        $mulai = Carbon::today();
        $berikutnya = match ($request->periode) {
            'bulanan' => $mulai->copy()->addMonth(),
            '2bulan'  => $mulai->copy()->addMonths(2),
            '3bulan'  => $mulai->copy()->addMonths(3),
        };

        // Ambil alamat aktif user (sesuaikan dengan model alamat kamu)
        $alamat = auth()->user()->alamatPengiriman()
            ->where('is_primary', true)
            ->latest()
            ->first()
            ?? auth()->user()->alamatPengiriman()->latest()->firstOrFail();

        Langganan::create([
            'user_id'                      => auth()->id(),
            'paket_id'                     => $paket->id,
            'alamat_id'                    => $alamat->id,
            'periode'                      => $request->periode,
            'metode_bayar'                 => $request->metode_bayar,
            'status'                       => 'aktif',
            'tanggal_mulai'                => $mulai,
            'tanggal_pengiriman_berikutnya' => $berikutnya,
        ]);

        // Simulasi pembayaran — langsung redirect ke halaman sukses
        return redirect()->route('langganan.sukses')->with([
            'paket_nama'    => $paket->nama,
            'paket_harga'   => $paket->harga,
            'periode'       => $request->periode,
            'metode_bayar'  => $request->metode_bayar,
            'pengiriman'    => $berikutnya->translatedFormat('d F Y'),
        ]);
    }

    public function sukses()
    {
        // Kalau user langsung akses URL tanpa session, balik ke home
        if (!session('paket_nama')) {
            return redirect('/');
        }

        return view('customers.sukses');
    }

    public function statusBox()
    {
        $langganan = auth()->user()
            ->langgananAktif()
            ->with('paket', 'alamat')
            ->first();

        if (!$langganan) {
            return redirect('/langganan')->with('info', 'Kamu belum memiliki langganan aktif.');
        }

        return view('customers.status-box', compact('langganan'));
    }

    // LanggananController
    public function batalkan()
    {
        $langganan = auth()->user()->langgananAktif()->firstOrFail();
        $langganan->update([
            'status'         => 'dibatalkan',
            'tanggal_batal'  => now(),
        ]);

        return redirect('/langganan')->with('success', 'Langganan berhasil dibatalkan.');
    }
}
