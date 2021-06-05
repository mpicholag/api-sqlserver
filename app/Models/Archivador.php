<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivador extends Model
{
    use HasFactory;

    protected $table = 'archivador';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'status'
    ];
}
