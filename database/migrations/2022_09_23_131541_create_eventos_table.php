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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',120)->nullable(false)->unique(true);
            $table->date('fecha_inicio')->nullable(false);
            $table->date('fecha_final');
            $table->unsignedBigInteger('campein_id');
            $table->timestamps();
            $table->foreign('campein_id')->references('id')->on('campeins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
};
