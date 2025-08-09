<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    protected $fillable = [
        'nama', 'deskripsi', 'lokasi', 'kategori', 'gambar', 'latitude', 'longitude'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
