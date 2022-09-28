<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = "questions";

    // protected $fillable = [
    //     'pregunta',
    //     'encuesta_id',
    // ];

    // protected $casts = [
    //     'id' => 'integer',
    //     'encuesta_id' => 'integer',
    // ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
