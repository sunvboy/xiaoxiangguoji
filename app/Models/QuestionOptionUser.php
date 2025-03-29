<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOptionUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',  'quiz_id', 'question_options', 'essays', 'files', 'pause', 'timer',  'customer_id',
        'created_at',
        'updated_at',
        'score_experience',
        'score_essay',
        'score_speak',
        'score_total',
        'experience_note',
        'essay_note',
        'speak_note',
        'status',
        'words',
        'name',
        'phone',
        'email',
    ];
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
    public function quizzes()
    {
        return $this->hasOne(Quiz::class, 'id', 'quiz_id');
    }
}
