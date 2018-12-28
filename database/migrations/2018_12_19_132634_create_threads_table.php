<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('channel_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('channel_id')
                ->references('id')
                ->on('channels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
