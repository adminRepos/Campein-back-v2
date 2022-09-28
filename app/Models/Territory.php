<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Territory extends Model
{
    use HasFactory;

    protected $table = "territory";

    // protected $fillable = [
    //     'nombre',
    //     'tipoterritorio_id',
    //     'pais_id',
    // ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function territoryType()
    {
        return $this->belongsTo(TerritoryType::class);
    }

    public function subTerritory()
    {
        return $this->hasMany(SubTerritory::class);
    }
}
