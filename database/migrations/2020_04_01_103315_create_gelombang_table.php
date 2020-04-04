<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGelombangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gelombang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->integer('kuota');
            $table->decimal('biaya_formulir', 9, 0);
            $table->decimal('biaya_admisi', 9, 0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tanggal_tes');
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
        Schema::dropIfExists('gelombang');
    }
}
