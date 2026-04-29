<?php

namespace App\Http\Controllers;

use App\Models\LayananFavorit;
use App\Models\KategoriSpesial;
use Illuminate\Http\Request;

class LayananFavoritController extends Controller
{
    public function index(Request $request)
    {
        $favorit = LayananFavorit::where('user_id', $request->user()->id)
            ->with(['service.kategori', 'category'])
            ->get();

        $kategoriSpesial = KategoriSpesial::where('user_id', $request->user()->id)->get();

        return view('layanan_favorit.index', compact('favorit', 'kategoriSpesial'));
    }

    // Fungsi untuk menambah/menghapus favorit via tombol
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'service_id'  => 'required|exists:layanan,id',
            'category_id' => 'nullable|exists:kategori_spesial,id',
        ]);

        $user = $request->user();

        $existing = LayananFavorit::where('user_id', $user->id)
            ->where('service_id', $validated['service_id'])
            ->first();

        // Jika sudah ada, maka hapus dari favorit
        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Berhasil dihapus dari favorit');
        }

        // Jika belum ada, tambahkan ke favorit
        LayananFavorit::create([
            'user_id'     => $user->id,
            'service_id'  => $validated['service_id'],
            'category_id' => $validated['category_id'] ?? null,
        ]);

        return back()->with('success', 'Berhasil ditambahkan ke favorit');
    }

    public function updateCategory(Request $request, LayananFavorit $layananFavorit)
    {
        if ($layananFavorit->user_id !== $request->user()->id) abort(403, 'Unauthorized');

        $validated = $request->validate([
            'category_id' => 'nullable|exists:kategori_spesial,id',
        ]);

        $layananFavorit->update(['category_id' => $validated['category_id']]);

        return back()->with('success', 'Kategori favorit berhasil diperbarui');
    }

    public function destroy(Request $request, LayananFavorit $layananFavorit)
    {
        if ($layananFavorit->user_id !== $request->user()->id) abort(403, 'Unauthorized');

        $layananFavorit->delete();

        return back()->with('success', 'Berhasil dihapus dari favorit');
    }
}
