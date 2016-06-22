<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTypeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_type_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned();
            $table->integer('event_type_id')->unsigned();
            $table->integer('max_seats');
            $table->date('registration_start_date');
            $table->date('registration_end_date');
            $table->time('registration_start_time');
            $table->time('registration_end_time');
            $table->tinyInteger('certification');
            $table->tinyInteger('meals');

            $table->timestamps();

            $table->foreign('event_id')
                    ->references('id')->on('events')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');
            $table->foreign('event_type_id')
                    ->references('id')->on('event_types')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_type_details');
    }
}
