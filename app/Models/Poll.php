<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;
    protected $table = "polls";

    // protected $fillable = [
    //     'titulo',
    //     'fecha_aplicacion',
    //     'prospecto_id',
    // ];

    public function prospect()
    {
        return $this->belongsTo(Prospect::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
