<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\InventoryItem;
use App\Models\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $boxTerakhir = Box::where('user_id', $user->id)
            ->whereIn('status', ['tiba', 'selesai'])
            ->latest('tanggal_tiba')
            ->first();

        $box     = null;
        $riwayat = [];

        if ($boxTerakhir) {
            $batasRetur = $boxTerakhir->tanggal_tiba
                ? $boxTerakhir->tanggal_tiba->addDays(3)
                : null;

            $masihBisa = $batasRetur && now()->lessThanOrEqualTo($batasRetur);

            // Cek apakah sudah pernah ajukan retur untuk box ini
            $sudahAda = Retur::where('user_id', $user->id)
                ->where('box_id', $boxTerakhir->id)
                ->whereNotIn('status', ['ditolak'])
                ->exists();

            if ($sudahAda) {
                $masihBisa = false;
            }

            $items = $boxTerakhir->items->map(function ($boxItem) {
                $inv = InventoryItem::find($boxItem->item_id);
                return [
                    'id'       => $inv->id ?? $boxItem->item_id,
                    'nama'     => $inv->nama ?? '-',
                    'kategori' => $inv->kategori ?? '-',
                    'ukuran'   => $inv->ukuran ?? '-',
                    'warna'    => $inv->warna ?? '-',
                ];
            })->toArray();

            $box = [
                'id'             => $boxTerakhir->id,
                'kode'           => $boxTerakhir->kode_box,
                'tanggal_terima' => $boxTerakhir->tanggal_tiba?->format('d M Y'),
                'batas_retur'    => $batasRetur?->format('d M Y'),
                'masih_bisa'     => $masihBisa,
                'items'          => $items,
            ];

            $alasanMap = [
                'tidak_cocok_ukuran' => 'Tidak Cocok Ukuran',
                'tidak_suka_style'   => 'Tidak Suka Gaya',
                'kualitas_kurang'    => 'Kualitas Kurang',
                'warna_tidak_sesuai' => 'Warna Tidak Sesuai',
                'kondisi_rusak'      => 'Kondisi Rusak/Cacat',
                'lainnya'            => 'Lainnya',
            ];

            $riwayat = Retur::where('user_id', $user->id)
                ->latest()
                ->get()
                ->map(function ($r) use ($alasanMap) {
                    $box       = Box::find($r->box_id);
                    $namaItems = collect($r->item_retur)->map(function ($itemId) {
                        return InventoryItem::find($itemId)?->nama ?? 'Item #' . $itemId;
                    })->toArray();

                    return [
                        'kode'          => $r->kode_retur,
                        'box'           => $box?->kode_box ?? '-',
                        'items'         => $namaItems,
                        'alasan'        => $alasanMap[$r->alasan_retur] ?? $r->alasan_retur,
                        'metode'        => $r->metode_pengembalian === 'pickup' ? 'Dijemput Kurir' : 'Drop Off ke Ekspedisi',
                        'status'        => $r->status,
                        'tanggal'       => $r->created_at->format('d M Y'),
                        'catatan_admin' => $r->catatan_admin,
                    ];
                })->toArray();
        }

        return view('customers.retur', compact('box', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_retur'          => 'required|array|min:1|max:2',
            'item_retur.*'        => 'required|integer',
            'alasan_retur'        => 'required|in:tidak_cocok_ukuran,tidak_suka_style,kualitas_kurang,warna_tidak_sesuai,kondisi_rusak,lainnya',
            'catatan_retur'       => 'nullable|string|max:500',
            'metode_pengembalian' => 'required|in:drop_off,pickup',
            'box_id'              => 'required|exists:boxes,id',
        ]);

        $user = Auth::user();
        $box  = Box::where('id', $request->box_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Cek batas waktu retur
        $batasRetur = $box->tanggal_tiba?->addDays(3);
        if (!$batasRetur || now()->greaterThan($batasRetur)) {
            return back()->with('error', 'Batas waktu retur sudah habis.');
        }

        // Cek duplikasi
        $sudahAda = Retur::where('user_id', $user->id)
            ->where('box_id', $box->id)
            ->whereNotIn('status', ['ditolak'])
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Kamu sudah mengajukan retur untuk box ini.');
        }

        // Generate kode retur
        $kode = 'RTR-' . now()->format('Ymd') . '-' .
            str_pad(Retur::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

        Retur::create([
            'kode_retur'          => $kode,
            'user_id'             => $user->id,
            'box_id'              => $box->id,
            'item_retur'          => $request->item_retur,
            'alasan_retur'        => $request->alasan_retur,
            'catatan_retur'       => $request->catatan_retur,
            'metode_pengembalian' => $request->metode_pengembalian,
            'status'              => 'diajukan',
            'tanggal_batas_retur' => $batasRetur,
        ]);

        return back()->with('success', 'Retur berhasil diajukan! Kode retur kamu: ' . $kode);
    }

}
