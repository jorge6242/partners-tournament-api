<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsTournamentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournament_users', function ($table) {
            $table->dateTime('register_date')->change();
            $table->dateTime('date_confirmed')->change();
            $table->dateTime('date_verified')->change();
            $table->string('locator')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournament_users', function(Blueprint $table) {
            $table->dropColumn('register_date');
            $table->dropColumn('date_confirmed');
            $table->dropColumn('date_verified');
            $table->dropColumn('locator');
        });
    }
}
