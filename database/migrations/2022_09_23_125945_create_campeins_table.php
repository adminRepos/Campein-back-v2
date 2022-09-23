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
        Schema::create('campeins', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',120)->nullable(false);
            $table->string('lema',120);
            $table->string('url',255);
            $table->date('fecha_creacion')->nullable(false);
            $table->text('mision',1200);
            $table->text('vision',1200);
            $table->string('email',60)->unique(true);
            $table->unsignedBigInteger('pais_id');
            $table->unsignedBigInteger('candidato_id');
            $table->foreign('pais_id')->references('id')->on('pais');
            $table->foreign('candidato_id')->references('id')->on('candidatos');



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
        Schema::dropIfExists('campeins');
    }
};
