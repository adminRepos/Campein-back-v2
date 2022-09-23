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
        Schema::create('sub_centros_poblados', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',12)->nullable(false);
            $table->string('nombre',45)->nullable(false);
            $table->integer('poblacion_habilitada')->nullable(false);
            $table->unsignedBigInteger('centro_poblado_id')->nullable(false)    ;

            $table->timestamps();
            $table->foreign('centro_poblado_id')->references('id')->on('centros_poblados');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_centro_poblados');
    }
};
