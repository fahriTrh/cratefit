<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\Retur;

class KurirDashboardController extends Controller
{
    public function index()
    {
        $kurir = auth()->user();

        $boxSiapDikirim = Box::with(['pelanggan', 'langganan.alamat'])
            ->where('status', 'siap_dikirim')
            ->latest()
            ->get();

        $boxDalamPengiriman = Box::with(['pelanggan', 'langganan.alamat'])
            ->where('status', 'dalam_pengiriman')
            ->where('kurir_id', $kurir->id)
            ->latest()
            ->get();

        $riwayat = Box::with(['pelanggan'])
            ->where('kurir_id', $kurir->id)
            ->whereIn('status', ['tiba', 'selesai'])
            ->latest()
            ->limit(10)
            ->get();

        // Retur pickup yang di-assign ke kurir ini
        $returPickup = Retur::with('user', 'box')
            ->where('kurir_id', $kurir->id)
            ->where('metode_pengembalian', 'pickup')
            ->where('status', 'diproses')
            ->whereNull('tanggal_dijemput')
            ->latest()
            ->get();

        return view('kurirs.dashboard', compact(
            'kurir',
            'boxSiapDikirim',
            'boxDalamPengiriman',
            'riwayat',
            'returPickup'
        ));
    }

    public function ambilBox(Request $request, $boxId)
    {
        $box = Box::where('status', 'siap_dikirim')->findOrFail($boxId);

        $request->validate([
            'nomor_resi' => 'nullable|string|max:100',
            'ekspedisi'  => 'required|string|max:100',
        ]);

        $box->update([
            'status'          => 'dalam_pengiriman',
            'kurir_id'        => auth()->id(),
            'nomor_resi'      => $box->nomor_resi ?? ($request->ekspedisi === 'Kurir Internal' ? null : $request->nomor_resi),
            'ekspedisi'       => $request->ekspedisi,
            'tanggal_dikirim' => now(),
        ]);

        return redirect('/kurir/dashboard')
            ->with('success', 'Box ' . $box->kode_box . ' berhasil diambil.');
    }

    public function konfirmasiTiba($boxId)
    {
        $box = Box::where('status', 'dalam_pengiriman')
            ->where('kurir_id', auth()->id())
            ->findOrFail($boxId);

        $box->update([
            'status'       => 'tiba',
            'tanggal_tiba' => now(),
        ]);

        \App\Models\Penghasilan::create([
            'user_id'    => auth()->id(),
            'box_id'     => $box->id,
            'peran'      => 'kurir',
            'nominal'    => \App\Models\TarifOperasional::get('tarif_kurir'),
            'keterangan' => 'Pengiriman box ' . $box->kode_box,
        ]);

        return redirect('/kurir/dashboard')
            ->with('success', 'Box ' . $box->kode_box . ' dikonfirmasi sudah tiba.');
    }

    public function konfirmasiJemputRetur($id)
    {
        $retur = Retur::where('kurir_id', auth()->id())
            ->where('status', 'diproses')
            ->where('metode_pengembalian', 'pickup')
            ->whereNull('tanggal_dijemput')
            ->findOrFail($id);

        $retur->update([
            'tanggal_dijemput' => now(),
        ]);

        return redirect('/kurir/dashboard')
            ->with('success', 'Item retur ' . $retur->kode_retur . ' berhasil dijemput.');
    }

}
