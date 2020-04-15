<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailNotaProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_nota_produk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_nota');
                $table->foreign('id_nota')->references('id')->on('nota_produk');
            $table->unsignedBigInteger('id_produk');
                $table->foreign('id_produk')->references('id')->on('produk');
            $table->integer('kuantitas');
            $table->decimal('harga_satuan', 9, 0);
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
        Schema::dropIfExists('detail_nota_produk');
    }
}
