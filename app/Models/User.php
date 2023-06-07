<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'email',
        'nombre',
        'apellido',
        'identificacion',
        'genero',
        'telefono',
        'whatsapp',
        'activo',
        'password',
        'direccion',
        'rol_id',
        'app_rol_id',
        'image',
        'fecha_nacimiento',
        'id_formulario'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function campeings() {
        return $this->belongsToMany(Campeign::class);
    }

    public function zonas() {
        return $this->belongsToMany(Zone::class);
    }

    public function prospects()
    {
        return $this->hasMany(Prospect::class);
    }
}
