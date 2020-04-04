<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTesCalonMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tes_calon_mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_calon_mahasiswa');
                $table->foreign('id_calon_mahasiswa')->references('id')->on('calon_mahasiswa');
            $table->date('tanggal_tes');
            $table->enum('status', ['belum-diperiksa', 'lulus', 'tidak-lulus']);
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
        Schema::dropIfExists('tes_calon_mahasiswa');
    }
}
