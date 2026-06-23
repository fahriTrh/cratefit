<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'box_id' => 'required|exists:boxes,id',
            'rated_user_id' => 'required|exists:users,id',
            'tipe' => 'required|in:kurator,kurir',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $box = Box::findOrFail($request->box_id);

        // Validasi bahwa box milik user yang memberikan rating
        if ($box->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        // Cek apakah rating sudah pernah diberikan
        $existingRating = Rating::where('user_id', auth()->id())
            ->where('rated_user_id', $request->rated_user_id)
            ->where('box_id', $request->box_id)
            ->where('tipe', $request->tipe)
            ->first();

        if ($existingRating) {
            // Update rating lama
            $existingRating->update([
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]);
            $message = 'Rating berhasil diperbarui!';
        } else {
            // Buat rating baru
            Rating::create([
                'user_id' => auth()->id(),
                'rated_user_id' => $request->rated_user_id,
                'box_id' => $request->box_id,
                'tipe' => $request->tipe,
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]);
            $message = 'Rating berhasil ditambahkan!';
        }

        return redirect()->back()->with('success', $message);
    }

}
