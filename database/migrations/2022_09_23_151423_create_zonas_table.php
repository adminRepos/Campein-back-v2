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
        Schema::create('zonas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',12)->nullable(false);
            $table->string('nombre',45)->nullable(false);
            $table->unsignedBigInteger('subcentropoblado_id')->nullable(true);
            $table->unsignedBigInteger('zona_id')->nullable(true);
            $table->timestamps();
            $table->foreign('subcentropoblado_id')->references('id')->on('sub_centros_poblados');
            $table->foreign('zona_id')->references('id')->on('zonas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zonas');
    }
};
