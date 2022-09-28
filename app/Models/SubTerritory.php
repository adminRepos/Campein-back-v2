<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTerritory extends Model
{
    use HasFactory;

    protected $table = "subterritory";

    // protected $fillable = [
    //     'codigo',
    //     'nombre',
    //     'territorio_id',
    //     'tipo_territorio_id'
    // ];

    public function territory()
    {
        return $this->belongsTo(Territory::class);
    }

    public function territoryType()
    {
        return $this->belongsTo(TerritoryType::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
