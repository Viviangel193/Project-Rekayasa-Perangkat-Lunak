<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->bigIncrements('id'); // Gunakan bigIncrements untuk ID
            $table->string('nim')->unique();
            $table->string('nama_lengkap');
            $table->string('angkatan');
            $table->string('jurusan');
            $table->string('jenis_kelamin');
            $table->decimal('saldo', 15, 2);  // Ensure saldo is decimal or integer
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
}
