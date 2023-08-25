<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cdb_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('html_symbol')->nullable();
            $table->string('code');
            $table->string('name');
            $table->string('symbol');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cdb_currencies');
    }
};
