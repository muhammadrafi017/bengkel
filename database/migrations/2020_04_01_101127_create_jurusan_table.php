<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_kategori_jurusan');
                $table->foreign('id_kategori_jurusan')->references('id')->on('kategori_jurusan');
            $table->string('nama');
            $table->enum('level', ['SMA-D3', 'SMA-S1', 'S1-S2', 'S2-S3']);
            $table->text('deskripsi');
            $table->integer('dilihat')->default(0);
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
        Schema::dropIfExists('jurusan');
    }
}
