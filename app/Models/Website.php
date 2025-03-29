<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'keyword',
        'template',
        'image',
        'order',
        'userid_created',
        'userid_updated',
        'created_at',
        'updated_at',
    ];
}
