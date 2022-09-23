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
        Schema::create('centros_poblados', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',12)->nullable(false);
            $table->string('nombre',45)->nullable(false)->unique(true);
            $table->unsignedBigInteger('pais_id')->nullable(false);
            $table->timestamps();
            $table->foreign('pais_id')->references('id')->on('pais');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centro_poblados');
    }
};
