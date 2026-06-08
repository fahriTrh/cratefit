<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Retur;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReturController extends Controller
{
    public function index()
    {
        $returs = Retur::with('user', 'box', 'kurir')
            ->latest()
            ->get()
            ->map(fn($r) => $this->formatRetur($r))
            ->toArray();

        $kurirList = User::where('role', 'kurir')
            ->where('status', 'aktif')
            ->get(['id', 'name']);

        return view('admins.kelola-retur', compact('returs', 'kurirList'));
    }

    public function proses($id)
    {
        $retur = Retur::findOrFail($id);

        if ($retur->status !== 'diajukan') {
            return back()->with('error', 'Status tidak valid untuk diproses.');
        }

        $retur->update(['status' => 'diproses']);
        return back()->with('success', "Retur {$retur->kode_retur} sedang diproses.");
    }

    public function assignKurir(Request $request, $id)
    {
        $request->validate(['kurir_id' => 'required|exists:users,id']);

        $retur = Retur::findOrFail($id);

        if ($retur->metode_pengembalian !== 'pickup') {
            return back()->with('error', 'Assign kurir hanya untuk metode pickup.');
        }

        if (!in_array($retur->status, ['diajukan', 'diproses'])) {
            return back()->with('error', 'Status tidak valid untuk assign kurir.');
        }

        $retur->update([
            'kurir_id' => $request->kurir_id,
            'status'   => 'diproses',
        ]);

        return back()->with('success', "Kurir berhasil di-assign ke retur {$retur->kode_retur}.");
    }

    public function selesai($id)
    {
        $retur = Retur::findOrFail($id);

        if (!in_array($retur->status, ['diajukan', 'diproses'])) {
            return back()->with('error', 'Status tidak valid untuk diselesaikan.');
        }

        // Restock inventory
        foreach ($retur->item_retur as $itemId) {
            $item = InventoryItem::find($itemId);
            if ($item) {
                $item->increment('stok');
            }
        }

        $retur->update(['status' => 'selesai']);
        return back()->with('success', "Retur {$retur->kode_retur} selesai. Stok inventory diperbarui.");
    }

    public function tolak(Request $request, $id)
    {
        $request->validate(['catatan_admin' => 'required|string|max:500']);

        $retur = Retur::findOrFail($id);

        if (!in_array($retur->status, ['diajukan', 'diproses'])) {
            return back()->with('error', 'Status tidak valid untuk ditolak.');
        }

        $retur->update([
            'status'        => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', "Retur {$retur->kode_retur} ditolak.");
    }

    private function formatRetur(Retur $r): array
    {
        $alasanMap = [
            'tidak_cocok_ukuran' => 'Tidak Cocok Ukuran',
            'tidak_suka_style'   => 'Tidak Suka Gaya',
            'kualitas_kurang'    => 'Kualitas Kurang',
            'warna_tidak_sesuai' => 'Warna Tidak Sesuai',
            'kondisi_rusak'      => 'Kondisi Rusak/Cacat',
            'lainnya'            => 'Lainnya',
        ];

        $namaItems = collect($r->item_retur)->map(
            fn($id) => InventoryItem::find($id)?->nama ?? 'Item #' . $id
        )->toArray();

        return [
            'id'            => $r->id,
            'kode'          => $r->kode_retur,
            'pelanggan'     => [
                'nama'   => $r->user?->name ?? '-',
                'email'  => $r->user?->email ?? '-',
                'avatar' => strtoupper(substr($r->user?->name ?? 'X', 0, 1)),
            ],
            'box'           => $r->box?->kode_box ?? '-',
            'items'         => $namaItems,
            'alasan'        => $alasanMap[$r->alasan_retur] ?? $r->alasan_retur,
            'catatan'       => $r->catatan_retur,
            'metode'        => $r->metode_pengembalian,
            'status'        => $r->status,
            'tanggal'       => $r->created_at->format('d M Y'),
            'catatan_admin' => $r->catatan_admin,
            'kurir'         => $r->kurir?->name,
            'tanggal_dijemput' => $r->tanggal_dijemput?->format('d M Y H:i'),
        ];
    }
}
