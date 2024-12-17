<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'penggunas';       // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key yang benar
    public $incrementing = true;          // Jika menggunakan auto-increment
    protected $keyType = 'int';           // Tipe data primary key

    protected $fillable = [
        'nama_pengguna',
        'kata_sandi',
        'peran',
        'email'
    ];

    public function mahasiswa()
    {
        // Menyambungkan pengguna dengan mahasiswa berdasarkan 'nama_pengguna' dan 'nim'
        return $this->hasOne(Mahasiswa::class, 'nim', 'nama_pengguna');
    }

}
