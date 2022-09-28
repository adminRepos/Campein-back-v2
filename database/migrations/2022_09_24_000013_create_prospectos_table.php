<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prospects', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 16)->unique()->index();
            $table->string('foto', 120)->nullable();
            $table->char('genero', 1)->default('F');
            $table->string('identificacion', 16)->unique()->index();
            $table->string('primer_nombre', 20);
            $table->string('segundo_nombre', 20)->nullable();
            $table->string('primer_apellido', 20);
            $table->string('segundo_apellido', 20)->nullable();
            $table->timestamp('fecha_nacimiento');
            $table->string('direccion', 120);
            $table->string('email', 60)->unique();
            $table->string('telefono', 16)->unique();
            $table->string('telefono_alternativo', 16)->nullable();
            $table->integer('puesto_votacion')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('causa_id')->nullable();
            $table->unsignedBigInteger('interest_id')->nullable();
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('restrict');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            $table->foreign('causa_id')
                ->references('id')
                ->on('causas');
            $table->foreign('interest_id')
                ->references('id')
                ->on('interests');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prospects');
    }
};
