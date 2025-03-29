<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage', 'title', 'slug', 'image',  'order', 'publish', 'ishome', 'highlight', 'isaside', 'isfooter', 'description', 'truong_khoa', 'nhan_luc', 'meta_title', 'meta_description', 'meta_keyword', 'user_id', 'created_at', 'updated_at'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function faculty_categories()
    {
        return $this->hasOne(FacultyCategory::class, 'id', 'faculty_category_id');
    }
}
