<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pembayaran;

class Mahasiswa extends Model
{
    protected $fillable = [
        'nim',
        'nama_lengkap',
        'angkatan',
        'jurusan',
        'jenis_kelamin',
        'saldo',
    ];

    // Relasi ke tabel pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'mahasiswa_id');
    }

    public function hitungSaldo()
    {
        // // Contoh perhitungan: total tagihan - total pembayaran
        // $totalTagihan = $this->pembayaran->where('tipe', 'tagihan')->sum('jumlah');
        // $totalPembayaran = $this->pembayaran->where('tipe', 'pembayaran')->sum('jumlah');

        // $saldo = $totalTagihan - $totalPembayaran;
        return $this->saldo;
    }

}
