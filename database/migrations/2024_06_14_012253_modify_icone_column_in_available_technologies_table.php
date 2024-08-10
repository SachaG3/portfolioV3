<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('available_technologies', function (Blueprint $table) {
            $table->text('icone')->change();
        });

        Schema::table('technologies', function (Blueprint $table) {
            $table->text('icone')->change();
        });
    }

    public function down()
    {
        Schema::table('available_technologies', function (Blueprint $table) {
            $table->string('icone')->change();
        });

        Schema::table('technologies', function (Blueprint $table) {
            $table->string('icone')->change();
        });
    }
};

