<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentUsersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('register_date')->nullable();
            $table->string('attach_file',255)->nullable();
            $table->string('confirmation_link',255)->nullable();
            $table->integer('status')->nullable();
            $table->date('date_confirmed')->nullable();
            $table->date('date_verified')->nullable();
            $table->date('locator')->nullable();
            $table->bigInteger('tournament_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('t_payment_methods_id')->nullable();
            $table->bigInteger('t_categories_groups_id')->nullable();
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
        Schema::dropIfExists('tournament_users');
    }
}
