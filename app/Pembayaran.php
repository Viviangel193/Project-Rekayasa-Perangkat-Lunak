<?php
// app/Pembayaran.php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mahasiswa;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'mahasiswa_id',
        'id_tagihan',
        'periode',
        'sks',
        'ice',
        'uang_kesehatan',
        'uang_gedung',
        'prestasi',
        'no_va', // Tambahkan No. VA
        'status_transaksi', // Tambahkan status transaksi
    ];

    // Relasi ke tabel mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
