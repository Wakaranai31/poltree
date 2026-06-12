<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Wajib ditambahkan karena beda folder
use App\Models\Layanan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Services\LinkStatusChecker; // Menggunakan Service dari teman Anda

class LayananController extends Controller
{
    // 1. Menampilkan daftar layanan (Asli milik Anda)
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

    // 2. Menampilkan form tambah (Asli milik Anda)
    public function create()
    {
        $kategori = Kategori::all();
        return view('layanan.create', compact('kategori'));
    }

    // 3. Menyimpan data (Asli milik Anda)
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

    // 4. Menampilkan detail (Asli milik Anda)
    public function show(Layanan $layanan)
    {
        $layanan->load('kategori')->loadCount('favorites');
        return view('layanan.show', compact('layanan'));
    }

    // 5. Menampilkan form edit (Asli milik Anda)
    public function edit(Layanan $layanan)
    {
        $kategori = Kategori::all();
        return view('layanan.edit', compact('layanan', 'kategori'));
    }

    // 6. Menyimpan update data (Asli milik Anda)
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

    // 7. Menghapus data (Asli milik Anda)
    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus!');
    }

    // ========================================================================
    // FITUR BARU DARI MANPRO NIZAN12 (HEALTH CHECKER / API STATUS)
    // ========================================================================

    /**
     * [BARU] Menjalankan pengecekan status untuk SEMUA layanan via Artisan Command
     * Diadopsi dari checkAllLinks() milik teman Anda.
     */
    public function checkAllLayanan()
    {
        // Perintah artisan disesuaikan dengan nama model Anda (Layanan)
        Artisan::call('layanan:check-status');

        return back()->with('success', 'Pemeriksaan status semua layanan telah dijalankan di latar belakang.');
    }

    /**
     * [BARU] Mengecek status SATU layanan/URL secara realtime (untuk tombol 'Test API')
     * Diadopsi dari checkApi() di DashboardController milik teman Anda.
     */
    public function checkSingleLayanan(Request $request, LinkStatusChecker $checker)
    {
        $url = $request->input('url');

        if (empty($url)) {
            return response()->json([
                'success' => false,
                'message' => 'URL wajib diisi.'
            ], 400);
        }

        // Tambahkan protokol http/https jika belum ada
        if (!preg_match('/^(https?:\/\/)/i', $url)) {
            $url = 'https://' . $url;
        }

        // Menggunakan service LinkStatusChecker dari nizan12
        $result = $checker->checkUrl($url);

        return response()->json([
            'success' => true,
            'data'    => $result
        ]);
    }
}