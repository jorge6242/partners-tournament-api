<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournaments', function(Blueprint $table) {
            $table->longText('description_details')->default("");
            $table->longText('user_comments')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournaments', function(Blueprint $table) {
            $table->dropColumn('description_details');
            $table->dropColumn('user_comments');
        });
    }
}
