<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\FoundItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    /**
     * Simpan klaim baru dari user yang sudah login.
     */
    public function store(Request $request, FoundItem $foundItem)
    {
        // Pastikan sudah login
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('info', 'Silakan masuk terlebih dahulu untuk mengajukan klaim.');
        }

        // Validasi input
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:20', 'max:1000'],
            'photo'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'message.required' => 'Pesan bukti kepemilikan wajib diisi.',
            'message.min'      => 'Pesan minimal 20 karakter.',
            'message.max'      => 'Pesan maksimal 1000 karakter.',
            'photo.image'      => 'File harus berupa gambar.',
            'photo.max'        => 'Ukuran foto maksimal 5 MB.',
        ]);

        // Cek apakah user sudah pernah klaim barang ini
        $existing = Claim::where('user_id', Auth::id())
            ->where('found_item_id', $foundItem->id)
            ->first();

        if ($existing) {
            return redirect()->route('found-items.show', $foundItem)
                ->with('error', 'Kamu sudah pernah mengajukan klaim untuk barang ini.');
        }

        // Simpan foto bukti jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('claims', 'public');
        }

        // Simpan klaim
        Claim::create([
            'user_id'       => Auth::id(),
            'found_item_id' => $foundItem->id,
            'message'       => $validated['message'],
            'photo_path'    => $photoPath,
            'status'        => 'menunggu',
        ]);

        return redirect()->route('found-items.show', $foundItem)
            ->with('success', 'Klaim berhasil diajukan! Tim kami akan segera meninjau permintaanmu.');
    }

    public function index(Request $request)
    {
        $query = Claim::with([
            'user',
            'foundItem.categoryData',
        ]);

        if ($request->status && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $claims = $query->latest()->get();

        return view('admin.claims.index', compact('claims'));
    }

    public function verify(Claim $claim)
    {
        $claim->update([
            'status' => 'diterima',
        ]);

        // Update status FoundItem menjadi 'dikembalikan' + set dikembalikan_at
        $foundItem = $claim->foundItem;
        if ($foundItem && $foundItem->status !== 'dikembalikan' && $foundItem->status !== 'selesai') {
            $foundItem->update([
                'status'          => 'dikembalikan',
                'dikembalikan_at' => now(),
            ]);
        }

        return back()->with('success', 'Klaim berhasil disetujui.');
    }

    public function reject(Claim $claim)
    {
        $claim->update([
            'status' => 'ditolak',
        ]);

        return back()->with('success', 'Klaim berhasil ditolak.');
    }

    /**
     * Tandai FoundItem sebagai selesai (barang sudah dikembalikan ke pemilik).
     * Dipanggil oleh pemilik laporan (user yang melaporkan).
     */
    public function markFoundItemReturned(FoundItem $foundItem)
    {
        // Pastikan hanya pemilik laporan yang bisa mengkonfirmasi
        if (Auth::id() !== $foundItem->user_id) {
            abort(403, 'Tidak diizinkan.');
        }

        if ($foundItem->status === 'dikembalikan') {
            $foundItem->update([
                'status'    => 'selesai',
                'selesai_at'=> now(),
            ]);
        }

        return redirect()
            ->route('claims.ditemukan')
            ->with('success', 'Barang telah dikonfirmasi dikembalikan. Status diperbarui ke Selesai.');
    }
}
