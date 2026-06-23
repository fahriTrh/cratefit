<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = User::where('role', 'pelanggan')
            ->latest()
            ->get()
            ->map(function ($user) {
                return [
                    'id'           => $user->id,
                    'nama'         => $user->name,
                    'email'        => $user->email,
                    'no_hp'        => $user->no_hp ?? '-',
                    'avatar'       => strtoupper(substr($user->name, 0, 1)),
                    'status'       => $user->status ?? 'aktif',
                    'bergabung'    => $user->created_at->translatedFormat('F Y'),

                    // kalau belum ada relasi order, amanin dulu
                    'total_order' => method_exists($user, 'orders')
                    ? $user->orders()->count()
                    : 0,

                    'alamat'       => $user->alamat ?? '-',

                    // kalau belum ada paket relation
                    'paket'        => $user->paket ?? null,
                ];
            });

        return view('admins.list-pelanggan', [
            'pelanggan' => $pelanggans
        ]);
    }

    public function show($id)
    {
        $user = User::where('role', 'pelanggan')->findOrFail($id);

        $pelanggan = [
            'id'          => $user->id,
            'nama'        => $user->name,
            'email'       => $user->email,
            'no_hp'       => $user->no_hp ?? '-',
            'alamat'      => $user->alamat ?? '-',
            'status'      => $user->status ?? 'aktif',
            'bergabung'   => $user->created_at->translatedFormat('F Y'),
            'paket'       => $user->paket ?? null,
            'total_order' => $user->orders()->count() ?? 0,
        ];

        return view('admins.detail-pelanggan', compact('pelanggan'));
    }

    public function destroy($id)
    {
        User::where('role', 'pelanggan')->findOrFail($id)->delete();

        return redirect('/admin/pelanggan')
            ->with('success', 'Pelanggan berhasil dihapus');
    }
}