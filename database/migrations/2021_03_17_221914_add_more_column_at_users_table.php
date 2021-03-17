<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnAtUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->string('sex')->nullable();
          $table->integer('age')->nullable();
          $table->text('jenjang_training')->nullable();
          $table->text('pengalaman_organisasi')->nullable();
          $table->string('linkedin')->nullable();
          $table->string('instagram')->nullable();
          $table->text('other_social_media')->nullable();
          $table->string('year_join')->nullable();
          $table->string('angkatan_kuliah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('sex');
          $table->dropColumn('age');
          $table->dropColumn('jenjang_training');
          $table->dropColumn('pengalaman_organisasi');
          $table->dropColumn('linkedin');
          $table->dropColumn('instagram');
          $table->dropColumn('other_social_media');
          $table->dropColumn('year_join');
          $table->dropColumn('angkatan_kuliah');
        });
    }
}
