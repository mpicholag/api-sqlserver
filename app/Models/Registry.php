<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'registry';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'address'
    ];
}
