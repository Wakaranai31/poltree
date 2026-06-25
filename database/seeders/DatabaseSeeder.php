<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     *
     * Urutan seeder disesuaikan dengan dependensi foreign key:
     * 1. Admin       → t_admin (tidak ada FK)
     * 2. Pengguna    → t_pengguna (tidak ada FK)
     * 3. Kategori    → t_kategori (tidak ada FK)
     * 4. Tag         → t_tag (tidak ada FK)
     * 5. Link        → t_link (FK ke t_kategori)
     * 6. LinkTag     → t_link_tag (FK ke t_link & t_tag)
     *
     * Dibungkus dalam transaction untuk atomicity:
     * jika satu seeder gagal, semua perubahan di-rollback.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $this->call([
                AdminSeeder::class,
                PenggunaSeeder::class,
                KategoriSeeder::class,
                TagSeeder::class,
                LinkSeeder::class,
                LinkTagSeeder::class,
            ]);
        });
    }
}
