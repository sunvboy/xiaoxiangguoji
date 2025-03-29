<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizConfig extends Model
{
    use HasFactory;
    protected $fillable = [
        'experience', 'speak', 'essay', 'mark_experience', 'created_at',  'updated_at'
    ];
}
