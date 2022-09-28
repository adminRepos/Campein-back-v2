<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('campeigns', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->string('lema', 150)->nullable();
            $table->string('url', 200)->nullable();
            $table->longText('mision')->nullable();
            $table->longText('vision')->nullable();
            $table->string('email', 60)->unique();
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('partido_id');
            $table->unsignedBigInteger('country_id');
            $table->foreign('partido_id')
                ->references('id')
                ->on('partidos')
                ->onDelete('restrict');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campeigns');
    }
};
