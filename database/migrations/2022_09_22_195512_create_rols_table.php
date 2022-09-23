<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('rol', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',45)->nullable(false)->unique(true);   
            $table->timestamps();
        });

        DB::table('rol')->insert(["nombre" => "Super Admin","created_at" =>  \Carbon\Carbon::now(),"updated_at" => \Carbon\Carbon::now() ]);
        DB::table('rol')->insert(["nombre" => "Administrador Campaña","created_at" =>  \Carbon\Carbon::now(),"updated_at" => \Carbon\Carbon::now()  ]);
        DB::table('rol')->insert(["nombre" => "Lider Zonal","created_at" =>  \Carbon\Carbon::now(),"updated_at" => \Carbon\Carbon::now()  ]);
        DB::table('rol')->insert(["nombre" => "Multiplicador","created_at" =>  \Carbon\Carbon::now(),"updated_at" => \Carbon\Carbon::now()  ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rol');
    }
};
