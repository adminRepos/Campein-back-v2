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
        Schema::table('users', function (Blueprint $table) {
            $table->string("identificacion",45)->nullable(false)->unique();
            $table->char("genero",1)->nullable(false);
            $table->string("apellidos",40)->nullable(false);
            $table->date("fecha_nacimiento")->nullable(false);
            $table->string("direccion",60)->nullable(false);
            $table->string("telefono_principal",16)->nullable(false)->unique();
            $table->string("telefono_alterno",16);
            $table->unsignedBigInteger('rol_id');
            $table->foreign('rol_id')->references('id')->on('rol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
