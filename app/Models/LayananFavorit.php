<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananFavorit extends Model
{
    use HasFactory;

    protected $table = 'layanan_favorit';

    public $timestamps = false;

    protected $fillable = ['user_id', 'service_id', 'category_id'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Layanan::class, 'service_id');
    }

    public function category()
    {
        return $this->belongsTo(KategoriSpesial::class, 'category_id');
    }
}
