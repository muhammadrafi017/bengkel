<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_nota');
                $table->foreign('id_nota')->references('id')->on('nota_service');
            $table->unsignedBigInteger('id_service');
                $table->foreign('id_service')->references('id')->on('service');
            $table->unsignedBigInteger('id_mekanik')->nullable();
                $table->foreign('id_mekanik')->references('id')->on('mekanik');
            $table->unsignedBigInteger('id_barang');
                $table->foreign('id_barang')->references('id')->on('barang');
            $table->string('keterangan');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 9, 0);
            $table->date('tanggal_proses')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status_pengerjaan', ['pending', 'cancel', 'proses', 'masalah', 'selesai'])->default('pending');
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
        Schema::dropIfExists('service_barang');
    }
}
