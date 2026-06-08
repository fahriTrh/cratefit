<?php

namespace App\Http\Controllers;

use App\Models\BoxItem;
use App\Models\InventoryItem;
use App\Models\Langganan;
use App\Models\User;
use Illuminate\Http\Request;

class KuratorPelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Langganan::with(['user.preferensi', 'paket'])
            ->whereIn('status', ['aktif'])
            ->latest();

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $langgananList = $query->paginate(15);

        // Ambil semua box terbaru per user sekaligus (hindari N+1)
        $userIds    = $langgananList->pluck('user_id')->toArray();
        $boxTerbaru = \App\Models\Box::whereIn('user_id', $userIds)
            ->orderBy('created_at', 'desc')
            ->get()
            ->keyBy('user_id'); // satu box terbaru per user

        $statusLabel = [
            'menunggu_kurasi'  => ['status' => 'menunggu',  'label' => 'Menunggu Kurasi'],
            'sedang_dikurasi'  => ['status' => 'diproses',  'label' => 'Sedang Dikurasi'],
            'siap_dikirim'     => ['status' => 'diproses',  'label' => 'Siap Dikirim'],
            'dalam_pengiriman' => ['status' => 'dikirim',   'label' => 'Dalam Pengiriman'],
            'tiba'             => ['status' => 'selesai',   'label' => 'Sudah Tiba'],
            'selesai'          => ['status' => 'selesai',   'label' => 'Selesai'],
        ];

        $pelangganList = $langgananList->map(function ($l) use ($boxTerbaru, $statusLabel) {
            $preferensi = $l->user->preferensi;
            $box        = $boxTerbaru->get($l->user_id);

            // Jika belum pernah ada box, statusnya menunggu kurasi
            $statusInfo = $box
                ? ($statusLabel[$box->status] ?? ['status' => 'menunggu', 'label' => 'Menunggu Kurasi'])
                : ['status' => 'menunggu', 'label' => 'Menunggu Kurasi'];

            return [
                'id'      => $l->user->id,
                'nama'    => $l->user->name,
                'email'   => $l->user->email,
                'avatar'  => strtoupper(substr($l->user->name, 0, 1)),
                'paket'   => $l->paket->nama,
                'periode' => $l->tanggal_pengiriman_berikutnya?->translatedFormat('F Y') ?? '-',
                'status'  => $statusInfo['status'],
                'label'   => $statusInfo['label'],
                'gaya'    => $preferensi?->gaya_berpakaian ?? [],
                'ukuran'  => ($preferensi?->ukuran_atasan ?? '-') . ' / ' . ($preferensi?->ukuran_bawahan ?? '-'),
                'box_id'  => $box?->id,
            ];
        });

        // Hitung statistik dari data box nyata
        $totalBox      = $boxTerbaru->count();
        $menungguCount = $langgananList->total() - $boxTerbaru->whereIn('status', ['sedang_dikurasi', 'siap_dikirim', 'dalam_pengiriman', 'tiba', 'selesai'])->count();
        $diprosesCount = $boxTerbaru->whereIn('status', ['sedang_dikurasi', 'siap_dikirim'])->count();
        $selesaiCount  = $boxTerbaru->whereIn('status', ['selesai', 'tiba'])->count();

        return view('kurators.list-pelanggan', [
            'kuratorNama'    => auth()->user()->name,
            'pelangganList'  => $pelangganList,
            'totalPelanggan' => $langgananList->total(),
            'menunggu'       => $menungguCount,
            'diproses'       => $diprosesCount,
            'selesai'        => $selesaiCount,
        ]);
    }

    public function show($id)
    {
        $user = User::with(['preferensi', 'alamatPengiriman', 'langgananAktif.paket'])
            ->where('role', 'pelanggan')
            ->findOrFail($id);

        $langganan  = $user->langgananAktif()->with('paket')->first();
        $preferensi = $user->preferensi;
        $alamat     = $user->alamatPengiriman()->where('is_primary', true)->first()
            ?? $user->alamatPengiriman()->latest()->first();

        return view('kurators.detail-pelanggan', [
            'kuratorNama' => auth()->user()->name,
            'pelanggan'   => [
                'id'             => $user->id,
                'nama'           => $user->name,
                'email'          => $user->email,
                'no_hp'          => $user->no_hp ?? '-',
                'avatar'         => strtoupper(substr($user->name, 0, 1)),
                'bergabung'      => $user->created_at->translatedFormat('F Y'),
                'paket'          => $langganan?->paket->nama ?? 'Tidak berlangganan',
                'periode'        => $langganan?->periode ?? '-',
                'status'         => 'menunggu',
                'label_status'          => 'Menunggu Kurasi',
                'ukuran_atasan'  => $preferensi?->ukuran_atasan ?? '-',
                'ukuran_bawahan' => $preferensi?->ukuran_bawahan ?? '-',
                'tinggi'         => $preferensi?->tinggi_badan ?? '-',
                'berat'          => $preferensi?->berat_badan ?? '-',
                'gaya'           => $preferensi?->gaya_berpakaian ?? [],
                'warna'          => $preferensi?->warna_favorit ?? [],
                'jenis_pakaian'          => $preferensi?->jenis_pakaian ?? [],
                'pantangan'      => $preferensi?->pantangan ?? [],
                'catatan'        => $preferensi?->catatan_kurator ?? '',
                'alamat'         => $alamat ? [
                    'nama_penerima'  => $alamat->nama_penerima,
                    'no_telepon'     => $alamat->no_telepon,
                    'alamat_lengkap' => $alamat->alamat_lengkap,
                    'kecamatan'      => $alamat->kecamatan,
                    'kota'           => $alamat->kota,
                    'provinsi'       => $alamat->provinsi,
                    'kode_pos'       => $alamat->kode_pos,
                ] : null,
            ],
            'langganan'   => $langganan,
        ]);
    }

    public function pilihItem($id)
    {
        $user = User::with(['preferensi', 'langgananAktif.paket'])
            ->where('role', 'pelanggan')
            ->findOrFail($id);

        $langganan  = $user->langgananAktif()->with('paket')->first();
        $preferensi = $user->preferensi;

        // Ambil preferensi pelanggan untuk pencocokan
        $gayaPelanggan   = $preferensi?->gaya_berpakaian ?? [];
        $ukuranAtasan    = $preferensi?->ukuran_atasan ?? null;
        $ukuranBawahan   = $preferensi?->ukuran_bawahan ?? null;
        $pantangan       = array_map('strtolower', $preferensi?->pantangan ?? []);

        // Hitung stok terikat di box aktif
        $stokTerikat = \App\Models\BoxItem::whereHas('box', function ($q) {
            $q->whereNotIn('status', ['selesai']);
        })
            ->selectRaw('item_id, COUNT(*) as jumlah')
            ->groupBy('item_id')
            ->pluck('jumlah', 'item_id');

        $inventoryItems = InventoryItem::where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->latest()
            ->get()
            ->filter(function ($item) use ($stokTerikat) {
                return ($item->stok - $stokTerikat->get($item->id, 0)) > 0;
            });

        $kondisiLabel = [
            'bagus_sekali' => 'Sangat Baik',
            'bagus'        => 'Baik',
            'cukup_baik'   => 'Cukup',
        ];

        $items = $inventoryItems->map(function ($item) use (
            $gayaPelanggan,
            $ukuranAtasan,
            $ukuranBawahan,
            $pantangan,
            $kondisiLabel,
            $stokTerikat,
        ) {
            // Logika pencocokan: cocok jika ukuran pas, gaya ada irisan, tidak kena pantangan
            $tags           = $item->tags ?? [];
            $kategoriLower  = strtolower($item->kategori);
            $jenisLower     = strtolower($item->jenis);
            $kategoriAtasan = in_array($kategoriLower, ['atasan', 'outer']);
            $ukuranPas      = $kategoriAtasan
                ? ($ukuranAtasan && strtoupper($item->ukuran) === strtoupper($ukuranAtasan))
                : ($ukuranBawahan && strtoupper($item->ukuran) === strtoupper($ukuranBawahan));
            $adaIrisanGaya  = !empty(array_intersect(
                array_map('strtolower', $tags),
                array_map('strtolower', $gayaPelanggan)
            ));
            $kenaPantangan  = in_array($jenisLower, $pantangan) || in_array($kategoriLower, $pantangan);
            $cocok = $ukuranPas && $adaIrisanGaya && !$kenaPantangan;

            return [
                'id'       => $item->id,
                'nama'     => $item->nama,
                'kategori' => $item->jenis,   // tampilkan jenis (Kemeja, Kaos, dll) sebagai kategori di UI
                'ukuran'   => $item->ukuran,
                'warna'    => $item->warna ?? '-',
                'kondisi'  => $kondisiLabel[$item->kondisi] ?? $item->kondisi,
                'harga'    => $item->harga,
                'stok' => $item->stok - ($stokTerikat->get($item->id, 0)),
                'foto'     => $item->foto,
                'tag'      => $tags,
                'cocok'    => $cocok,
            ];
        })->values()->toArray();

        $pelanggan = [
            'id'             => $user->id,
            'nama'           => $user->name,
            'avatar'         => strtoupper(substr($user->name, 0, 1)),
            'paket'          => $langganan?->paket->nama ?? 'Starter Box',
            'periode'        => $langganan?->tanggal_pengiriman_berikutnya?->translatedFormat('F Y') ?? '-',
            'ukuran_atasan'  => $preferensi?->ukuran_atasan ?? '-',
            'ukuran_bawahan' => $preferensi?->ukuran_bawahan ?? '-',
            'gaya'           => $gayaPelanggan,
            'warna'          => $preferensi?->warna_favorit ?? [],
            'pantangan'      => $preferensi?->pantangan ?? [],
            'status'         => 'menunggu',
            'label_status'   => 'Menunggu Kurasi',
        ];

        $pilihanSebelumnya = session('pilihan_item_' . $id, []);

        return view('kurators.pilih-item', compact('pelanggan', 'items', 'pilihanSebelumnya'));
    }

    public function simpanPilihan(Request $request, $id)
    {
        // Simpan item yang dipilih ke session
        $itemIds = $request->input('item_ids', []);
        session(['pilihan_item_' . $id => $itemIds]);

        return redirect('/kurator/susun-box/' . $id);
    }

    public function susunBox($id)
    {
        $user = User::with(['preferensi', 'alamatPengiriman', 'langgananAktif.paket'])
            ->where('role', 'pelanggan')
            ->findOrFail($id);

        $langganan  = $user->langgananAktif()->with('paket')->first();
        $preferensi = $user->preferensi;
        $alamat     = $user->alamatPengiriman()->where('is_primary', true)->first()
            ?? $user->alamatPengiriman()->latest()->first();

        // Ambil item yang dipilih dari session
        $itemIds = session('pilihan_item_' . $id, []);

        $kondisiLabel = [
            'bagus_sekali' => 'Sangat Baik',
            'bagus'        => 'Baik',
            'cukup_baik'   => 'Cukup',
        ];

        $gayaPelanggan = $preferensi?->gaya_berpakaian ?? [];
        $pantangan     = array_map('strtolower', $preferensi?->pantangan ?? []);

        $itemDipilih = [];
        if (!empty($itemIds)) {
            $itemDipilih = InventoryItem::whereIn('id', $itemIds)
                ->get()
                ->map(function ($item) use ($kondisiLabel, $gayaPelanggan, $pantangan) {
                    $tags          = $item->tags ?? [];
                    $jenisLower    = strtolower($item->jenis);
                    $kategoriLower = strtolower($item->kategori);
                    $kenaPantangan = in_array($jenisLower, $pantangan) || in_array($kategoriLower, $pantangan);
                    $adaIrisanGaya = !empty(array_intersect(
                        array_map('strtolower', $tags),
                        array_map('strtolower', $gayaPelanggan)
                    ));
                    return [
                        'id'       => $item->id,
                        'nama'     => $item->nama,
                        'kategori' => $item->jenis,
                        'ukuran'   => $item->ukuran,
                        'warna'    => $item->warna ?? '-',
                        'kondisi'  => $kondisiLabel[$item->kondisi] ?? $item->kondisi,
                        'harga'    => $item->harga,
                        'foto'     => $item->foto,
                        'tag'      => $tags,
                        'cocok'    => $adaIrisanGaya && !$kenaPantangan,
                    ];
                })
                ->toArray();
        }

        $alamatStr = $alamat
            ? "{$alamat->alamat_lengkap}, {$alamat->kecamatan}, {$alamat->kota}, {$alamat->provinsi} {$alamat->kode_pos}"
            : 'Belum ada alamat tersimpan.';

        $pelanggan = [
            'id'             => $user->id,
            'nama'           => $user->name,
            'email'          => $user->email,
            'avatar'         => strtoupper(substr($user->name, 0, 1)),
            'paket'          => $langganan?->paket->nama ?? 'Starter Box',
            'periode'        => $langganan?->tanggal_pengiriman_berikutnya?->translatedFormat('F Y') ?? '-',
            'ukuran_atasan'  => $preferensi?->ukuran_atasan ?? '-',
            'ukuran_bawahan' => $preferensi?->ukuran_bawahan ?? '-',
            'gaya'           => $gayaPelanggan,
            'warna'          => $preferensi?->warna_favorit ?? [],
            'pantangan'      => $preferensi?->pantangan ?? [],
            'catatan'        => $preferensi?->catatan_kurator ?? '',
            'alamat'         => $alamatStr,
            'status'         => 'menunggu',
            'label_status'   => 'Menunggu Kurasi',
        ];

        return view('kurators.susun-box', compact('pelanggan', 'itemDipilih'));
    }

    public function konfirmasiBox(Request $request, $id)
    {
        $request->validate([
            'urutan_item'    => 'required|string',
            'status_box'     => 'required|in:sedang_dikurasi,siap_dikirim,dalam_pengiriman',
            'nomor_resi'     => 'nullable|string|max:100',
            'catatan_kurasi' => 'nullable|string|max:500',
        ]);

        $user      = User::where('role', 'pelanggan')->findOrFail($id);
        $langganan = $user->langgananAktif()->firstOrFail();
        $kurator   = auth()->user();

        // Buat kode box unik: CF-YYYYMMDD-userID
        $kodeBox = 'CF-' . now()->format('Ymd') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);

        $sudahAda = \App\Models\Box::where('user_id', $user->id)
            ->whereNotIn('status', ['selesai'])
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Pelanggan ini sudah memiliki box yang sedang berjalan.');
        }

        // Buat record box
        $box = \App\Models\Box::create([
            'kode_box'         => $kodeBox,
            'langganan_id'     => $langganan->id,
            'user_id'          => $user->id,
            'kurator_id'       => $kurator->id,
            'status'           => $request->status_box,
            'nomor_resi'       => $request->nomor_resi,
            'catatan_kurasi'   => $request->catatan_kurasi,
            'tanggal_dikurasi' => now(),
            'tanggal_dikirim'  => in_array($request->status_box, ['dalam_pengiriman']) ? now() : null,
        ]);

        // Simpan item sesuai urutan
        $urutanIds = array_filter(explode(',', $request->urutan_item));
        foreach ($urutanIds as $urutan => $itemId) {
            BoxItem::create([
                'box_id'  => $box->id,
                'item_id' => (int) $itemId,
                'urutan'  => $urutan + 1,
            ]);

            // Update status inventory item menjadi 'dikurasi'
            // InventoryItem::where('id', $itemId)
            //     ->update(['status' => 'dikurasi']);
        }

        // Kurangi stok inventory
        $itemIdsList = array_values(array_filter(explode(',', $request->urutan_item)));
        foreach ($itemIdsList as $itemId) {
            $item = InventoryItem::find((int) $itemId);
            if ($item) {
                $item->decrement('stok');
                if ($item->stok <= 0) {
                    $item->update(['status' => 'tidak_tersedia']);
                }
            }
        }

        // Bersihkan session pilihan
        session()->forget('pilihan_item_' . $id);

        return redirect('/kurator/pelanggan')
            ->with('success', 'Box ' . $kodeBox . ' berhasil dikonfirmasi.');
    }

    public function editPilihItem($boxId)
    {
        $box = \App\Models\Box::with(['pelanggan.preferensi', 'langganan.paket', 'items'])
            ->whereIn('status', ['sedang_dikurasi', 'siap_dikirim'])
            ->findOrFail($boxId);

        $user       = $box->pelanggan;
        $langganan  = $box->langganan;
        $preferensi = $user->preferensi;

        $itemIdsDiBox  = $box->items->pluck('item_id')->toArray();
        $gayaPelanggan = $preferensi?->gaya_berpakaian ?? [];
        $ukuranAtasan  = $preferensi?->ukuran_atasan ?? null;
        $ukuranBawahan = $preferensi?->ukuran_bawahan ?? null;
        $pantangan     = array_map('strtolower', $preferensi?->pantangan ?? []);

        $kondisiLabel = [
            'bagus_sekali' => 'Sangat Baik',
            'bagus'        => 'Baik',
            'cukup_baik'   => 'Cukup',
        ];

        // Hitung stok terikat, exclude box yang sedang diedit
        $stokTerikat = \App\Models\BoxItem::whereHas('box', function ($q) use ($boxId) {
            $q->whereNotIn('status', ['selesai'])
                ->where('id', '!=', $boxId);
        })
            ->selectRaw('item_id, COUNT(*) as jumlah')
            ->groupBy('item_id')
            ->pluck('jumlah', 'item_id');

        $inventoryItems = InventoryItem::where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->latest()
            ->get()
            ->filter(function ($item) use ($stokTerikat) {
                return ($item->stok - $stokTerikat->get($item->id, 0)) > 0;
            });

        $items = $inventoryItems->map(function ($item) use (
            $gayaPelanggan,
            $ukuranAtasan,
            $ukuranBawahan,
            $pantangan,
            $kondisiLabel,
            $stokTerikat,
            $itemIdsDiBox
        ) {
            $tags           = $item->tags ?? [];
            $kategoriLower  = strtolower($item->kategori);
            $jenisLower     = strtolower($item->jenis);
            $kategoriAtasan = in_array($kategoriLower, ['atasan', 'outer']);
            $ukuranPas      = $kategoriAtasan
                ? ($ukuranAtasan && strtoupper($item->ukuran) === strtoupper($ukuranAtasan))
                : ($ukuranBawahan && strtoupper($item->ukuran) === strtoupper($ukuranBawahan));
            $adaIrisanGaya  = !empty(array_intersect(
                array_map('strtolower', $tags),
                array_map('strtolower', $gayaPelanggan)
            ));
            $kenaPantangan  = in_array($jenisLower, $pantangan) || in_array($kategoriLower, $pantangan);

            return [
                'id'       => $item->id,
                'nama'     => $item->nama,
                'kategori' => $item->jenis,
                'ukuran'   => $item->ukuran,
                'warna'    => $item->warna ?? '-',
                'kondisi'  => $kondisiLabel[$item->kondisi] ?? $item->kondisi,
                'harga'    => $item->harga,
                'stok' => $item->stok - ($stokTerikat->get($item->id, 0)),
                'foto'     => $item->foto,
                'tag'      => $tags,
                'cocok'    => $ukuranPas && $adaIrisanGaya && !$kenaPantangan,
            ];
        })->values()->toArray();

        $pelanggan = [
            'id'             => $user->id,
            'nama'           => $user->name,
            'avatar'         => strtoupper(substr($user->name, 0, 1)),
            'paket'          => $langganan?->paket->nama ?? '-',
            'periode'        => $langganan?->tanggal_pengiriman_berikutnya?->translatedFormat('F Y') ?? '-',
            'ukuran_atasan'  => $preferensi?->ukuran_atasan ?? '-',
            'ukuran_bawahan' => $preferensi?->ukuran_bawahan ?? '-',
            'gaya'           => $gayaPelanggan,
            'warna'          => $preferensi?->warna_favorit ?? [],
            'pantangan'      => $preferensi?->pantangan ?? [],
            'status'         => 'sedang_dikurasi',
            'label_status'   => 'Sedang Dikurasi',
        ];

        // Pre-select item yang sudah ada di box via session
        session(['edit_pilihan_item_' . $boxId => $itemIdsDiBox]);
        $pilihanSebelumnya = $itemIdsDiBox;

        return view('kurators.edit-pilih-item', compact('pelanggan', 'items', 'pilihanSebelumnya', 'box'));
    }

    public function editSimpanPilihan(Request $request, $boxId)
    {
        $itemIds = $request->input('item_ids', []);
        session(['edit_pilihan_item_' . $boxId => $itemIds]);

        return redirect('/kurator/edit-susun-box/' . $boxId);
    }

    public function editSusunBox($boxId)
    {
        $box = \App\Models\Box::with(['pelanggan.preferensi', 'pelanggan.alamatPengiriman', 'langganan.paket'])
            ->whereIn('status', ['sedang_dikurasi', 'siap_dikirim'])
            ->findOrFail($boxId);

        $user       = $box->pelanggan;
        $langganan  = $box->langganan;
        $preferensi = $user->preferensi;
        $alamat     = $user->alamatPengiriman()->where('is_primary', true)->first()
            ?? $user->alamatPengiriman()->latest()->first();

        $itemIds = session('edit_pilihan_item_' . $boxId, []);

        $kondisiLabel = [
            'bagus_sekali' => 'Sangat Baik',
            'bagus'        => 'Baik',
            'cukup_baik'   => 'Cukup',
        ];

        $gayaPelanggan = $preferensi?->gaya_berpakaian ?? [];
        $pantangan     = array_map('strtolower', $preferensi?->pantangan ?? []);

        $itemDipilih = [];
        if (!empty($itemIds)) {
            $itemDipilih = InventoryItem::whereIn('id', $itemIds)->get()
                ->map(function ($item) use ($kondisiLabel, $gayaPelanggan, $pantangan) {
                    $tags          = $item->tags ?? [];
                    $jenisLower    = strtolower($item->jenis);
                    $kategoriLower = strtolower($item->kategori);
                    $kenaPantangan = in_array($jenisLower, $pantangan) || in_array($kategoriLower, $pantangan);
                    $adaIrisanGaya = !empty(array_intersect(
                        array_map('strtolower', $tags),
                        array_map('strtolower', $gayaPelanggan)
                    ));
                    return [
                        'id'       => $item->id,
                        'nama'     => $item->nama,
                        'kategori' => $item->jenis,
                        'ukuran'   => $item->ukuran,
                        'warna'    => $item->warna ?? '-',
                        'kondisi'  => $kondisiLabel[$item->kondisi] ?? $item->kondisi,
                        'harga'    => $item->harga,
                        'foto'     => $item->foto,
                        'tag'      => $tags,
                        'cocok'    => $adaIrisanGaya && !$kenaPantangan,
                    ];
                })->toArray();
        }

        $alamatStr = $alamat
            ? "{$alamat->alamat_lengkap}, {$alamat->kecamatan}, {$alamat->kota}, {$alamat->provinsi} {$alamat->kode_pos}"
            : 'Belum ada alamat tersimpan.';

        $pelanggan = [
            'id'             => $user->id,
            'nama'           => $user->name,
            'email'          => $user->email,
            'avatar'         => strtoupper(substr($user->name, 0, 1)),
            'paket'          => $langganan?->paket->nama ?? '-',
            'periode'        => $langganan?->tanggal_pengiriman_berikutnya?->translatedFormat('F Y') ?? '-',
            'ukuran_atasan'  => $preferensi?->ukuran_atasan ?? '-',
            'ukuran_bawahan' => $preferensi?->ukuran_bawahan ?? '-',
            'gaya'           => $gayaPelanggan,
            'warna'          => $preferensi?->warna_favorit ?? [],
            'pantangan'      => $preferensi?->pantangan ?? [],
            'catatan'        => $preferensi?->catatan_kurator ?? '',
            'alamat'         => $alamatStr,
            'status'         => 'sedang_dikurasi',
            'label_status'   => 'Sedang Dikurasi',
        ];

        return view('kurators.edit-susun-box', compact('pelanggan', 'itemDipilih', 'box'));
    }

    public function updateBox(Request $request, $boxId)
    {
        $request->validate([
            'urutan_item'    => 'required|string',
            'status_box'     => 'required|in:sedang_dikurasi,siap_dikirim',
            'catatan_kurasi' => 'nullable|string|max:500',
        ]);

        $box = \App\Models\Box::whereIn('status', ['sedang_dikurasi', 'siap_dikirim'])
            ->findOrFail($boxId);

        // Kembalikan stok item lama
        $box->load('items');
        $itemIdsLama = $box->items->pluck('item_id')->toArray();
        foreach ($itemIdsLama as $itemId) {
            $item = InventoryItem::find($itemId);
            if ($item) {
                $item->increment('stok');
                if ($item->status === 'tidak_tersedia') {
                    $item->update(['status' => 'tersedia']);
                }
            }
        }

        // Hapus box_items lama dan insert yang baru
        $box->items()->delete();
        $urutanIds = array_filter(explode(',', $request->urutan_item));
        foreach ($urutanIds as $urutan => $itemId) {
            BoxItem::create([
                'box_id'  => $box->id,
                'item_id' => (int) $itemId,
                'urutan'  => $urutan + 1,
            ]);
        }

        // Kurangi stok item baru
        $itemIdsBaru = array_values(array_filter(explode(',', $request->urutan_item)));
        foreach ($itemIdsBaru as $itemId) {
            $item = InventoryItem::find((int) $itemId);
            if ($item) {
                $item->decrement('stok');
                if ($item->stok <= 0) {
                    $item->update(['status' => 'tidak_tersedia']);
                }
            }
        }

        $box->update([
            'status'           => $request->status_box,
            'catatan_kurasi'   => $request->catatan_kurasi,
            'kurator_id'       => auth()->id(),
            'tanggal_dikurasi' => now(),
        ]);

        session()->forget('edit_pilihan_item_' . $boxId);

        return redirect('/kurator/pelanggan')
            ->with('success', 'Box ' . $box->kode_box . ' berhasil diperbarui.');
    }
}
