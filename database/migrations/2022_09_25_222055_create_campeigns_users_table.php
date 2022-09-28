<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('campeign_user', function (Blueprint $table) {
            $table->unsignedBigInteger('campeign_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('campeign_id')
                ->references('id')
                ->on('campeigns')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campeign_user');
    }
};
