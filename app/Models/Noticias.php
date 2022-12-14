<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticias extends Model
{
    use HasFactory;

    protected $table = "noticias";

    protected $fillable = [
        'id',
        'id_user_send',
        'titulo',
        'imagen',
        'url',
        'mensaje',
    ];


}

?>