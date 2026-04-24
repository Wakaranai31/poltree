<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Link;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function pengguna(Request $request)
    {
        $roles = ['Dosen', 'Tata Usaha', 'Laboran'];
        $activeRole = in_array($request->query('role'), $roles, true)
            ? $request->query('role')
            : 'Dosen';
        $search = trim((string) $request->query('q', ''));

        $roleHasMatches = Link::query()
            ->where('tag', 'like', '%'.$activeRole.'%')
            ->exists();

        $services = Link::query()
            ->with('kategori')
            ->when($roleHasMatches, function ($query) use ($activeRole) {
                $query->where('tag', 'like', '%'.$activeRole.'%');
            })
            ->when($search !== '', function ($items) use ($search) {
                $items->where(function ($query) use ($search) {
                    $keyword = '%'.$search.'%';

                    $query->where('nama_web', 'like', $keyword)
                        ->orWhere('url', 'like', $keyword)
                        ->orWhere('deskripsi', 'like', $keyword)
                        ->orWhere('tag', 'like', $keyword)
                        ->orWhere('status', 'like', $keyword);
                });
            })
            ->orderByDesc('hit_point')
            ->orderBy('nama_web')
            ->get()
            ->map(function (Link $link) {
                $url = (string) $link->url;

                if ($url !== '' && ! preg_match('/^https?:\/\//i', $url)) {
                    $url = 'https://'.ltrim($url, '/');
                }

                return [
                    'title' => $link->nama_web,
                    'url' => $url ?: '#',
                    'description' => $link->deskripsi ?: 'Layanan website Politeknik Negeri Batam yang tersedia di portal POLTREE.',
                    'category' => $link->kategori?->nama_kategori ?: ($link->tag ?: 'Layanan'),
                    'tags' => array_filter([
                        $link->tag ?: 'Layanan',
                        $link->status ?: 'aktif',
                    ]),
                    'status' => strtolower((string) $link->status),
                ];
            });

        $heroImages = collect(glob(public_path('campus*.{png,jpg,jpeg,webp}'), GLOB_BRACE) ?: [])
            ->sortBy(fn ($path) => basename($path), SORT_NATURAL)
            ->map(fn ($path) => asset(basename($path)))
            ->values();

        if ($heroImages->isEmpty()) {
            $heroImages = collect([asset('campus.png')]);
        }

        $categories = Kategori::query()
            ->orderBy('nama_kategori')
            ->pluck('nama_kategori')
            ->filter()
            ->values();

        if ($categories->isEmpty()) {
            $categories = $services
                ->pluck('category')
                ->filter()
                ->unique()
                ->values();
        }

        return view('dashboard.pengguna', compact('services', 'roles', 'activeRole', 'search', 'heroImages', 'categories'));
    }
}
