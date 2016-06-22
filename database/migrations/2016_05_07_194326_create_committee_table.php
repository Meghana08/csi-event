<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committee', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->string('member_name','30');
            $table->string('role');
            $table->string('CSImembershipstatus');
            $table->string('email');
            $table->bigInteger('phone');
            $table->string('institute','50');
            $table->timestamps();

            $table->foreign('event_id')
                   ->references('id')->on('events')
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
        Schema::drop('committee');
    }
}
