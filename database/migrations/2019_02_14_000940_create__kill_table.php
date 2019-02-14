<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kill', function (Blueprint $table) {
            $table->increments('id');
            $table->time('time_kill');
            $table->integer('game_id');
            $table->integer('player_killer');
            $table->integer('player_dead');
            $table->string('killed_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kill');
    }
}
