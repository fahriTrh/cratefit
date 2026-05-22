<?php

namespace App\Http\Controllers;

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

        // Filter status box (nanti kalau sudah ada tabel boxes)
        // Untuk sekarang tampilkan semua langganan aktif

        // Search
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $langgananList = $query->paginate(15);

        // Map ke format yang dibutuhkan blade
        $pelangganList = $langgananList->map(function ($l) {
            $preferensi = $l->user->preferensi;
            return [
                'id'      => $l->user->id,
                'nama'    => $l->user->name,
                'email'   => $l->user->email,
                'avatar'  => strtoupper(substr($l->user->name, 0, 1)),
                'paket'   => $l->paket->nama,
                'periode' => $l->tanggal_pengiriman_berikutnya?->translatedFormat('F Y') ?? '-',
                'status'  => 'menunggu', // nanti dari tabel boxes
                'label'   => 'Menunggu Kurasi',
                'gaya'    => $preferensi?->gaya_berpakaian ?? [],
                'ukuran'  => ($preferensi?->ukuran_atasan ?? '-') . ' / ' . ($preferensi?->ukuran_bawahan ?? '-'),
            ];
        });

        return view('kurators.list-pelanggan', [
            'kuratorNama'    => auth()->user()->name,
            'pelangganList'  => $pelangganList,
            'totalPelanggan' => $langgananList->total(),
            'menunggu'       => $langgananList->total(), // sementara semua menunggu
            'diproses'       => 0,
            'selesai'        => 0,
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
                'label'          => 'Menunggu Kurasi',
                'ukuran_atasan'  => $preferensi?->ukuran_atasan ?? '-',
                'ukuran_bawahan' => $preferensi?->ukuran_bawahan ?? '-',
                'tinggi'         => $preferensi?->tinggi_badan ?? '-',
                'berat'          => $preferensi?->berat_badan ?? '-',
                'gaya'           => $preferensi?->gaya_berpakaian ?? [],
                'warna'          => $preferensi?->warna_favorit ?? [],
                'jenis'          => $preferensi?->jenis_pakaian ?? [],
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
}
