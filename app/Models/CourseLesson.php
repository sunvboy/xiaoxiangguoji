<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'slug', 'link', 'course_id', 'course_chapter_id',  'created_at', 'updated_at'
    ];
}
