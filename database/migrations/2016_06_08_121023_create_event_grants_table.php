<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_grants', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->integer('grant_type_id')->unsigned();
            $table->string('grant_description', '1024');
            $table->integer('grant_status_id')->unsigned()->default('1');
            $table->string('reason',200)->nullable();
            $table->timestamps();

            $table->foreign('event_id')
                    ->references('id')->on('events')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');

            $table->foreign('grant_type_id')
                    ->references('id')->on('event_grant_types')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');

             $table->foreign('grant_status_id')
                    ->references('id')->on('event_grant_statuses')
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
        Schema::drop('event_grants');
    }
}
