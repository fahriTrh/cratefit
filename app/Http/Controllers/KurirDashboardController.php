<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;

class KurirDashboardController extends Controller
{
    public function index()
    {
        $kurir = auth()->user();

        // Box siap dikirim (belum diambil kurir manapun atau milik kurir ini)
        $boxSiapDikirim = Box::with(['pelanggan', 'langganan.alamat'])
            ->where('status', 'siap_dikirim')
            ->latest()
            ->get();

        // Box yang sedang dikirim oleh kurir ini
        $boxDalamPengiriman = Box::with(['pelanggan', 'langganan.alamat'])
            ->where('status', 'dalam_pengiriman')
            ->where('kurir_id', $kurir->id)
            ->latest()
            ->get();

        // Riwayat box yang sudah tiba/selesai oleh kurir ini
        $riwayat = Box::with(['pelanggan'])
            ->where('kurir_id', $kurir->id)
            ->whereIn('status', ['tiba', 'selesai'])
            ->latest()
            ->limit(10)
            ->get();

        return view('kurirs.dashboard', compact(
            'kurir',
            'boxSiapDikirim',
            'boxDalamPengiriman',
            'riwayat'
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
            // Pakai resi dari kurator kalau sudah ada, kalau tidak pakai input kurir
            'nomor_resi'      => $box->nomor_resi ?? ($request->ekspedisi === 'Kurir Internal' ? null : $request->nomor_resi),
            'ekspedisi'       => $request->ekspedisi,
            'tanggal_dikirim' => now(),
        ]);

        return redirect('/kurir/dashboard')
            ->with('success', 'Box ' . $box->kode_box . ' berhasil diambil dan status diperbarui.');
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

        return redirect('/kurir/dashboard')
            ->with('success', 'Box ' . $box->kode_box . ' dikonfirmasi sudah tiba.');
    }
}
