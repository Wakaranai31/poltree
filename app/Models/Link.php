<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 't_link';

    protected $primaryKey = 'id_link';

    public $timestamps = false;

    protected $fillable = [
        'id_link', 'nama_web', 'url', 'deskripsi',
        'tag', 'status', 'hit_point',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
