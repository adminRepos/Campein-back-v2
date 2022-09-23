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
        Schema::create('preguntas_encuestas', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta',255);
            $table->unsignedBigInteger('encuesta_id');
            $table->timestamps();
            $table->foreign('encuesta_id')->references('id')->on('encuestas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preguntas_encuestas');
    }
};
