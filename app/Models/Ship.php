<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'image', 'URL_API', 'TOKEN_API', 'publish',  'userid_created', 'created_at', 'publish', 'order', 'userid_updated', 'updated_at'
    ];
}
