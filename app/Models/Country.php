<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = "countries";

    // protected $fillable = [
    //     'codigo',
    //     'nombre',
    //     'votantes'
    // ];

    public function territorios() {
        return $this->hasMany(Territory::class);
    }

    public function campeigns() {
        return $this->hasMany(Campeign::class);
    }
}
