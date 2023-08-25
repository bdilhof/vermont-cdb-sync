<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cdb_order_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_sk_hu')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('eso_id');
            $table->bigInteger('diagram_id')->nullable();
            $table->bigInteger('inventory_group_id')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cdb_order_groups');
    }
};
