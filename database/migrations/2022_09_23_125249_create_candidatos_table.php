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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->char('genero',1)->nullable(false);
            $table->string('nombre',25)->nullable(false);
            $table->string('apellido',25)->nullable(false);
            $table->string('identificacion',16);
            $table->unsignedBigInteger('partido_id');
            $table->foreign('partido_id')->references('id')->on('partido_politico');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatos');
    }
};
