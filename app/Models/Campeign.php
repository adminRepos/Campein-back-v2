<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campeign extends Model
{
    use HasFactory;

    protected $table = "campeigns";

    protected $fillable = [
        'id', 
        'nombre', 
        'lema', 
        'url', 
        'mision', 
        'vision', 
        'email', 
        'activo', 
        'pais_id', 
        'created_at', 
        'updated_at', 
        'pass_email', 
        'meta'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function partido()
    {
        return $this->belongsTo(Partido::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
