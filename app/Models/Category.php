<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'category';

    protected $fillable = [
        'id',
        'registry_id',
        'name',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];
}
