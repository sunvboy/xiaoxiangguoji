<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizCustomerCategory extends Model
{
    use HasFactory;
    public function quizzes()
    {
        return $this->hasOne(Quiz::class, 'id', 'quiz_id');
    }
    public function customer_categories()
    {
        return $this->hasOne(CustomerCategory::class, 'id', 'customer_category_id');
    }
}
