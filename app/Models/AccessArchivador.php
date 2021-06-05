<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessArchivero extends Model
{
    use HasFactory;

    protected $table = 'access_archivador';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'archivador_id'
    ];
}
