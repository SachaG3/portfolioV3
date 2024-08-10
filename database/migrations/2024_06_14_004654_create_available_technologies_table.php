<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableTechnologiesTable extends Migration
{
    public function up()
    {
        Schema::create('available_technologies', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('icone')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('available_technologies');
    }
}
