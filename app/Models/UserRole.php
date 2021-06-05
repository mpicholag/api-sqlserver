<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $table = 'user_role';

    protected $fillable = [
        'role_id',
        'user_id',
        'created_at',
    ];

    public function role() {
        return $this->belongsTo(Role::class, 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id');
    }
}
