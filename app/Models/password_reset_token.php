<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class password_reset_token extends Model
{
    use HasFactory;
    public $primaryKey='email';
    public $timestamps = false;
    protected $fillable=[
        'name',
        'email',
        'token',
        'created_at',
    ];
}
