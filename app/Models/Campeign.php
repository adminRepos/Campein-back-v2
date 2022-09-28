<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campeign extends Model
{
    use HasFactory;

    protected $table = "campeigns";

    // protected $fillable = [
    //     'nombre',
    //     'email',
    //     'pais_id',
    //     'partido_id'
    // ];

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
