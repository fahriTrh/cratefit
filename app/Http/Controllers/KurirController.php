<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KurirController extends Controller
{
    public function index()
    {
        $kurir = User::where('role', 'kurir')->latest()->get()
            ->map(function ($user) {
                return [
                    'id'          => $user->id,
                    'nama'        => $user->name,
                    'email'       => $user->email,
                    'no_hp'       => $user->no_hp ?? '-',
                    'avatar'      => strtoupper(substr($user->name, 0, 1)),
                    'status'      => $user->status ?? 'aktif',
                    'bergabung'   => $user->created_at->translatedFormat('F Y'),
                    'kendaraan'   => $user->kendaraan ?? '-',
                    'plat'        => $user->plat ?? '-',
                    'wilayah'     => $user->wilayah ?? '-',
                    'total_antar' => 0,
                    'bulan_ini'   => 0,
                    'rating'      => 0,
                ];
            })->toArray();

        return view('admins.list-kurir', compact('kurir'));
    }

    public function create()
    {
        return view('admins.tambah-kurir');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,email',
            'no_hp'              => 'required|string|max:20',
            'password'           => 'required|string|min:8|confirmed',
            'kendaraan'          => 'required|in:Motor,Sepeda,Mobil',
            'plat'               => 'nullable|string|max:20',
            'wilayah'            => 'required|string',
            'tanggal_bergabung'  => 'required|date',
            'status'             => 'required|in:aktif,nonaktif',
        ]);

        User::create([
            'name'              => $request->nama,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => 'kurir',
            'no_hp'             => $request->no_hp,
            'status'            => $request->status,
            'kendaraan'         => $request->kendaraan,
            'plat'              => $request->plat,
            'wilayah'           => $request->wilayah,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'catatan'           => $request->catatan,
        ]);

        return redirect('/admin/kurir')->with('success', 'Kurir berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::where('role', 'kurir')->findOrFail($id);

        $kurir = [
            'id'          => $user->id,
            'nama'        => $user->name,
            'email'       => $user->email,
            'no_hp'       => $user->no_hp ?? '-',
            'avatar'      => strtoupper(substr($user->name, 0, 1)),
            'status'      => $user->status ?? 'aktif',
            'bergabung'   => $user->created_at->translatedFormat('F Y'),
            'kendaraan'   => $user->kendaraan ?? '-',
            'plat'        => $user->plat ?? '-',
            'wilayah'     => $user->wilayah ?? '-',
            'catatan'     => $user->catatan ?? '',
            'total_antar' => 0,
            'bulan_ini'   => 0,
            'rating'      => 0,
            'performa'    => [
                ['bulan' => 'Jan', 'antar' => 0, 'rating' => 0],
                ['bulan' => 'Feb', 'antar' => 0, 'rating' => 0],
                ['bulan' => 'Mar', 'antar' => 0, 'rating' => 0],
                ['bulan' => 'Apr', 'antar' => 0, 'rating' => 0],
                ['bulan' => 'Mei', 'antar' => 0, 'rating' => 0],
                ['bulan' => 'Jun', 'antar' => 0, 'rating' => 0],
            ],
            'riwayat'     => [],
        ];

        return view('admins.detail-kurir', compact('kurir'));
    }

    public function edit($id)
{
    $user = User::where('role', 'kurir')->findOrFail($id);

    $kurir = [
        'id'                 => $user->id,
        'nama'               => $user->name,
        'email'              => $user->email,
        'no_hp'              => $user->no_hp ?? '',
        'status'             => $user->status ?? 'aktif',
        'kendaraan'          => $user->kendaraan ?? '',
        'plat'               => $user->plat ?? '',
        'wilayah'            => $user->wilayah ?? '',
        'tanggal_bergabung'  => $user->tanggal_bergabung ?? date('Y-m-d'),
        'catatan'            => $user->catatan ?? '',
    ];

    return view('admins.tambah-kurir', compact('kurir'));
}

public function update(Request $request, $id)
{
    $kurir = User::where('role', 'kurir')->findOrFail($id);

    $request->validate([
        'nama'              => 'required|string|max:255',
        'email'             => 'required|email|unique:users,email,' . $id,
        'no_hp'             => 'required|string|max:20',
        'kendaraan'         => 'required|in:Motor,Sepeda,Mobil',
        'plat'              => 'nullable|string|max:20',
        'wilayah'           => 'required|string',
        'tanggal_bergabung' => 'required|date',
        'status'            => 'required|in:aktif,nonaktif',
        'password'          => 'nullable|string|min:8|confirmed',
    ]);

    $data = [
        'name'              => $request->nama,
        'email'             => $request->email,
        'no_hp'             => $request->no_hp,
        'status'            => $request->status,
        'kendaraan'         => $request->kendaraan,
        'plat'              => $request->plat,
        'wilayah'           => $request->wilayah,
        'tanggal_bergabung' => $request->tanggal_bergabung,
        'catatan'           => $request->catatan,
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $kurir->update($data);

    return redirect('/admin/kurir')->with('success', 'Data kurir berhasil diperbarui.');
}

    public function destroy($id)
    {
        User::where('role', 'kurir')->findOrFail($id)->delete();
        return redirect('/admin/kurir')->with('success', 'Kurir berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $kurir = User::where('role', 'kurir')->findOrFail($id);
        $kurir->status = $kurir->status === 'aktif' ? 'nonaktif' : 'aktif';
        $kurir->save();

        return redirect('/admin/kurir')->with('success', 'Status kurir berhasil diubah.');
    }
}
