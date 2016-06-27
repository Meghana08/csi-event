<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNonCsiIndividualSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('non_csi_individual_subscribers', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->string('name',50);
            $table->string('working_status', 50);
            $table->string('email', 254);
            $table->bigInteger('contact_number');
            $table->date('dob');
            $table->tinyInteger('Payment_status')->default(0);
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
        Schema::drop('non_csi_individual_subscribers');
    }
}
