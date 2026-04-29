<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // 1. Menampilkan daftar kategori
    public function index(Request $request)
    {
        // Mengambil data kategori beserta jumlah layanan di dalamnya
        $query = Kategori::withCount('layanan');

        // Fitur pencarian tetap kita pertahankan
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Menggunakan paginate untuk web (misal: 10 data per halaman)
        $kategori = $query->orderBy('name')->paginate(10);

        // Mengirim data ke halaman Blade
        return view('kategori.index', compact('kategori'));
    }

    // 2. [BARU] Menampilkan halaman form tambah data
    public function create()
    {
        return view('kategori.create');
    }

    // 3. Menyimpan data baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Kategori::create($validated);

        // Setelah berhasil, arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // 4. Menampilkan detail spesifik satu kategori
    public function show(Kategori $kategori)
    {
        // Memuat data layanan yang ada di dalam kategori ini
        $kategori->load('layanan');

        return view('kategori.show', compact('kategori'));
    }

    // 5. [BARU] Menampilkan halaman form edit data
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    // 6. Menyimpan perubahan data ke database
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // 7. Menghapus data dari database
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
