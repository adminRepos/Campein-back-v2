<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;
    protected $table = "prospects";

    // protected $fillable = [
    //     'codigo',
    //     'identificacion',
    //     'email',
    //     'telefono',
    //     'primer_nombre',
    //     'primer_apellido',
    //     'fecha_nacimiento',
    //     'direccion',
    //     'rol_id',
    //     'user_id'
    // ];

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function interest()
    {
        return $this->belongsTo(Interest::class);
    }

    public function causa()
    {
        return $this->belongsTo(Causa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
