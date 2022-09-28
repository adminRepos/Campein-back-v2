<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 12)->unique()->index();
            $table->string('nombre', 45)->unique();
            $table->boolean('estado')->default(true);
            $table->unsignedBigInteger('zone')->nullable();
            $table->unsignedBigInteger('sub_territory_id');
            $table->foreign('sub_territory_id')
                ->references('id')
                ->on('subterritory')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zones');
    }
};
