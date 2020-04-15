<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_produk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_nota');
            $table->unsignedBigInteger('id_admin');
                $table->foreign('id_admin')->references('id')->on('users');
            $table->unsignedBigInteger('id_member')->nullable();
                $table->foreign('id_member')->references('id')->on('users');
            $table->unsignedBigInteger('id_kupon')->nullable();
                $table->foreign('id_kupon')->references('id')->on('kupon');
            $table->string('nama_pelanggan');
            $table->string('alamat_pelanggan');
            $table->string('no_handphone_pelanggan');
            $table->decimal('potongan_harga', 9, 0)->default(0);
            $table->decimal('total_harga', 9, 0)->default(0);
            $table->enum('status_pembayaran', ['belum-lunas', 'lunas']);
            $table->date('tanggal_pembayaran')->nullable();
            $table->enum('status_pengambilan', ['belum-ambil', 'ambil']);
            $table->date('tanggal_pengambilan')->nullable();
            $table->enum('metode', ['offline', 'online']);
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
        Schema::dropIfExists('nota_produk');
    }
}
