<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $query = Layanan::with('kategori')->withCount('favorites');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $layanan = $query->orderBy('name')->paginate(10);

        return view('layanan.index', compact('layanan'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('layanan.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'required|url|max:500',
            'is_active'   => 'sometimes|boolean',
        ]);

        Layanan::create($validated);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function show(Layanan $layanan)
    {
        $layanan->load('kategori')->loadCount('favorites');
        return view('layanan.show', compact('layanan'));
    }

    public function edit(Layanan $layanan)
    {
        $kategori = Kategori::all();
        return view('layanan.edit', compact('layanan', 'kategori'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $validated = $request->validate([
            'kategori_id' => 'sometimes|exists:kategori,id',
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'sometimes|url|max:500',
            'is_active'   => 'sometimes|boolean',
        ]);

        $layanan->update($validated);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
