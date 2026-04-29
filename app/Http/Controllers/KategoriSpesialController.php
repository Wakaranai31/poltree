<?php

namespace App\Http\Controllers;

use App\Models\KategoriSpesial;
use Illuminate\Http\Request;

class KategoriSpesialController extends Controller
{
    public function index(Request $request)
    {
        $kategoriSpesial = KategoriSpesial::where('user_id', $request->user()->id)
            ->withCount(['favorites', 'customLinks'])
            ->get();

        return view('kategori_spesial.index', compact('kategoriSpesial'));
    }

    public function create()
    {
        return view('kategori_spesial.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        KategoriSpesial::create([
            'user_id' => $request->user()->id,
            'name'    => $validated['name'],
        ]);

        return redirect()->route('kategori-spesial.index')->with('success', 'Kategori Spesial berhasil dibuat!');
    }

    public function edit(KategoriSpesial $kategoriSpesial)
    {
        if ($kategoriSpesial->user_id !== request()->user()->id) abort(403, 'Unauthorized');
        return view('kategori_spesial.edit', compact('kategoriSpesial'));
    }

    public function update(Request $request, KategoriSpesial $kategoriSpesial)
    {
        if ($kategoriSpesial->user_id !== $request->user()->id) abort(403, 'Unauthorized');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $kategoriSpesial->update($validated);

        return redirect()->route('kategori-spesial.index')->with('success', 'Kategori Spesial berhasil diperbarui!');
    }

    public function destroy(Request $request, KategoriSpesial $kategoriSpesial)
    {
        if ($kategoriSpesial->user_id !== $request->user()->id) abort(403, 'Unauthorized');

        $kategoriSpesial->delete();

        return redirect()->route('kategori-spesial.index')->with('success', 'Kategori Spesial berhasil dihapus!');
    }
}
