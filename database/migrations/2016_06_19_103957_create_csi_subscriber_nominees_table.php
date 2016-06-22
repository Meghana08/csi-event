<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsiSubscriberNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csi_subscriber_nominees', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('subscriber_id')->unsigned();
            $table->string('nominee_name',50);
            $table->string('role', 50);
            $table->string('email', 254);
            $table->bigInteger('contact_number');
            $table->date('dob');

            $table->timestamps();
            
            $table->foreign('subscriber_id')
                    ->references('id')->on('csi_organisation_subscribers')
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
        Schema::drop('csi_subscriber_nominees');
    }
}
