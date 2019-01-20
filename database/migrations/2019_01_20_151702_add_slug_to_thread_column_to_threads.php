<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToThreadColumnToThreads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
        });
    }
}
