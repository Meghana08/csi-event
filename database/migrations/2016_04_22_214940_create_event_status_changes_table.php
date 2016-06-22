<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStatusChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_status_changes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned();
            $table->integer('prev_status')->unsigned();
            $table->integer('cur_status')->unsigned();
           // $table->integer('admin_id')->unsigned();

            $table->timestamps();

            $table->foreign('event_id')
                    ->references('id')->on('events')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');

            $table->foreign('prev_status')
                    ->references('id')->on('event_status')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');

            $table->foreign('cur_status')
                    ->references('id')->on('event_status')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');
            
            // $table->foreign('admin_id')
            //         ->references('id')->on('admins')
            //         ->onUpdate('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_status_changes');
    }
}
