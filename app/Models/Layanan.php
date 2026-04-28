<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
use HasFactory;

    protected $table = 'layanan';

    // Kolom division_id diubah menjadi kategori_id menyesuaikan tabel baru
    protected $fillable = ['kategori_id', 'name', 'description', 'url', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function favorites()
    {
        return $this->hasMany(LayananFavorit::class, 'service_id');
    }
}
