<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->BigIncrements('id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->bigInteger('member_id')->unsigned();
            $table->string('title', 1024)->nullable();
            $table->string('notification', 1024)->nullable();
            $table->tinyInteger('is_checked')->default(0);
            $table->timestamps();

            $table->foreign('type_id')
                    ->references('id')->on('notification_types')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE');

            $table->foreign('member_id')
                    ->references('id')->on('members')
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
        Schema::drop('notifications');
    }
}
