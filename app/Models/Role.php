<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "roles";

    // protected $fillable = [
    //     'nombre',
    //     'nombre_publico',
    //     'descripcion'
    // ];

    public function prospects()
    {
        return $this->hasMany(Prospect::class);
    }
}
