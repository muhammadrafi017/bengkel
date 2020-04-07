<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('no_handphone');
            $table->string('alamat');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('is_owner')->default(0);
            $table->tinyInteger('is_admin')->default(0);
            $table->tinyInteger('is_member')->default(0);
            $table->string('kode')->nullable();
            $table->integer('point')->default(0);
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
