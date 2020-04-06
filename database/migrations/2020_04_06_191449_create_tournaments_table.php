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
            $table->decimal('amount', 18, 2);
            $table->integer('participant_type')->nullable();
            $table->date('date_register_from')->nullable();
            $table->date('date_register_to')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->bigInteger('rule_type_id')->nullable();
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
