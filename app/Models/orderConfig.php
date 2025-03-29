<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderConfig extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'image', 'publish', 'config', 'order', 'created_at', 'updated_at'];
}
