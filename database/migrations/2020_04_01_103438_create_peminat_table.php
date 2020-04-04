<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user'); //admin
                $table->foreign('id_user')->references('id')->on('users');
            $table->string('nama_lengkap');
            $table->string('no_handphone');
            $table->string('email')->unique();
            $table->enum('status', ['belum-follow-up', 'sudah-follow-up']);
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
        Schema::dropIfExists('peminat');
    }
}
