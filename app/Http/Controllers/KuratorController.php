<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KuratorController extends Controller
{
    public function index()
    {
        $kurators = User::where('role', 'kurator')
            ->withCount([
                'boxKurasi as total_kurasi'
            ])
            ->latest()
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nama' => $user->name,
                    'email' => $user->email,
                    'no_hp' => $user->no_hp ?? '-',
                    'avatar' => strtoupper(substr($user->name, 0, 1)),
                    'status' => $user->status ?? 'aktif',
                    'bergabung' => $user->created_at->translatedFormat('F Y'),

                    // Statistik
                    'total_kurasi' => $user->total_kurasi,
                    'bulan_ini' => $user->boxKurasi()
                        ->whereMonth('tanggal_dikurasi', now()->month)
                        ->whereYear('tanggal_dikurasi', now()->year)
                        ->count(),

                    // Rating
                    'rating' => round($user->rataRataRatingKurator(), 1),
                    'total_rating' => $user->totalRatingKurator(),

                    'spesialisasi' => json_decode($user->spesialisasi ?? '[]', true) ?? [],
                ];
            });

        return view('admins.list-kurator', compact('kurators'));
    }

    public function create()
    {
        return view('admins.tambah-kurator');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_hp'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'kurator',
            // kolom tambahan jika ada migrasi:
            'no_hp'        => $request->no_hp,
            'status'       => $request->status,
            'spesialisasi' => json_encode($request->spesialisasi ?? []),
            'catatan'      => $request->catatan,
        ]);

        return redirect('/admin/kurator')
            ->with('success', 'Kurator berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::where('role', 'kurator')->findOrFail($id);

        $kurator = [
            'id'           => $user->id,
            'nama'         => $user->name,
            'email'        => $user->email,
            'no_hp'        => $user->no_hp ?? '-',
            'avatar'       => strtoupper(substr($user->name, 0, 1)),
            'status'       => $user->status ?? 'aktif',
            'bergabung'    => $user->created_at->translatedFormat('F Y'),
            'spesialisasi' => json_decode($user->spesialisasi ?? '[]', true) ?? [],
            'catatan'      => $user->catatan ?? '',
            'total_kurasi' => 0,
            'bulan_ini'    => 0,
            'rating'       => 0,
            'riwayat'      => [],
            'performa'     => [
                ['bulan' => 'Jan', 'kurasi' => 0, 'rating' => 0],
                ['bulan' => 'Feb', 'kurasi' => 0, 'rating' => 0],
                ['bulan' => 'Mar', 'kurasi' => 0, 'rating' => 0],
                ['bulan' => 'Apr', 'kurasi' => 0, 'rating' => 0],
                ['bulan' => 'Mei', 'kurasi' => 0, 'rating' => 0],
                ['bulan' => 'Jun', 'kurasi' => 0, 'rating' => 0],
            ],
        ];

        return view('admins.detail-kurator', compact('kurator'));
    }

    public function edit($id)
    {
        $user = User::where('role', 'kurator')->findOrFail($id);

        $kurator = [
            'id'           => $user->id,
            'nama'         => $user->name,
            'email'        => $user->email,
            'no_hp'        => $user->no_hp ?? '',
            'status'       => $user->status ?? 'aktif',
            'spesialisasi' => json_decode($user->spesialisasi ?? '[]', true) ?? [],
            'catatan'      => $user->catatan ?? '',
        ];

        return view('admins.tambah-kurator', compact('kurator'));
    }

    public function update(Request $request, $id)
    {
        $kurator = User::where('role', 'kurator')->findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'no_hp'    => 'nullable|string|max:20',
            'status'   => 'required|in:aktif,nonaktif',
            'password' => $request->reset_password ? 'required|string|min:8|confirmed' : 'nullable',
        ]);

        $data = [
            'name'         => $request->nama,
            'email'        => $request->email,
            'no_hp'        => $request->no_hp,
            'status'       => $request->status,
            'spesialisasi' => json_encode($request->spesialisasi ?? []),
            'catatan'      => $request->catatan,
        ];

        if ($request->reset_password && $request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $kurator->update($data);

        return redirect('/admin/kurator')
            ->with('success', 'Data kurator berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::where('role', 'kurator')->findOrFail($id)->delete();
        return redirect('/admin/kurator')->with('success', 'Kurator berhasil dihapus.');
    }
}
