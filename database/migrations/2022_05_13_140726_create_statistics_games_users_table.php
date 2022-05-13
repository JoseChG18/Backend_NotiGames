<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsGamesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics_games_users', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('game_id')->constrained('games');
            $table->foreignId('statistic_id')->constrained('statistics');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics_games_users');
    }
}
