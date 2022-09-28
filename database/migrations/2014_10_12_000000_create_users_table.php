<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 60)->index()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->index();
            $table->char('genero', 1)->default('F');
            $table->string('nombre', 35)->nullable();
            $table->string('apellido', 35)->nullable();
            $table->string('identificacion', 16)->unique();
            $table->timestamp('fecha_nacimiento')->nullable();
            $table->string('direccion', 120)->nullable();
            $table->string('telefono', 16)->unique();
            $table->string('telefono_alterno', 16)->nullable();
            $table->unsignedBigInteger('lider')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->unsignedBigInteger('causa_id')->nullable();
            $table->foreign('causa_id')->references('id')->on('causas');
            $table->unsignedBigInteger('interest_id')->nullable();
            $table->foreign('interest_id')->references('id')->on('interests');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
