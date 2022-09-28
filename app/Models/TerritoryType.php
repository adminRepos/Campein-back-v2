<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerritoryType extends Model
{
    use HasFactory;

    protected $table = "territory_types";

    // protected $fillable = [
    //     'tipo'
    // ];

    public function territories() {
        return $this->hasMany(Territory::class);
    }

    public function subTerritories() {
        return $this->hasMany(SubTerritory::class);
    }
}
