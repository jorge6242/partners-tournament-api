<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCategoryGroupsTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('t_category_groups__tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tournament_id')->nullable();
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
        Schema::dropIfExists('t_category_groups__tournaments');
    }
}
