<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Tambahkan properti jika diperlukan
    protected $table = 'penggunas'; // Nama tabel sesuai dengan database Anda

    // Relasi ke tabel Mahasiswa
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id'); // Sesuaikan kolom foreign key jika berbeda
    }
}
