<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('territory_types', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 40)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('territory_types');
    }
};
