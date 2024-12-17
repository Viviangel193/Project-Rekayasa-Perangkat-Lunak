<?php
// database/migrations/2024_11_24_191135_create_pembayaran_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('periode');
            $table->integer('sks');
            $table->string('ice')->nullable();
            $table->decimal('uang_kesehatan', 10, 2);
            $table->decimal('uang_gedung', 10, 2);
            $table->string('prestasi')->nullable();
            $table->string('no_va')->nullable(); // Tambahkan kolom No. VA
            $table->string('status_transaksi');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
