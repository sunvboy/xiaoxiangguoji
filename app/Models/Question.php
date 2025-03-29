<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'type', 'title', 'description', 'quiz_id', 'created_at',  'updated_at', 'user_id', 'deleted_at', 'file'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function question_options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
