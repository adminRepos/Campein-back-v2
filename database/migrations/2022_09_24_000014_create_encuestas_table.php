<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 120);
            $table->timestamp('fecha_aplicacion');
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('prospect_id');
            $table->foreign('prospect_id')
                ->references('id')
                ->on('prospects')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('polls');
    }
};
