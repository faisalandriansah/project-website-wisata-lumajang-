<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['wisata_id', 'nama_pengunjung', 'isi'];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
}
