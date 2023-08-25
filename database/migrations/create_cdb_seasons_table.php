<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cdb_seasons', function (Blueprint $table) {
            $table->id();
            $table->integer('eso_id')->unique();
            $table->string('code');
            $table->string('name');
            $table->string('season_number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cdb_seasons');
    }
};
