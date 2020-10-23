<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengingat extends Model
{
    //Inisialisasi nama tabel
    protected $table = 'pengingats';

    //Inisialisasi field yang boleh diisi
    protected $fillable = [
        'judul', 'keterangan', 'waktudeadline'
    ];
}
