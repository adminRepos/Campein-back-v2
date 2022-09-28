<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('territories', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 12)->unique()->index();
            $table->string('nombre', 45)->unique();
            $table->bigInteger('votantes')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('territory_type_id');
            $table->unsignedBigInteger('country_id');
            $table->foreign('territory_type_id')
                ->references('id')
                ->on('territory_types')
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
        Schema::dropIfExists('territories');
    }
};
