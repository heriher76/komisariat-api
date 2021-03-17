<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('messages', function (Blueprint $table) {
        $table->increments('id');
        $table->text('message');
        $table->integer('id_user')->unsigned()->nullable();
        $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        $table->integer('id_group')->unsigned()->nullable();
        $table->foreign('id_group')->references('id')->on('groupchats')->onUpdate('cascade')->onDelete('cascade');
        $table->integer('id_personal')->unsigned()->nullable();
        $table->foreign('id_personal')->references('id')->on('personalchats')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('messages');
    }
}
