<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananSpesial extends Model
{
    use HasFactory;

    protected $table = 'layanan_spesial';

    protected $fillable = ['user_id', 'category_id', 'name', 'url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(KategoriSpesial::class, 'category_id');
    }
}
