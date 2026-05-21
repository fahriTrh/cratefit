<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Mapping kondisi dari blade ke db
    private $kondisiMap = [
        'Sangat Bagus' => 'bagus_sekali',
        'Bagus'        => 'bagus',
        'Cukup Bagus'  => 'cukup_baik',
    ];

    // Mapping kondisi dari db ke blade
    private $kondisiLabel = [
        'bagus_sekali' => 'Sangat Bagus',
        'bagus'        => 'Bagus',
        'cukup_baik'   => 'Cukup Bagus',
    ];

    private function formatItem($item): array
    {
        return [
            'id'       => $item->id,
            'kode'     => $item->kode_item,
            'nama'     => $item->nama,
            'kategori' => $item->kategori,
            'jenis'    => $item->jenis,
            'ukuran'   => $item->ukuran,
            'warna'    => $item->warna ?? '-',
            'kondisi'  => $this->kondisiLabel[$item->kondisi] ?? $item->kondisi,
            'harga'    => $item->harga,
            'stok'     => $item->stok,
            'status'   => $item->status,
            'brand'    => $item->brand ?? 'Unbranded',
            'masuk'    => $item->created_at->translatedFormat('d F Y'),
            'foto'     => $item->foto,
            'tags'     => $item->tags ?? [],
        ];
    }

    private function generateKode(): string
    {
        $last = InventoryItem::orderByDesc('id')->first();
        $num  = $last ? $last->id + 1 : 1;
        return 'CF-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $items = InventoryItem::latest()->get()
            ->map(fn($item) => $this->formatItem($item))
            ->toArray();

        return view('admins.kelola-inventory', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis'    => 'required|string',
            'ukuran'   => 'required|string',
            'kondisi'  => 'required|string',
            'harga'    => 'required|integer|min:0',
            'stok'     => 'required|integer|min:0',
            'status'   => 'required|in:tersedia,dikurasi,habis',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/inventory'), $filename);
            $fotoPath = 'uploads/inventory/' . $filename;
        }

        InventoryItem::create([
            'kode_item' => $this->generateKode(),
            'nama'      => $request->nama,
            'kategori'  => $request->kategori,
            'jenis'     => $request->jenis,
            'ukuran'    => $request->ukuran,
            'warna'     => $request->warna,
            'brand'     => $request->brand ?? 'Unbranded',
            'kondisi'   => $this->kondisiMap[$request->kondisi] ?? 'bagus',
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'status'    => $request->status === 'habis' ? 'tersedia' : $request->status,
            'tags'      => array_values(array_filter(array_map('trim', explode(',', $request->tags ?? '')))),
            'foto'      => $fotoPath,
        ]);

        return redirect('/admin/inventory')->with('success', 'Item berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis'    => 'required|string',
            'ukuran'   => 'required|string',
            'kondisi'  => 'required|string',
            'harga'    => 'required|integer|min:0',
            'stok'     => 'required|integer|min:0',
            'status'   => 'required|in:tersedia,dikurasi,habis',
        ]);

        $fotoPath = $item->foto;
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/inventory'), $filename);
            $fotoPath = 'uploads/inventory/' . $filename;
        }

        $item->update([
            'nama'     => $request->nama,
            'kategori' => $request->kategori,
            'jenis'    => $request->jenis,
            'ukuran'   => $request->ukuran,
            'warna'    => $request->warna,
            'brand'    => $request->brand ?? 'Unbranded',
            'kondisi'  => $this->kondisiMap[$request->kondisi] ?? 'bagus',
            'harga'    => $request->harga,
            'stok'     => $request->stok,
            'status'   => $request->status,
            'tags'     => array_values(array_filter(array_map('trim', explode(',', $request->tags ?? '')))),
            'foto'     => $fotoPath,
        ]);

        return redirect('/admin/inventory')->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy($id)
    {
        InventoryItem::findOrFail($id)->delete();
        return redirect('/admin/inventory')->with('success', 'Item berhasil dihapus.');
    }

    public function updateStok(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        if ($request->aksi === 'tambah') {
            $item->stok += 1;
        } elseif ($request->aksi === 'kurang' && $item->stok > 0) {
            $item->stok -= 1;
        }

        $item->status = $item->stok === 0 ? 'tersedia' : $item->status;
        $item->save();

        return redirect('/admin/inventory')->with('success', 'Stok berhasil diperbarui.');
    }
}
