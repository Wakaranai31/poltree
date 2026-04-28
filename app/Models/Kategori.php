<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
use HasFactory;

    protected $table = 'kategori';

    protected $fillable = ['name', 'description'];

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'kategori_id');
    }
}
