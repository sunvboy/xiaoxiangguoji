<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseChapter extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'count', 'course_id', 'created_at', 'updated_at'
    ];
    public function course_lessons()
    {
        return $this->hasMany(CourseLesson::class);
    }
}
