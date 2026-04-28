<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSpesial extends Model
{
    use HasFactory;

    protected $table = 'kategori_spesial';

    public $timestamps = false;

    protected $fillable = ['user_id', 'name'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(LayananFavorit::class, 'category_id');
    }

    public function customLinks()
    {
        return $this->hasMany(LayananSpesial::class, 'category_id');
    }
}
