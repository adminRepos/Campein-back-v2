<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;
    protected $table = "partidos";

    // protected $fillable = [
    //     'codigo',
    //     'nombre',
    //     'estado'
    // ];

    public function campeigns() {
        return $this->hasMany(Campeign::class);
    }
}
