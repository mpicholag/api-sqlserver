<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'document';

    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'sub_category_id',
        'registry_id',
        'title',
        'description',
        'firm_date',
        'renovation_date',
        'expiration_date',
        'path_document',
        'notify'
    ];
}
