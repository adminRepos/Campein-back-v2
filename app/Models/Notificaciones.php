<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    use HasFactory;

    protected $table = "campeigns";

    protected $fillable = [
        'id',
        'id_user_send',
        'image',
        'titulo',
        'mensaje',
        'tipo_user',
        'url'
    ];


}

?>