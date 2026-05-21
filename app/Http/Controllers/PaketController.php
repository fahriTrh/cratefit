<?php

namespace App\Http\Controllers;

use App\Models\PaketSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = PaketSubscription::all()->map(function ($p) {
            return [
                'id'               => $p->id,
                'slug'             => $p->slug,
                'nama'             => $p->nama,
                'icon'             => $p->icon,
                'harga'            => $p->harga,
                'items'            => $p->jumlah_item,
                'badge'            => $p->badge,
                'deskripsi'        => $p->deskripsi,
                'fitur'            => $p->fitur ?? [],
                'tidak'            => $p->tidak ?? [],
                'highlight'        => $p->highlight,
                'aktif'            => $p->aktif,
                'langganan_aktif'  => 0,
                'total_langganan'  => 0,
                'pendapatan_bulan' => 0,
            ];
        })->toArray();

        return view('admins.kelola-paket', compact('pakets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'icon'  => 'required|string|max:10',
            'harga' => 'required|integer|min:0',
            'items' => 'required|integer|min:1',
        ]);

        PaketSubscription::create([
            'nama'        => $request->nama,
            'slug'        => Str::slug($request->nama),
            'icon'        => $request->icon,
            'harga'       => $request->harga,
            'jumlah_item' => $request->items,
            'badge'       => $request->badge,
            'deskripsi'   => $request->deskripsi,
            'fitur'       => array_values(array_filter(explode("\n", $request->fitur ?? ''))),
            'tidak'       => array_values(array_filter(explode("\n", $request->tidak ?? ''))),
            'highlight'   => $request->boolean('highlight'),
            'aktif'       => $request->boolean('aktif'),
        ]);

        return redirect('/admin/kelola-paket')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $paket = PaketSubscription::findOrFail($id);

        $request->validate([
            'nama'  => 'required|string|max:255',
            'icon'  => 'required|string|max:10',
            'harga' => 'required|integer|min:0',
            'items' => 'required|integer|min:1',
        ]);

        $paket->update([
            'nama'        => $request->nama,
            'slug'        => Str::slug($request->nama),
            'icon'        => $request->icon,
            'harga'       => $request->harga,
            'jumlah_item' => $request->items,
            'badge'       => $request->badge,
            'deskripsi'   => $request->deskripsi,
            'fitur'       => array_values(array_filter(explode("\n", $request->fitur ?? ''))),
            'tidak'       => array_values(array_filter(explode("\n", $request->tidak ?? ''))),
            'highlight'   => $request->boolean('highlight'),
            'aktif'       => $request->boolean('aktif'),
        ]);

        return redirect('/admin/kelola-paket')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        PaketSubscription::findOrFail($id)->delete();
        return redirect('/admin/kelola-paket')->with('success', 'Paket berhasil dihapus.');
    }

    public function toggle($id)
    {
        $paket = PaketSubscription::findOrFail($id);
        $paket->aktif = !$paket->aktif;
        $paket->save();

        return redirect('/admin/kelola-paket')->with('success', 'Status paket berhasil diubah.');
    }
}
