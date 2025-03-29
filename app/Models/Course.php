<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage', 'title', 'slug', 'code', 'image', 'course_category_id', 'description',  'order', 'publish', 'ishome', 'highlight', 'isaside', 'isfooter', 'meta_title', 'meta_description', 'meta_keyword', 'user_id', 'created_at', 'updated_at', 'price', 'price_sale', 'price_contact', 'version_json'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function relationships()
    {
        return $this->hasMany(Catalogues_relationships::class, 'moduleid');
    }
    public function course_lessons()
    {
        return $this->hasMany(CourseLesson::class);
    }
    public function course_chapters()
    {
        return $this->hasMany(CourseChapter::class, 'course_id');
    }
    public function catalogues()
    {
        return $this->hasOne(CourseCategory::class, 'id', 'course_category_id');
    }
    public function field()
    {
        return $this->hasOne(ConfigPostmeta::class, 'module_id')->where(['module' => 'courses']);
    }
    public function fields()
    {
        return $this->hasMany(ConfigPostmeta::class, 'module_id')->where(['module' => 'courses']);
    }
}
