<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalonMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calon_mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user');
                $table->foreign('id_user')->references('id')->on('users');
            $table->unsignedBigInteger('id_gelombang');
                $table->foreign('id_gelombang')->references('id')->on('gelombang');
            $table->unsignedBigInteger('id_jurusan');
                $table->foreign('id_jurusan')->references('id')->on('jurusan');
            $table->string('nama_lengkap');
            $table->text('alamat');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calon_mahasiswa');
    }
}
