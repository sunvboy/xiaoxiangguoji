<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'customer_id', 'question_option_user_id', 'user_id', 'created_at', 'updated_at', 'view'];
    public function QuestionOptionUser()
    {
        return $this->hasOne(QuestionOptionUser::class, 'id', 'question_option_user_id');
    }
}
