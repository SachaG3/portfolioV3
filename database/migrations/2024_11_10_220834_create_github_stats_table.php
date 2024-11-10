<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGithubStatsTable extends Migration
{
    public function up()
    {
        Schema::create('github_stats', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->integer('num_of_repos');
            $table->integer('total_commits');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('github_stats');
    }
}

