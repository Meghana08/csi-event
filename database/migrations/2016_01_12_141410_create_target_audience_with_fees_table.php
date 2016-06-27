<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetAudienceWithFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_audience_with_fees', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigInteger('event_id')->unsigned();
            $table->integer('target_id')->unsigned();
            $table->integer('fee')->unsigned();
            $table->timestamps();

            $table->foreign('event_id')
                    ->references('id')->on('events')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');

            $table->foreign('target_id')
                    ->references('id')->on('target_audiences')
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
         Schema::drop('fees');
    }
}
