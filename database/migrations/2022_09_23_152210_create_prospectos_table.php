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
        Schema::create('prospectos', function (Blueprint $table) {
            $table->id();
            $table->char('genero',1)->nullable(false);
            $table->string('foto',120)->nullable(false)->unique(true);
            $table->string('identificacion',16)->nullable(false)->unique(true);
            $table->string('primer_nombre',16)->nullable(false);
            $table->string('segundo_nombre',16);
            $table->string('primer_apellido',16);
            $table->string('segundo_apellido',16);
            $table->date('fecha_nacimiento')->nullable(false);
            $table->string('direccion',120)->nullable(false);
            $table->string('email',60)->nullable(false)->unique(true);
            $table->string('telefono',16)->unique(true);
            $table->string('telefono_alternativo',16)->nullable(true);
            $table->integer('puesto_votacion');
            $table->unsignedBigInteger('tipo_id')->nullable(false);
            $table->unsignedBigInteger('gruposinteres_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('zona_id')->nullable(false);
            $table->timestamps();

            $table->foreign('tipo_id')->references('id')->on('tipo_prospectos');
            $table->foreign('gruposinteres_id')->references('id')->on('grupos_interes');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('prospectos');
    }
};
