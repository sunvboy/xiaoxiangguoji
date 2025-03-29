<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'time',
        'prerequisites',
        'customer_category',
        'title',
        'catalogue_id',
        'catalogue',
        'slug',
        'code',
        'image',
        'description',
        'order',
        'publish',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'user_id',
        'created_at',
        'updated_at',
        'count_experience',
        'count_essay',
        'count_speak',
        'mark_experience',
        'customer_levels',
        'score',
        'articles',
        'products',
        'mien_tru',
        'video',
        'thap_title',
        'thap_description',
        'thap_content',
        'cao_title',
        'cao_description',
        'cao_content',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function relationships()
    {
        return $this->hasMany(Catalogues_relationships::class, 'moduleid');
    }
    public function catalogues()
    {
        return $this->hasOne(QuizCategory::class, 'id', 'catalogue_id');
    }
    public function quiz_questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
    public function question_option_users()
    {
        return $this->hasOne(QuestionOptionUser::class);
    }
}
