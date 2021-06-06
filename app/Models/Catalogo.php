<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    use HasFactory, Notifiable;
    public $timestamps = false;

    protected $table = 'CATALOGO_DIRECCION';

    protected $primaryKey = 'ID_CATALOGO';

    protected $fillable = [
        'ID_CATALOGO',
        'NUM_CASA',
        'CIUDAD',
        'COLONIA',
        'CODIGO_POSTAL',
        'DEPARTAMENTO',
        'MUNICIPIO',
        'ESTADO'
    ];
}
