<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCategoriesGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_categories_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 255)->nullable();
            $table->integer('age_from')->nullable();
            $table->integer('age_to')->nullable();
            $table->integer('gender_id')->nullable();
            $table->double('golf_handicap_from', 8, 2)->nullable();
            $table->double('golf_handicap_to', 8, 2)->nullable();
            $table->bigInteger('category_id')->nullable();
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
        Schema::dropIfExists('t_categories_groups');
    }
}
