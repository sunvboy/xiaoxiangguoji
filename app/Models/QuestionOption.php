<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'order', 'characters', 'title', 'isTrue', 'question_id',  'created_at', 'updated_at',
        'deleted_at', 'description'
    ];
}
