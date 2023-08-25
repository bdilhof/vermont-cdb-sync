<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdb_centres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cdb_id')->nullable();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('street');
            $table->string('number');
            $table->string('zip');
            $table->string('city');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('public_ip')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('cdb_centres', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('cdb_countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdb_centres');
    }
};
