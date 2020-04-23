<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description',255)->nullable();
            $table->integer('max_participants')->nullable();
            $table->string('description_price',255)->nullable();
            $table->string('template_welcome_mail',255)->nullable();
            $table->string('template_confirmation_mail',255)->nullable();
            $table->decimal('amount', 18, 2)->nullable();
            $table->integer('participant_type')->nullable();
            $table->dateTime('date_register_from', 0)->nullable();
            $table->dateTime('date_register_to', 0)->nullable();
            $table->dateTime('date_from', 0)->nullable();
            $table->dateTime('date_to', 0)->nullable();
            $table->boolean('status')->default(1);
            $table->string('picture',255)->nullable();
            $table->bigInteger('t_rule_type_id')->nullable();
            $table->bigInteger('currency_id')->nullable();
            $table->bigInteger('t_categories_id')->nullable();
            $table->bigInteger('t_category_types_id')->nullable();
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
        Schema::dropIfExists('tournaments');
    }
}
