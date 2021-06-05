<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentHistory extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'document_history';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'document_id',
        'address',
        'status',
        'description'
    ];
}
