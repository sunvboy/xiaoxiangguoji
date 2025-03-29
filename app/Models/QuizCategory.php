<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage', 'title', 'slug', 'image', 'banner', 'parentid',  'order', 'publish', 'ishome', 'highlight', 'isaside', 'isfooter', 'lft', 'rgt', 'level', 'description', 'meta_title', 'meta_description', 'meta_keyword', 'user_id', 'created_at', 'updated_at'
    ];
    public function quizzes()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid')->where('module', '=', 'quizzes');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
