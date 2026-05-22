<?php

namespace App\Http\Controllers;

use App\Models\AlamatPengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlamatController extends Controller
{
    public function index()
    {
        $currentStep = 3;
        $addresses   = AlamatPengiriman::where('user_id', Auth::id())
            ->orderByDesc('is_primary')
            ->get();

        return view('customers.alamat', compact('currentStep', 'addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'          => 'required|in:Rumah,Kos,Asrama,Kantor,Lainnya',
            'nama_penerima'  => 'required|string|max:255',
            'no_telepon'     => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'kelurahan'      => 'required|string|max:255',
            'kecamatan'      => 'required|string|max:255',
            'kota'           => 'required|string|max:255',
            'provinsi'       => 'required|string|max:255',
            'kode_pos'       => 'required|string|max:10',
            'catatan_kurir'  => 'nullable|string|max:500',
            'is_primary'     => 'nullable|boolean',
        ]);

        // Kalau dijadikan utama, reset semua alamat lain
        if ($request->boolean('is_primary')) {
            AlamatPengiriman::where('user_id', Auth::id())
                ->update(['is_primary' => false]);
        }

        // Kalau belum ada alamat sama sekali, otomatis jadikan utama
        $isFirst = AlamatPengiriman::where('user_id', Auth::id())->count() === 0;

        AlamatPengiriman::create([
            'user_id'        => Auth::id(),
            'label'          => $request->label,
            'nama_penerima'  => $request->nama_penerima,
            'no_telepon'     => $request->no_telepon,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kelurahan'      => $request->kelurahan,
            'kecamatan'      => $request->kecamatan,
            'kota'           => $request->kota,
            'provinsi'       => $request->provinsi,
            'kode_pos'       => $request->kode_pos,
            'catatan_kurir'  => $request->catatan_kurir,
            'is_primary'     => $request->boolean('is_primary') || $isFirst,
        ]);

        return redirect('/langganan')->with('success', 'Alamat berhasil disimpan!');
    }

    public function edit($id)
    {
        $currentStep = 3;
        $addresses   = AlamatPengiriman::where('user_id', Auth::id())
            ->orderByDesc('is_primary')
            ->get();
        $editAlamat  = AlamatPengiriman::where('user_id', Auth::id())->findOrFail($id);

        return view('customers.alamat', compact('currentStep', 'addresses', 'editAlamat'));
    }

    public function update(Request $request, $id)
    {
        $alamat = AlamatPengiriman::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'label'          => 'required|in:Rumah,Kos,Asrama,Kantor,Lainnya',
            'nama_penerima'  => 'required|string|max:255',
            'no_telepon'     => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'kelurahan'      => 'required|string|max:255',
            'kecamatan'      => 'required|string|max:255',
            'kota'           => 'required|string|max:255',
            'provinsi'       => 'required|string|max:255',
            'kode_pos'       => 'required|string|max:10',
            'catatan_kurir'  => 'nullable|string|max:500',
        ]);

        if ($request->boolean('is_primary')) {
            AlamatPengiriman::where('user_id', Auth::id())
                ->where('id', '!=', $id)
                ->update(['is_primary' => false]);
        }

        $alamat->update([
            'label'          => $request->label,
            'nama_penerima'  => $request->nama_penerima,
            'no_telepon'     => $request->no_telepon,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kelurahan'      => $request->kelurahan,
            'kecamatan'      => $request->kecamatan,
            'kota'           => $request->kota,
            'provinsi'       => $request->provinsi,
            'kode_pos'       => $request->kode_pos,
            'catatan_kurir'  => $request->catatan_kurir,
            'is_primary'     => $request->boolean('is_primary'),
        ]);

        return redirect('/alamat')->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $alamat = AlamatPengiriman::where('user_id', Auth::id())->findOrFail($id);
        $wasPrimary = $alamat->is_primary;
        $alamat->delete();

        // Kalau yang dihapus adalah alamat utama, jadikan yang pertama sebagai utama
        if ($wasPrimary) {
            AlamatPengiriman::where('user_id', Auth::id())
                ->first()
                ?->update(['is_primary' => true]);
        }

        return redirect('/alamat')->with('success', 'Alamat berhasil dihapus.');
    }
}
