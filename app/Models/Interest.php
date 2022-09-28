<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasFactory;
    protected $table = "Interests";

    // protected $fillable = [
    //     'nombre',
    // ];

    public function prospects()
    {
        return $this->hasMany(Prospect::class);
    }
}
