<?php

namespace App\Http\Controllers;

use App\Models\Langganan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LanggananController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'paket'        => 'required|in:starter,style,premium',
            'periode'      => 'required|in:bulanan,2bulan,3bulan',
            'metode_bayar' => 'required|in:transfer_bank,ewallet,qris,cod',
            'setuju_syarat' => 'accepted',
        ]);

        // Cari paket berdasarkan slug
        $paket = \App\Models\PaketSubscription::where('slug', $request->paket)
            ->where('aktif', true)
            ->firstOrFail();

        // Hitung tanggal pengiriman berikutnya
        $mulai = Carbon::today();
        $berikutnya = match ($request->periode) {
            'bulanan' => $mulai->copy()->addMonth(),
            '2bulan'  => $mulai->copy()->addMonths(2),
            '3bulan'  => $mulai->copy()->addMonths(3),
        };

        // Ambil alamat aktif user (sesuaikan dengan model alamat kamu)
        $alamat = auth()->user()->alamatPengiriman()->latest()->firstOrFail();

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
}
