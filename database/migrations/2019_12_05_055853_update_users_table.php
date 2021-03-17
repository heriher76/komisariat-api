<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->string('hp')->after('password')->nullable();
          $table->string('address')->after('hp')->nullable();
          $table->string('department')->after('address')->nullable();
          $table->string('photo')->after('department')->nullable();
          $table->string('komisariat')->after('photo')->nullable();
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
        $table->dropColumn('hp');
        $table->dropColumn('address');
        $table->dropColumn('department');
        $table->dropColumn('photo');
        $table->dropColumn('komisariat');
      });
    }
}
