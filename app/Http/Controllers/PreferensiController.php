<?php

namespace App\Http\Controllers;

use App\Models\Preferensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferensiController extends Controller
{
    public function index()
    {
        $currentStep  = 2;
        $preferensi   = Preferensi::where('user_id', Auth::id())->first();
        return view('customers.preferensi', compact('currentStep', 'preferensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ukuran_atasan'    => 'required|in:XS,S,M,L,XL,XXL',
            'ukuran_bawahan'   => 'required|in:XS,S,M,L,XL,XXL',
            'tinggi_badan'     => 'nullable|integer|min:100|max:250',
            'berat_badan'      => 'nullable|integer|min:20|max:300',
            'gaya_berpakaian'  => 'required|array|min:1',
            'warna_favorit'    => 'required|array|min:1|max:5',
            'jenis_pakaian'    => 'required|array|min:1',
            'pantangan'        => 'nullable|array',
            'catatan_kurator'  => 'nullable|string|max:1000',
        ], [
            'ukuran_atasan.required'   => 'Ukuran atasan wajib dipilih.',
            'ukuran_bawahan.required'  => 'Ukuran bawahan wajib dipilih.',
            'gaya_berpakaian.required' => 'Pilih minimal 1 gaya berpakaian.',
            'warna_favorit.required'   => 'Pilih minimal 1 warna favorit.',
            'warna_favorit.max'        => 'Maksimal 5 warna favorit.',
            'jenis_pakaian.required'   => 'Pilih minimal 1 jenis pakaian.',
        ]);

        Preferensi::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'ukuran_atasan'   => $request->ukuran_atasan,
                'ukuran_bawahan'  => $request->ukuran_bawahan,
                'tinggi_badan'    => $request->tinggi_badan,
                'berat_badan'     => $request->berat_badan,
                'gaya_berpakaian' => $request->gaya_berpakaian,
                'warna_favorit'   => $request->warna_favorit,
                'jenis_pakaian'   => $request->jenis_pakaian,
                'pantangan'       => $request->pantangan ?? [],
                'catatan_kurator' => $request->catatan_kurator,
            ]
        );

        return redirect('/alamat')->with('success', 'Preferensi berhasil disimpan!');
    }
}
