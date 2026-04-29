<?php

namespace App\Http\Controllers;

use App\Models\LayananSpesial;
use App\Models\KategoriSpesial;
use Illuminate\Http\Request;

class LayananSpesialController extends Controller
{
    public function index(Request $request)
    {
        $layananSpesial = LayananSpesial::where('user_id', $request->user()->id)
            ->with('category')
            ->get();

        return view('layanan_spesial.index', compact('layananSpesial'));
    }

    public function create(Request $request)
    {
        $kategoriSpesial = KategoriSpesial::where('user_id', $request->user()->id)->get();
        return view('layanan_spesial.create', compact('kategoriSpesial'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'url'         => 'required|url|max:500',
            'category_id' => 'nullable|exists:kategori_spesial,id',
        ]);

        LayananSpesial::create([
            'user_id'     => $request->user()->id,
            'name'        => $validated['name'],
            'url'         => $validated['url'],
            'category_id' => $validated['category_id'] ?? null,
        ]);

        return redirect()->route('layanan-spesial.index')->with('success', 'Tautan khusus berhasil dibuat!');
    }

    public function edit(LayananSpesial $layananSpesial)
    {
        if ($layananSpesial->user_id !== request()->user()->id) abort(403, 'Unauthorized');
        $kategoriSpesial = KategoriSpesial::where('user_id', request()->user()->id)->get();
        return view('layanan_spesial.edit', compact('layananSpesial', 'kategoriSpesial'));
    }

    public function update(Request $request, LayananSpesial $layananSpesial)
    {
        if ($layananSpesial->user_id !== $request->user()->id) abort(403, 'Unauthorized');

        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'url'         => 'sometimes|url|max:500',
            'category_id' => 'nullable|exists:kategori_spesial,id',
        ]);

        $layananSpesial->update($validated);

        return redirect()->route('layanan-spesial.index')->with('success', 'Tautan khusus berhasil diperbarui!');
    }

    public function destroy(Request $request, LayananSpesial $layananSpesial)
    {
        if ($layananSpesial->user_id !== $request->user()->id) abort(403, 'Unauthorized');

        $layananSpesial->delete();

        return redirect()->route('layanan-spesial.index')->with('success', 'Tautan khusus berhasil dihapus!');
    }
}
