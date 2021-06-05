<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'subcategory';

    protected $fillable = [
        'id',
        'category_id',
        'name',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];
}
