<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'module', 'data', 'created_at', 'updated_at'
    ];
}
