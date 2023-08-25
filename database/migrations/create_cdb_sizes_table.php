<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cdb_sizes', function (Blueprint $table) {
            $table->id();
            $table->integer('eso_id')->unique();
            $table->string('code');
            $table->integer('size_weight');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cdb_sizes');
    }
};
