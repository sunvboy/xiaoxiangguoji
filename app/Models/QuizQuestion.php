<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'order', 'quiz_id', 'question_id', 'created_at', 'updated_at'
    ];
    public function questions()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }
}
