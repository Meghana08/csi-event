<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('event_id')->unsigned();
            $table->string('post_text',500);
            $table->string('post_image',50)->nullable();

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
        Schema::drop('event_posts');
    }
}
